<?php

namespace App\Services\VNPay;

class VNPayQueryResult
{
    public function __construct(
        public bool $isSuccess,
        public string $responseCode,
        public string $transactionStatus,
        public string $message,
        public ?string $vnpTransactionNo = null,
        public ?string $bankCode = null,
        public ?string $payDate = null,
        public ?string $cardType = null,
        public float $amount = 0.0,
        public array $rawPayload = []
    ) {}

    /**
     * Transaction is confirmed as paid by VNPay.
     * ResponseCode = '00' and TransactionStatus = '00'
     */
    public function isPaid(): bool
    {
        return $this->responseCode === '00' && $this->transactionStatus === '00';
    }

    /**
     * Transaction was incomplete / still waiting for customer.
     */
    public function isPending(): bool
    {
        return $this->responseCode === '00' && $this->transactionStatus === '01';
    }

    /**
     * Transaction was cancelled or failed by customer/bank.
     */
    public function isFailed(): bool
    {
        return $this->transactionStatus === '02'
            || in_array($this->responseCode, ['24', '11', '12', '13', '51', '65', '75', '79', '99'], true);
    }

    /**
     * Transaction has refund processing or refunded status in VNPay.
     */
    public function isRefundProcessing(): bool
    {
        return in_array($this->transactionStatus, ['05', '06'], true);
    }

    public function isRefundRejected(): bool
    {
        return $this->transactionStatus === '09';
    }

    /**
     * Request is throttled / duplicate in VNPay Sandbox/Production.
     */
    public function isDuplicate(): bool
    {
        return $this->responseCode === '94';
    }

    /**
     * Transaction was not found on VNPay gateway.
     */
    public function isNotFound(): bool
    {
        return $this->responseCode === '91';
    }

    /**
     * Human-readable Vietnamese explanation of the VNPay QueryDr response.
     */
    public function getHumanMessage(): string
    {
        if ($this->responseCode === '00') {
            return match ($this->transactionStatus) {
                '00' => 'Giao dịch đã được thanh toán thành công trên cổng VNPay.',
                '01' => 'Giao dịch chưa hoàn tất (đang chờ khách hàng thanh toán trên cổng VNPay).',
                '02' => 'Giao dịch không thành công hoặc đã bị khách hàng hủy.',
                '04' => 'Giao dịch đã bị đảo / hủy thanh toán.',
                '05' => 'VNPay đang xử lý hoàn tiền cho giao dịch này.',
                '06' => 'VNPay đã gửi yêu cầu hoàn tiền sang Ngân hàng.',
                '07' => 'Giao dịch bị nghi ngờ gian lận.',
                '09' => 'Yêu cầu hoàn trả giao dịch bị từ chối.',
                default => "Trạng thái giao dịch VNPay: {$this->transactionStatus}",
            };
        }

        return match ($this->responseCode) {
            '02' => 'Mã định danh kết nối (VNPAY_TMN_CODE) không hợp lệ.',
            '03' => 'Dữ liệu gửi sang VNPay không đúng định dạng.',
            '91' => 'Không tìm thấy giao dịch này trên cổng VNPay (Mã 91). Khách hàng có thể chưa mở cổng thanh toán hoặc chưa hoàn tất thao tác.',
            '94' => 'Yêu cầu đối soát bị trùng lặp trên VNPay (Mã 94: Request is duplicated). Do VNPay giới hạn tần suất truy vấn cho cùng một giao dịch trong khoảng thời gian ngắn, vui lòng chờ 1-3 phút trước khi đối soát lại.',
            '97' => 'Chữ ký bảo mật không hợp lệ (Mã 97: Checksum failed). Kiểm tra lại VNPAY_HASH_SECRET.',
            '98' => 'Hệ thống VNPay đang bảo trì hoặc tạm thời gián đoạn kết nối.',
            default => $this->message ?: "Phản hồi từ cổng VNPay (Mã: {$this->responseCode})",
        };
    }
}
