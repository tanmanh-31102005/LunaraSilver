<?php

namespace App\Services\VNPay;

use App\Models\Payment;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use RuntimeException;

class VNPayService
{
    public function getTmnCode(): string
    {
        return (string) config('vnpay.tmn_code');
    }

    public function getHashSecret(): string
    {
        return (string) config('vnpay.hash_secret');
    }

    public function getPaymentUrl(): string
    {
        return (string) config('vnpay.url');
    }

    public function getApiUrl(): string
    {
        return (string) config('vnpay.api_url');
    }

    /**
     * Generate the redirect URL to VNPay Sandbox / Production gateway.
     */
    public function createPaymentUrl(Payment $payment, string $ipAddress = '127.0.0.1'): string
    {
        $order = $payment->order;
        if (! $order) {
            throw new RuntimeException("Cannot create VNPay URL for Payment #{$payment->id} without linked Order.");
        }

        $tmnCode = $this->getTmnCode();
        $hashSecret = $this->getHashSecret();

        if (empty($tmnCode) || empty($hashSecret)) {
            throw new RuntimeException('VNPay TMN_CODE or HASH_SECRET is not configured.');
        }

        $cleanIp = filter_var($ipAddress, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) ? $ipAddress : '127.0.0.1';

        // VNPay strictly requires timestamps in Asia/Ho_Chi_Minh (GMT+7)
        $nowVn = Carbon::now('Asia/Ho_Chi_Minh');
        $createDate = $nowVn->format('YmdHis');
        $expireDate = $nowVn->copy()->addMinutes(15)->format('YmdHis');

        // Always save fresh GMT+7 create date to the payment attempt
        $payment->vnp_create_date = $createDate;
        $payment->save();

        $returnUrl = config('vnpay.return_url') ?: route('payment.vnpay.return');

        $vnpParams = [
            'vnp_Version' => config('vnpay.version', '2.1.0'),
            'vnp_TmnCode' => $tmnCode,
            'vnp_Amount' => (int) round(((float) $payment->amount) * 100),
            'vnp_Command' => 'pay',
            'vnp_CreateDate' => $createDate,
            'vnp_CurrCode' => config('vnpay.currency', 'VND'),
            'vnp_IpAddr' => $cleanIp,
            'vnp_Locale' => config('vnpay.locale', 'vn'),
            'vnp_OrderInfo' => "Thanh toan don hang {$order->order_code} tai Lunara Silver",
            'vnp_OrderType' => 'other',
            'vnp_ReturnUrl' => $returnUrl,
            'vnp_TxnRef' => (string) $payment->txn_ref,
            'vnp_ExpireDate' => $expireDate,
        ];

        ksort($vnpParams);

        $query = '';
        $hashData = '';
        $i = 0;
        foreach ($vnpParams as $key => $value) {
            if ($i === 1) {
                $hashData .= '&' . urlencode((string) $key) . '=' . urlencode((string) $value);
            } else {
                $hashData .= urlencode((string) $key) . '=' . urlencode((string) $value);
                $i = 1;
            }
            $query .= urlencode((string) $key) . '=' . urlencode((string) $value) . '&';
        }

        $secureHash = hash_hmac('sha512', $hashData, $hashSecret);
        $vnpUrl = $this->getPaymentUrl() . '?' . $query . 'vnp_SecureHash=' . $secureHash;

        // Temporary safe logging for audit and debugging (never logs HashSecret)
        Log::info('VNPay createPaymentUrl generated', [
            'txn_ref' => (string) $payment->txn_ref,
            'vnp_CreateDate' => $createDate,
            'vnp_ExpireDate' => $expireDate,
            'current_gmt7' => $nowVn->format('Y-m-d H:i:s'),
            'order_code' => $order->order_code,
            'amount' => $payment->amount,
        ]);

        return $vnpUrl;
    }

