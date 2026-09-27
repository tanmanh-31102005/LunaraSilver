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
}
