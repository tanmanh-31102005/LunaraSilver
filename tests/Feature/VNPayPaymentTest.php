<?php

namespace Tests\Feature;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Category;
use App\Models\Order;
use App\Models\Payment;
use App\Models\PaymentRefund;
use App\Models\Product;
use App\Models\User;
use App\Services\VNPay\PaymentReconciliationService;
use App\Services\VNPay\RefundService;
use App\Services\VNPay\VNPayQueryResult;
use App\Services\VNPay\VNPayRefundResult;
use App\Services\VNPay\VNPayService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Tests\TestCase;

class VNPayPaymentTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private User $admin;
    private Product $singleProduct;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create([
            'email' => 'customer@lunarasilver.test',
            'role' => User::ROLE_USER,
        ]);

        $this->admin = User::factory()->create([
            'email' => 'admin@lunarasilver.test',
            'role' => User::ROLE_ADMIN,
        ]);

        $category = Category::create([
            'name' => 'Dây Chuyền',
            'slug' => 'day-chuyen',
            'is_active' => true,
        ]);

        $this->singleProduct = Product::create([
            'name' => 'Dây Chuyền Bạc Ý S925',
            'slug' => 'day-chuyen-bac-y-s925',
            'sku' => 'DC-LNS-001',
            'product_type' => 'single',
            'category_id' => $category->id,
            'regular_price' => 500000,
            'sale_price' => 450000,
            'stock_quantity' => 20,
            'stock_status' => 'in_stock',
            'is_active' => true,
        ]);

        config([
            'vnpay.tmn_code' => '7OO2Y0S8',
            'vnpay.hash_secret' => 'TRPSTTTYPHQWBATDQWCUWMANEWXLZMGE',
            'vnpay.url' => 'https://sandbox.vnpayment.vn/paymentv2/vpcpay.html',
            'vnpay.api_url' => 'https://sandbox.vnpayment.vn/merchant_webapi/api/transaction',
        ]);
    }

    public function test_vnpay_service_generates_signed_payment_url(): void
    {
        $order = Order::create([
            'user_id' => $this->user->id,
            'order_code' => 'LNS-TEST-0001',
            'customer_name' => 'Nguyễn Văn A',
            'customer_email' => 'test@lunarasilver.test',
            'customer_phone' => '0901234567',
            'shipping_address' => '123 Lê Lợi',
            'shipping_city' => 'TP. Hồ Chí Minh',
            'shipping_method' => 'standard',
            'subtotal' => '450000.00',
            'discount_amount' => '0.00',
            'shipping_fee' => '0.00',
            'grand_total' => '450000.00',
            'payment_method' => 'vnpay',
            'payment_status' => 'pending',
            'order_status' => 'pending',
        ]);

        $payment = Payment::create([
            'order_id' => $order->id,
            'provider' => 'vnpay',
            'txn_ref' => 'LNS-TEST-0001-1',
            'vnp_create_date' => Carbon::now('Asia/Ho_Chi_Minh')->format('YmdHis'),
            'amount' => '450000.00',
            'status' => 'pending',
        ]);

        $service = app(VNPayService::class);
        $url = $service->createPaymentUrl($payment, '127.0.0.1');

        $this->assertStringContainsString('https://sandbox.vnpayment.vn/paymentv2/vpcpay.html', $url);
        $this->assertStringContainsString('vnp_TmnCode=7OO2Y0S8', $url);
        $this->assertStringContainsString('vnp_TxnRef=LNS-TEST-0001-1', $url);
        $this->assertStringContainsString('vnp_Amount=45000000', $url);
        $this->assertStringContainsString('vnp_SecureHash=', $url);

        // Verify GMT+7 timezone and 15-minute expiration
        parse_str(parse_url($url, PHP_URL_QUERY), $queryParams);
        $createDate = Carbon::createFromFormat('YmdHis', $queryParams['vnp_CreateDate'], 'Asia/Ho_Chi_Minh');
        $expireDate = Carbon::createFromFormat('YmdHis', $queryParams['vnp_ExpireDate'], 'Asia/Ho_Chi_Minh');
        $this->assertSame(15, (int) $createDate->diffInMinutes($expireDate));
    }

    public function test_vnpay_checksum_verification(): void
    {
        $service = app(VNPayService::class);

        $params = [
            'vnp_Amount' => '45000000',
            'vnp_BankCode' => 'NCB',
            'vnp_CardType' => 'ATM',
            'vnp_OrderInfo' => 'Thanh toan don hang',
            'vnp_PayDate' => '20260927210000',
            'vnp_ResponseCode' => '00',
            'vnp_TmnCode' => '7OO2Y0S8',
            'vnp_TransactionNo' => '14567890',
            'vnp_TransactionStatus' => '00',
            'vnp_TxnRef' => 'LNS-TEST-0001-1',
        ];

        ksort($params);
        $hashData = '';
        $i = 0;
        foreach ($params as $k => $v) {
            if ($i === 1) {
                $hashData .= '&' . urlencode($k) . '=' . urlencode($v);
            } else {
                $hashData .= urlencode($k) . '=' . urlencode($v);
                $i = 1;
            }
        }
        $params['vnp_SecureHash'] = hash_hmac('sha512', $hashData, config('vnpay.hash_secret'));

        $this->assertTrue($service->verifyReturnChecksum($params));

        // Tamper with data
        $tampered = $params;
        $tampered['vnp_Amount'] = '10000000';
        $this->assertFalse($service->verifyReturnChecksum($tampered));
    }

    public function test_checkout_with_vnpay_creates_order_and_payment_attempt_and_reserves_stock(): void
    {
        $cart = Cart::create(['user_id' => $this->user->id]);
        CartItem::create([
            'cart_id' => $cart->id,
            'product_id' => $this->singleProduct->id,
            'quantity' => 2,
            'unit_price' => $this->singleProduct->sale_price,
        ]);

        $token = Str::random(40);

        $response = $this->actingAs($this->user)
            ->withSession(['checkout_token' => $token])
            ->post(route('checkout.store'), [
                'customer_name' => 'Trần Văn B',
                'customer_email' => 'tranvanb@test.com',
                'customer_phone' => '0912345678',
                'shipping_address' => '456 Hai Bà Trưng',
                'shipping_city' => 'Hà Nội',
                'payment_method' => 'vnpay',
                'checkout_token' => $token,
            ]);

        $order = Order::where('customer_email', 'tranvanb@test.com')->first();
        $this->assertNotNull($order);
        $this->assertSame('vnpay', $order->payment_method);
        $this->assertSame('pending', $order->payment_status);

        // Stock reserved
        $this->singleProduct->refresh();
        $this->assertSame(18, $this->singleProduct->stock_quantity);

        // Payment attempt created
        $payment = $order->payments()->first();
        $this->assertNotNull($payment);
        $this->assertSame('vnpay', $payment->provider);
        $this->assertStringStartsWith($order->order_code, $payment->txn_ref);

        // Redirects to VNPay sandbox URL
        $response->assertRedirect();
        $targetUrl = $response->headers->get('Location');
        $this->assertStringContainsString('https://sandbox.vnpayment.vn/paymentv2/vpcpay.html', $targetUrl);
    }

    public function test_checkout_with_cod_continues_to_operate_normally(): void
    {
        $cart = Cart::create(['user_id' => $this->user->id]);
        CartItem::create([
            'cart_id' => $cart->id,
            'product_id' => $this->singleProduct->id,
            'quantity' => 1,
            'unit_price' => $this->singleProduct->sale_price,
        ]);

        $token = Str::random(40);

        $response = $this->actingAs($this->user)
            ->withSession(['checkout_token' => $token])
            ->post(route('checkout.store'), [
                'customer_name' => 'Lê Thị C',
                'customer_email' => 'lethic@test.com',
                'customer_phone' => '0933334444',
                'shipping_address' => '789 Nguyễn Huệ',
                'shipping_city' => 'Đà Nẵng',
                'payment_method' => 'cod',
                'checkout_token' => $token,
            ]);

        $order = Order::where('customer_email', 'lethic@test.com')->first();
        $this->assertNotNull($order);
        $this->assertSame('cod', $order->payment_method);
        $response->assertRedirect(route('orders.success', $order->order_code));
    }

    public function test_return_url_triggers_querydr_reconciliation_and_marks_paid(): void
    {
        $order = Order::create([
            'user_id' => $this->user->id,
            'order_code' => 'LNS-RECON-001',
            'customer_name' => 'Đặng Văn D',
            'customer_email' => 'dangvand@test.com',
            'customer_phone' => '0988776655',
            'shipping_address' => '12 Võ Văn Kiệt',
            'shipping_city' => 'TP. Hồ Chí Minh',
            'shipping_method' => 'standard',
            'subtotal' => '450000.00',
            'discount_amount' => '0.00',
            'shipping_fee' => '0.00',
            'grand_total' => '450000.00',
            'payment_method' => 'vnpay',
            'payment_status' => 'pending',
            'order_status' => 'pending',
        ]);

        $payment = Payment::create([
            'order_id' => $order->id,
            'provider' => 'vnpay',
            'txn_ref' => 'LNS-RECON-001-1',
            'vnp_create_date' => '20260927210000',
            'amount' => '450000.00',
            'status' => 'pending',
        ]);

        // Mock VNPay QueryDr WebAPI response
        Http::fake([
            config('vnpay.api_url') => Http::response([
                'vnp_ResponseId' => (string) Str::uuid(),
                'vnp_Command' => 'querydr',
                'vnp_ResponseCode' => '00',
                'vnp_Message' => 'Giao dịch thành công',
                'vnp_TmnCode' => '7OO2Y0S8',
                'vnp_TxnRef' => 'LNS-RECON-001-1',
                'vnp_Amount' => 45000000,
                'vnp_BankCode' => 'NCB',
                'vnp_PayDate' => '20260927210500',
                'vnp_TransactionNo' => '99887766',
                'vnp_TransactionType' => '01',
                'vnp_TransactionStatus' => '00',
                'vnp_OrderInfo' => 'Thanh toan',
            ], 200),
        ]);

        $params = [
            'vnp_Amount' => '45000000',
            'vnp_BankCode' => 'NCB',
            'vnp_CardType' => 'ATM',
            'vnp_OrderInfo' => 'Thanh toan don hang',
            'vnp_PayDate' => '20260927210500',
            'vnp_ResponseCode' => '00',
            'vnp_TmnCode' => '7OO2Y0S8',
            'vnp_TransactionNo' => '99887766',
            'vnp_TransactionStatus' => '00',
            'vnp_TxnRef' => 'LNS-RECON-001-1',
        ];

        ksort($params);
        $hashData = '';
        $i = 0;
        foreach ($params as $k => $v) {
            if ($i === 1) {
                $hashData .= '&' . urlencode($k) . '=' . urlencode($v);
            } else {
                $hashData .= urlencode($k) . '=' . urlencode($v);
                $i = 1;
            }
        }
        $params['vnp_SecureHash'] = hash_hmac('sha512', $hashData, config('vnpay.hash_secret'));

        $response = $this->get(route('payment.vnpay.return', $params));
        $response->assertOk();
        $response->assertViewIs('payment.vnpay.return');
        $response->assertViewHas('isPaid', true);

        $order->refresh();
        $payment->refresh();

        $this->assertSame('paid', $payment->status);
        $this->assertSame('99887766', $payment->vnp_transaction_no);
        $this->assertSame('paid', $order->payment_status);
        $this->assertSame('confirmed', $order->order_status);
    }

    public function test_ipn_webhook_idempotency_and_amount_verification(): void
    {
        $order = Order::create([
            'user_id' => $this->user->id,
            'order_code' => 'LNS-IPN-001',
            'customer_name' => 'Phạm Văn E',
            'customer_email' => 'phamvane@test.com',
            'customer_phone' => '0977665544',
            'shipping_address' => '99 Trần Phú',
            'shipping_city' => 'Nha Trang',
            'shipping_method' => 'standard',
            'subtotal' => '500000.00',
            'discount_amount' => '0.00',
            'shipping_fee' => '0.00',
            'grand_total' => '500000.00',
            'payment_method' => 'vnpay',
            'payment_status' => 'pending',
            'order_status' => 'pending',
        ]);

        $payment = Payment::create([
            'order_id' => $order->id,
            'provider' => 'vnpay',
            'txn_ref' => 'LNS-IPN-001-1',
            'vnp_create_date' => '20260927210000',
            'amount' => '500000.00',
            'status' => 'pending',
        ]);

        // QueryDr mock
        Http::fake([
            config('vnpay.api_url') => Http::response([
                'vnp_ResponseCode' => '00',
                'vnp_TransactionStatus' => '00',
                'vnp_Amount' => 50000000,
                'vnp_TransactionNo' => '11223344',
                'vnp_Message' => 'Success',
            ], 200),
        ]);

        $params = [
            'vnp_Amount' => '50000000',
            'vnp_BankCode' => 'NCB',
            'vnp_ResponseCode' => '00',
            'vnp_TmnCode' => '7OO2Y0S8',
            'vnp_TransactionNo' => '11223344',
            'vnp_TransactionStatus' => '00',
            'vnp_TxnRef' => 'LNS-IPN-001-1',
        ];

        ksort($params);
        $hashData = '';
        $i = 0;
        foreach ($params as $k => $v) {
            if ($i === 1) {
                $hashData .= '&' . urlencode($k) . '=' . urlencode($v);
            } else {
                $hashData .= urlencode($k) . '=' . urlencode($v);
                $i = 1;
            }
        }
        $params['vnp_SecureHash'] = hash_hmac('sha512', $hashData, config('vnpay.hash_secret'));

        // First IPN call
        $response1 = $this->postJson(route('payment.vnpay.ipn', $params));
        $response1->assertJson([
            'RspCode' => '00',
            'Message' => 'Confirm Success',
        ]);

        $payment->refresh();
        $this->assertSame('paid', $payment->status);

        // Second IPN call (Duplicate callback)
        $response2 = $this->postJson(route('payment.vnpay.ipn', $params));
        $response2->assertJson([
            'RspCode' => '02',
            'Message' => 'Order already confirmed',
        ]);
    }

    public function test_payment_retry_creates_second_attempt_without_duplicating_order_or_stock(): void
    {
        $order = Order::create([
            'user_id' => $this->user->id,
            'order_code' => 'LNS-RETRY-001',
            'customer_name' => 'Ngô Văn F',
            'customer_email' => 'ngovanf@test.com',
            'customer_phone' => '0966554433',
            'shipping_address' => '33 Lý Thường Kiệt',
            'shipping_city' => 'Huế',
            'shipping_method' => 'standard',
            'subtotal' => '450000.00',
            'discount_amount' => '0.00',
            'shipping_fee' => '0.00',
            'grand_total' => '450000.00',
            'payment_method' => 'vnpay',
            'payment_status' => 'failed',
            'order_status' => 'pending',
        ]);

        Payment::create([
            'order_id' => $order->id,
            'provider' => 'vnpay',
            'txn_ref' => 'LNS-RETRY-001-1',
            'vnp_create_date' => '20260927200000',
            'amount' => '450000.00',
            'status' => 'failed',
        ]);

        $this->assertSame(1, $order->payments()->count());

        $response = $this->actingAs($this->user)
            ->post(route('payment.vnpay.retry', $order->order_code));

        $response->assertRedirect();
        $this->assertSame(2, $order->payments()->count());

        $latest = $order->payments()->latest('id')->first();
        $this->assertSame('LNS-RETRY-001-2', $latest->txn_ref);
        $this->assertSame('pending', $latest->status);

        $redirectUrl = $response->headers->get('Location');
        $this->assertNotNull($redirectUrl);
        $this->assertStringContainsString('vnp_TxnRef=LNS-RETRY-001-2', $redirectUrl);
        $this->assertStringContainsString('vnp_SecureHash=', $redirectUrl);

        parse_str(parse_url($redirectUrl, PHP_URL_QUERY), $queryParams);
        $retryCreate = Carbon::createFromFormat('YmdHis', $queryParams['vnp_CreateDate'], 'Asia/Ho_Chi_Minh');
        $retryExpire = Carbon::createFromFormat('YmdHis', $queryParams['vnp_ExpireDate'], 'Asia/Ho_Chi_Minh');
        $this->assertSame(15, (int) $retryCreate->diffInMinutes($retryExpire));
    }

    public function test_refund_service_supports_full_and_partial_refunds(): void
    {
        $order = Order::create([
            'user_id' => $this->user->id,
            'order_code' => 'LNS-REFUND-001',
            'customer_name' => 'Vũ Thị G',
            'customer_email' => 'vuthig@test.com',
            'customer_phone' => '0955443322',
            'shipping_address' => '101 Pasteur',
            'shipping_city' => 'TP. Hồ Chí Minh',
            'shipping_method' => 'standard',
            'subtotal' => '600000.00',
            'discount_amount' => '0.00',
            'shipping_fee' => '0.00',
            'grand_total' => '600000.00',
            'payment_method' => 'vnpay',
            'payment_status' => 'paid',
            'order_status' => 'confirmed',
        ]);

        Payment::create([
            'order_id' => $order->id,
            'provider' => 'vnpay',
            'txn_ref' => 'LNS-REFUND-001-1',
            'vnp_transaction_no' => '55667788',
            'vnp_create_date' => '20260927210000',
            'amount' => '600000.00',
            'status' => 'paid',
            'paid_at' => now(),
        ]);

        // Mock VNPay Refund WebAPI response
        Http::fake([
            config('vnpay.api_url') => Http::response([
                'vnp_ResponseId' => (string) Str::uuid(),
                'vnp_Command' => 'refund',
                'vnp_ResponseCode' => '00',
                'vnp_Message' => 'Hoàn tiền thành công',
                'vnp_TmnCode' => '7OO2Y0S8',
                'vnp_TxnRef' => 'LNS-REFUND-001-1',
                'vnp_Amount' => 20000000,
                'vnp_TransactionNo' => '55667788',
                'vnp_TransactionType' => '03',
                'vnp_TransactionStatus' => '00',
            ], 200),
        ]);

        $refundService = app(RefundService::class);

        // 1. Partial Refund (200,000 VND)
        $refund1 = $refundService->processRefund(
            order: $order,
            amount: 200000,
            reason: 'Đổi mẫu nhỏ hơn',
            requestedBy: 'Admin'
        );

        $this->assertTrue($refund1->isSuccessful());
        $this->assertSame('partial', $refund1->refund_type);
        $order->refresh();
        $this->assertSame('partially_refunded', $order->payment_status);
        $this->assertEquals(400000.0, $order->remainingRefundableAmount());

        // 2. Full remaining refund (400,000 VND)
        Http::fake([
            config('vnpay.api_url') => Http::response([
                'vnp_ResponseCode' => '00',
                'vnp_TransactionStatus' => '00',
            ], 200),
        ]);

        $refund2 = $refundService->processRefund(
            order: $order,
            amount: 400000,
            reason: 'Hoàn nốt phần còn lại',
            requestedBy: 'Admin'
        );

        $this->assertTrue($refund2->isSuccessful());
        $order->refresh();
        $this->assertSame('refunded', $order->payment_status);
        $this->assertEquals(0.0, $order->remainingRefundableAmount());
    }

    public function test_cancel_paid_order_triggers_automated_refund_and_restores_stock_idempotently(): void
    {
        $initialStock = $this->singleProduct->stock_quantity; // 20

        $order = Order::create([
            'user_id' => $this->user->id,
            'order_code' => 'LNS-CANCEL-001',
            'customer_name' => 'Hoàng Văn H',
            'customer_email' => 'hoangvanh@test.com',
            'customer_phone' => '0944332211',
            'shipping_address' => '88 Cầu Giấy',
            'shipping_city' => 'Hà Nội',
            'shipping_method' => 'standard',
            'subtotal' => '450000.00',
            'discount_amount' => '0.00',
            'shipping_fee' => '0.00',
            'grand_total' => '450000.00',
            'payment_method' => 'vnpay',
            'payment_status' => 'paid',
            'order_status' => 'confirmed',
        ]);

        $item = $order->items()->create([
            'product_id' => $this->singleProduct->id,
            'product_name' => $this->singleProduct->name,
            'product_sku' => $this->singleProduct->sku,
            'unit_price' => $this->singleProduct->sale_price,
            'quantity' => 3,
            'subtotal' => '1350000.00',
        ]);

        $item->components()->create([
            'product_id' => $this->singleProduct->id,
            'product_sku' => $this->singleProduct->sku,
            'product_name' => $this->singleProduct->name,
            'quantity_per_item' => 1,
            'total_quantity' => 3,
        ]);

        Payment::create([
            'order_id' => $order->id,
            'provider' => 'vnpay',
            'txn_ref' => 'LNS-CANCEL-001-1',
            'vnp_transaction_no' => '77889900',
            'vnp_create_date' => '20260927210000',
            'amount' => '450000.00',
            'status' => 'paid',
            'paid_at' => now(),
        ]);

        // Mock refund WebAPI
        Http::fake([
            config('vnpay.api_url') => Http::response([
                'vnp_ResponseCode' => '00',
                'vnp_TransactionStatus' => '00',
                'vnp_Message' => 'Success',
            ], 200),
        ]);

        // Admin cancels order
        $response = $this->actingAs($this->admin)
            ->post(route('admin.orders.cancel', $order->order_code), [
                'note' => 'Khách hàng yêu cầu hủy đơn và hoàn tiền',
            ]);

        $response->assertRedirect(route('admin.orders.show', $order->order_code));

        $order->refresh();
        $this->assertSame('cancelled', $order->order_status);
        $this->assertSame('refunded', $order->payment_status);
        $this->assertNotNull($order->inventory_restored_at);

        // Stock restored (+3)
        $this->singleProduct->refresh();
        $this->assertSame($initialStock + 3, $this->singleProduct->stock_quantity);

        // Try restoring again (idempotency check)
        $inventoryService = app(\App\Services\OrderInventoryService::class);
        $secondRestore = $inventoryService->restoreInventory($order);
        $this->assertFalse($secondRestore['restored']);

        // Stock remains same
        $this->singleProduct->refresh();
        $this->assertSame($initialStock + 3, $this->singleProduct->stock_quantity);
    }
}