    /**
     * Verify the return / IPN checksum signature from VNPay.
     *
     * @param array<string, mixed> $params
     */
    public function verifyReturnChecksum(array $params): bool
    {
        $vnpSecureHash = $params['vnp_SecureHash'] ?? null;
        if (empty($vnpSecureHash)) {
            return false;
        }

        $hashSecret = $this->getHashSecret();
        if (empty($hashSecret)) {
            return false;
        }

        $vnpData = [];
        foreach ($params as $key => $value) {
            if (str_starts_with($key, 'vnp_') && $key !== 'vnp_SecureHash' && $key !== 'vnp_SecureHashType') {
                $vnpData[$key] = $value;
            }
        }

        ksort($vnpData);

        $hashData = '';
        $i = 0;
        foreach ($vnpData as $key => $value) {
            if ($i === 1) {
                $hashData .= '&' . urlencode((string) $key) . '=' . urlencode((string) $value);
            } else {
                $hashData .= urlencode((string) $key) . '=' . urlencode((string) $value);
                $i = 1;
            }
        }

        $calculatedHash = hash_hmac('sha512', $hashData, $hashSecret);

        return hash_equals($calculatedHash, (string) $vnpSecureHash);
    }

    /**
     * Query transaction status directly from VNPay via QueryDr WebAPI.
     */
    public function queryTransaction(Payment $payment, string $ipAddress = '127.0.0.1'): VNPayQueryResult
    {
        $tmnCode = $this->getTmnCode();
        $hashSecret = $this->getHashSecret();
        $apiUrl = $this->getApiUrl();

        if (empty($tmnCode) || empty($hashSecret) || empty($apiUrl)) {
            return new VNPayQueryResult(
                isSuccess: false,
                responseCode: '99',
                transactionStatus: '99',
                message: 'VNPay configuration missing or incomplete.',
            );
        }

        // VNPay WebAPI requires alphanumeric unique RequestId (max 32 chars, typically date + random digits)
        $requestId = date('YmdHis') . str_pad((string) random_int(1, 999999), 6, '0', STR_PAD_LEFT);
        $cleanIp = filter_var($ipAddress, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) ? $ipAddress : '127.0.0.1';
        $version = config('vnpay.version', '2.1.0');
        $command = 'querydr';
        $txnRef = (string) $payment->txn_ref;
        $orderInfo = 'Truy van don hang ' . ($payment->order?->order_code ?? $txnRef);
        $nowVn = Carbon::now('Asia/Ho_Chi_Minh');
        $transactionDate = (string) ($payment->vnp_create_date ?: $nowVn->format('YmdHis'));
        $createDate = $nowVn->format('YmdHis');

        // Checksum data format according to VNPay QueryDr 2.1.0:
        // $vnp_RequestId . '|' . $vnp_Version . '|' . $vnp_Command . '|' . $vnp_TmnCode . '|' . $vnp_TxnRef . '|' . $vnp_TransactionDate . '|' . $vnp_CreateDate . '|' . $vnp_IpAddr . '|' . $vnp_OrderInfo
        $hashData = $requestId . '|' . $version . '|' . $command . '|' . $tmnCode . '|' . $txnRef . '|' . $transactionDate . '|' . $createDate . '|' . $cleanIp . '|' . $orderInfo;
        $secureHash = hash_hmac('sha512', $hashData, $hashSecret);

        $payload = [
            'vnp_RequestId' => $requestId,
            'vnp_Version' => $version,
            'vnp_Command' => $command,
            'vnp_TmnCode' => $tmnCode,
            'vnp_TxnRef' => $txnRef,
            'vnp_OrderInfo' => $orderInfo,
            'vnp_TransactionDate' => $transactionDate,
            'vnp_CreateDate' => $createDate,
            'vnp_IpAddr' => $cleanIp,
            'vnp_SecureHash' => $secureHash,
        ];

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ])->timeout(15)->post($apiUrl, $payload);

            if (! $response->successful()) {
                Log::warning('VNPay QueryDr HTTP error', [
                    'payment_id' => $payment->id,
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);

                return new VNPayQueryResult(
                    isSuccess: false,
                    responseCode: '98',
                    transactionStatus: '98',
                    message: "VNPay server returned HTTP status {$response->status()}",
                    rawPayload: ['http_status' => $response->status(), 'response' => $response->body()]
                );
            }

            $json = $response->json();
            if (! is_array($json)) {
                return new VNPayQueryResult(
                    isSuccess: false,
                    responseCode: '99',
                    transactionStatus: '99',
                    message: 'Invalid JSON response from VNPay QueryDr.',
                    rawPayload: ['raw_body' => $response->body()]
                );
            }

            $responseCode = (string) ($json['vnp_ResponseCode'] ?? '99');
            $transactionStatus = (string) ($json['vnp_TransactionStatus'] ?? '99');
            $message = (string) ($json['vnp_Message'] ?? 'Không có thông điệp từ VNPay');
            $amount = isset($json['vnp_Amount']) ? ((float) $json['vnp_Amount']) / 100 : 0.0;
            $transactionNo = isset($json['vnp_TransactionNo']) ? (string) $json['vnp_TransactionNo'] : null;
            $bankCode = isset($json['vnp_BankCode']) ? (string) $json['vnp_BankCode'] : null;
            $payDate = isset($json['vnp_PayDate']) ? (string) $json['vnp_PayDate'] : null;
            $cardType = isset($json['vnp_CardType']) ? (string) $json['vnp_CardType'] : null;

            return new VNPayQueryResult(
                isSuccess: $responseCode === '00',
                responseCode: $responseCode,
                transactionStatus: $transactionStatus,
                message: $message,
                vnpTransactionNo: $transactionNo,
                bankCode: $bankCode,
                payDate: $payDate,
                cardType: $cardType,
                amount: $amount,
                rawPayload: $json
            );
        } catch (\Throwable $e) {
            Log::error('VNPay QueryDr Exception: ' . $e->getMessage(), [
                'payment_id' => $payment->id,
                'trace' => $e->getTraceAsString(),
            ]);

            return new VNPayQueryResult(
                isSuccess: false,
                responseCode: '98',
                transactionStatus: '98',
                message: 'Exception during QueryDr: ' . $e->getMessage(),
                rawPayload: ['error' => $e->getMessage()]
            );
        }
    }

    /**
     * Submit refund request to VNPay WebAPI.
     *
     * @param string $refundType 'full' or 'partial'
     */
    public function refund(
        Payment $payment,
        float $amount,
        string $refundType,
        string $createBy,
        string $reason,
        string $ipAddress = '127.0.0.1'
    ): VNPayRefundResult {
        $tmnCode = $this->getTmnCode();
        $hashSecret = $this->getHashSecret();
        $apiUrl = $this->getApiUrl();

        if (empty($tmnCode) || empty($hashSecret) || empty($apiUrl)) {
            return new VNPayRefundResult(
                isSuccess: false,
                responseCode: '99',
                message: 'VNPay configuration missing or incomplete.',
            );
        }

        // VNPay WebAPI requires alphanumeric unique RequestId (max 32 chars)
        $requestId = date('YmdHis') . str_pad((string) random_int(1, 999999), 6, '0', STR_PAD_LEFT);
        $cleanIp = filter_var($ipAddress, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) ? $ipAddress : '127.0.0.1';
        $version = config('vnpay.version', '2.1.0');
        $command = 'refund';
        $vnpTransactionType = ($refundType === 'full') ? '02' : '03';
        $txnRef = (string) $payment->txn_ref;
        $vnpAmount = (int) round($amount * 100);
        $transactionNo = (string) ($payment->vnp_transaction_no ?: '0');
        $nowVn = Carbon::now('Asia/Ho_Chi_Minh');
        $transactionDate = (string) ($payment->vnp_create_date ?: $nowVn->format('YmdHis'));
        $createDate = $nowVn->format('YmdHis');

        // Checksum data format according to VNPay Refund 2.1.0:
        // $vnp_RequestId . '|' . $vnp_Version . '|' . $vnp_Command . '|' . $vnp_TmnCode . '|' . $vnp_TransactionType . '|' . $vnp_TxnRef . '|' . $vnp_Amount . '|' . $vnp_TransactionNo . '|' . $vnp_TransactionDate . '|' . $vnp_CreateBy . '|' . $vnp_CreateDate . '|' . $vnp_IpAddr . '|' . $vnp_OrderInfo
        $hashData = $requestId . '|' . $version . '|' . $command . '|' . $tmnCode . '|' . $vnpTransactionType . '|' . $txnRef . '|' . $vnpAmount . '|' . $transactionNo . '|' . $transactionDate . '|' . $createBy . '|' . $createDate . '|' . $cleanIp . '|' . $reason;
        $secureHash = hash_hmac('sha512', $hashData, $hashSecret);

        $payload = [
            'vnp_RequestId' => $requestId,
            'vnp_Version' => $version,
            'vnp_Command' => $command,
            'vnp_TmnCode' => $tmnCode,
            'vnp_TransactionType' => $vnpTransactionType,
            'vnp_TxnRef' => $txnRef,
            'vnp_Amount' => $vnpAmount,
            'vnp_OrderInfo' => $reason,
            'vnp_TransactionNo' => $transactionNo,
            'vnp_TransactionDate' => $transactionDate,
            'vnp_CreateBy' => $createBy,
            'vnp_CreateDate' => $createDate,
            'vnp_IpAddr' => $cleanIp,
            'vnp_SecureHash' => $secureHash,
        ];

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ])->timeout(20)->post($apiUrl, $payload);

            if (! $response->successful()) {
                Log::warning('VNPay Refund HTTP error', [
                    'payment_id' => $payment->id,
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);

                return new VNPayRefundResult(
                    isSuccess: false,
                    responseCode: '98',
                    message: "VNPay server returned HTTP status {$response->status()}",
                    rawPayload: ['http_status' => $response->status(), 'response' => $response->body()]
                );
            }

            $json = $response->json();
            if (! is_array($json)) {
                return new VNPayRefundResult(
                    isSuccess: false,
                    responseCode: '99',
                    message: 'Invalid JSON response from VNPay Refund WebAPI.',
                    rawPayload: ['raw_body' => $response->body()]
                );
            }

            $responseCode = (string) ($json['vnp_ResponseCode'] ?? '99');
            $message = VNPayRefundResult::getResponseMessage($responseCode);
            $vnpTransactionNo = isset($json['vnp_TransactionNo']) ? (string) $json['vnp_TransactionNo'] : null;
            $resTransactionType = isset($json['vnp_TransactionType']) ? (string) $json['vnp_TransactionType'] : null;
            $resTransactionStatus = isset($json['vnp_TransactionStatus']) ? (string) $json['vnp_TransactionStatus'] : null;

            return new VNPayRefundResult(
                isSuccess: $responseCode === '00',
                responseCode: $responseCode,
                message: $message,
                vnpTransactionNo: $vnpTransactionNo,
                vnpTransactionType: $resTransactionType,
                vnpTransactionStatus: $resTransactionStatus,
                rawPayload: $json
            );
        } catch (\Throwable $e) {
            Log::error('VNPay Refund Exception: ' . $e->getMessage(), [
                'payment_id' => $payment->id,
                'trace' => $e->getTraceAsString(),
            ]);

            return new VNPayRefundResult(
                isSuccess: false,
                responseCode: '98',
                message: 'Exception during Refund: ' . $e->getMessage(),
                rawPayload: ['error' => $e->getMessage()]
            );
        }
    }
}
