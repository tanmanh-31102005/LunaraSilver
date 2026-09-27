<?php

namespace App\Services\VNPay;

class VNPayRefundResult
{
    public function __construct(
        public bool $isSuccess,
        public string $responseCode,
        public string $message,
        public ?string $vnpTransactionNo = null,
        public ?string $vnpTransactionType = null,
        public ?string $vnpTransactionStatus = null,
        public array $rawPayload = []
    ) {}

    /**
     * VNPay accepted refund request (ResponseCode = '00').
     */
    public function isAccepted(): bool
    {
        return $this->responseCode === '00';
    }

    /**
     * Map VNPay response code to human readable message in Vietnamese.
     */
    public static function getResponseMessage(string $code): string
    {
        return match ($code) {
            '00' => 'Yêu cầu hoàn tiền thành công.',
            '02' => 'Tổng số tiền hoàn lớn hơn số tiền giao dịch gốc.',
            '03' => 'Dữ liệu gửi sang không đúng định dạng.',
            '91' => 'Không tìm thấy giao dịch yêu cầu hoàn tiền.',
            '94' => 'Yêu cầu hoàn tiền đã tồn tại (trùng lặp).',
            '95' => 'Giao dịch này không thành công bên VNPay nên không thể hoàn tiền.',
            '97' => 'Chữ ký không hợp lệ (Checksum failed).',
            '98' => 'Timeout hoặc lỗi hệ thống xử lý phía VNPay.',
            '99' => 'Các lỗi khác từ hệ thống VNPay.',
            default => 'Lỗi xử lý hoàn tiền (Mã lỗi: ' . $code . ').',
        };
    }
}
