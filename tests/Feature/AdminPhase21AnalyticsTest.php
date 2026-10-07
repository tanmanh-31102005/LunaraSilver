<?php

namespace Tests\Feature;

use App\Models\Address;
use App\Models\Category;
use App\Models\ContactMessage;
use App\Models\Coupon;
use App\Models\CouponUsage;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\PaymentRefund;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use App\Services\Admin\AnalyticsService;
use App\Services\Admin\AttentionService;
use App\Services\Admin\CustomerInsightsService;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminPhase21AnalyticsTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected User $customer;
    protected Category $category;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create([
            'email' => 'admin_phase21@lunara.vn',
            'role' => User::ROLE_ADMIN,
        ]);

        $this->customer = User::factory()->create([
            'name' => 'Nguyễn Văn A',
            'email' => 'khachhang@lunara.vn',
            'role' => User::ROLE_USER,
        ]);

        $this->category = Category::create([
            'name' => 'Dây Chuyền Bạc',
            'slug' => 'day-chuyen-bac',
            'is_active' => true,
        ]);
    }

    /**
     * Helper to create a single product.
     */
    protected function createProduct(array $attributes = []): Product
    {
        return Product::create(array_merge([
            'category_id' => $this->category->id,
            'sku' => 'SP-' . uniqid(),
            'name' => 'Sản phẩm Test',
            'slug' => 'san-pham-test-' . uniqid(),
            'product_type' => 'single',
            'regular_price' => 500000,
            'sale_price' => null,
            'stock_quantity' => 20,
            'stock_status' => 'in_stock',
            'is_active' => true,
        ], $attributes));
    }

    /**
     * Helper to create an order.
     */
    protected function createOrder(array $attributes = []): Order
    {
        return Order::create(array_merge([
            'user_id' => $this->customer->id,
            'order_code' => 'LNS-' . strtoupper(uniqid()),
            'customer_name' => $this->customer->name,
            'customer_email' => $this->customer->email,
            'customer_phone' => '0912345678',
            'shipping_address' => '123 Đường Bạc',
            'shipping_city' => 'Hà Nội',
            'shipping_method' => 'standard',
            'subtotal' => 500000,
            'grand_total' => 500000,
            'payment_method' => 'cod',
            'payment_status' => 'pending',
            'order_status' => Order::STATUS_PENDING,
            'placed_at' => now(),
        ], $attributes));
    }

    // ==========================================
    // 1. REVENUE & REFUND ACCURACY TESTS
    // ==========================================

    public function test_pending_and_cancelled_orders_are_excluded_from_revenue(): void
    {
        $this->createOrder([
            'order_status' => Order::STATUS_PENDING,
            'grand_total' => 300000,
        ]);

        $this->createOrder([
            'order_status' => Order::STATUS_CANCELLED,
            'grand_total' => 700000,
        ]);

        $service = app(AnalyticsService::class);
        $ranges = $service->resolveDateRanges('30d');
        $metrics = $service->getDashboardMetrics($ranges['start'], $ranges['end'], $ranges['prev_start'], $ranges['prev_end']);

        $this->assertEquals(0, $metrics['gross_sales']['current']);
        $this->assertEquals(0, $metrics['net_revenue']['current']);
        $this->assertEquals(0, $metrics['completed_orders']['current']);
    }

    public function test_completed_orders_are_included_in_revenue(): void
    {
        $this->createOrder([
            'order_status' => Order::STATUS_COMPLETED,
            'grand_total' => 1000000,
        ]);

        $service = app(AnalyticsService::class);
        $ranges = $service->resolveDateRanges('30d');
        $metrics = $service->getDashboardMetrics($ranges['start'], $ranges['end'], $ranges['prev_start'], $ranges['prev_end']);

        $this->assertEquals(1000000, $metrics['gross_sales']['current']);
        $this->assertEquals(1000000, $metrics['net_revenue']['current']);
        $this->assertEquals(1, $metrics['completed_orders']['current']);
    }

    public function test_successful_refund_reduces_net_revenue_correctly(): void
    {
        $order = $this->createOrder([
            'order_status' => Order::STATUS_COMPLETED,
            'grand_total' => 1000000,
            'payment_method' => 'vnpay',
            'payment_status' => 'paid',
        ]);

        $payment = Payment::create([
            'order_id' => $order->id,
            'provider' => 'vnpay',
            'amount' => 1000000,
            'status' => 'paid',
            'txn_ref' => 'TXN-' . uniqid(),
        ]);

        // Succeeded refund of 200,000 VND
        PaymentRefund::create([
            'payment_id' => $payment->id,
            'order_id' => $order->id,
            'request_id' => 'REF-' . uniqid(),
            'refund_type' => 'partial',
            'amount' => 200000,
            'status' => PaymentRefund::STATUS_SUCCEEDED,
        ]);

        $service = app(AnalyticsService::class);
        $ranges = $service->resolveDateRanges('30d');
        $metrics = $service->getDashboardMetrics($ranges['start'], $ranges['end'], $ranges['prev_start'], $ranges['prev_end']);

        $this->assertEquals(1000000, $metrics['gross_sales']['current']);
        $this->assertEquals(200000, $metrics['refund_amount']['current']);
        $this->assertEquals(800000, $metrics['net_revenue']['current']);
    }

    public function test_failed_and_pending_refunds_are_ignored_in_net_revenue(): void
    {
        $order = $this->createOrder([
            'order_status' => Order::STATUS_COMPLETED,
            'grand_total' => 1000000,
            'payment_method' => 'vnpay',
            'payment_status' => 'paid',
        ]);

        $payment = Payment::create([
            'order_id' => $order->id,
            'provider' => 'vnpay',
            'amount' => 1000000,
            'status' => 'paid',
            'txn_ref' => 'TXN-' . uniqid(),
        ]);

        // Failed refund
        PaymentRefund::create([
            'payment_id' => $payment->id,
            'order_id' => $order->id,
            'request_id' => 'REF-FAILED-' . uniqid(),
            'refund_type' => 'partial',
            'amount' => 300000,
            'status' => PaymentRefund::STATUS_FAILED,
        ]);

        // Pending requested refund
        PaymentRefund::create([
            'payment_id' => $payment->id,
            'order_id' => $order->id,
            'request_id' => 'REF-PENDING-' . uniqid(),
            'refund_type' => 'partial',
            'amount' => 400000,
            'status' => PaymentRefund::STATUS_REQUESTED,
        ]);

        $service = app(AnalyticsService::class);
        $ranges = $service->resolveDateRanges('30d');
        $metrics = $service->getDashboardMetrics($ranges['start'], $ranges['end'], $ranges['prev_start'], $ranges['prev_end']);

        $this->assertEquals(1000000, $metrics['gross_sales']['current']);
        $this->assertEquals(0, $metrics['refund_amount']['current']);
        $this->assertEquals(1000000, $metrics['net_revenue']['current']);
    }

    // ==========================================
    // 2. AOV & ZERO DIVISION SAFETY TESTS
    // ==========================================

    public function test_aov_calculation_correct_and_handles_zero_safely(): void
    {
        $service = app(AnalyticsService::class);
        $ranges = $service->resolveDateRanges('30d');

        // Zero orders -> AOV = 0 without error
        $metricsZero = $service->getDashboardMetrics($ranges['start'], $ranges['end'], $ranges['prev_start'], $ranges['prev_end']);
        $this->assertEquals(0, $metricsZero['aov']['current']);

        // 2 completed orders: 600,000 + 400,000 = 1,000,000 -> AOV = 500,000
        $this->createOrder(['order_status' => Order::STATUS_COMPLETED, 'grand_total' => 600000]);
        $this->createOrder(['order_status' => Order::STATUS_COMPLETED, 'grand_total' => 400000]);

        $metricsTwo = $service->getDashboardMetrics($ranges['start'], $ranges['end'], $ranges['prev_start'], $ranges['prev_end']);
        $this->assertEquals(500000, $metricsTwo['aov']['current']);
    }

    // ==========================================
    // 3. PRODUCT SALES & UNITS SOLD TESTS
    // ==========================================

    public function test_units_sold_sums_quantities_and_includes_inactive_products(): void
    {
        $prodActive = $this->createProduct(['name' => 'Nhẫn bạc active', 'stock_quantity' => 10, 'is_active' => true]);
        $prodInactive = $this->createProduct(['name' => 'Dây chuyền cũ', 'stock_quantity' => 0, 'is_active' => false]);

        $order = $this->createOrder(['order_status' => Order::STATUS_COMPLETED, 'grand_total' => 900000]);

        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $prodActive->id,
            'product_name' => $prodActive->name,
            'product_sku' => $prodActive->sku,
            'unit_price' => 300000,
            'quantity' => 2,
            'subtotal' => 600000,
        ]);

        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $prodInactive->id,
            'product_name' => $prodInactive->name,
            'product_sku' => $prodInactive->sku,
            'unit_price' => 300000,
            'quantity' => 1,
            'subtotal' => 300000,
        ]);

        $service = app(AnalyticsService::class);
        $ranges = $service->resolveDateRanges('30d');
        $metrics = $service->getDashboardMetrics($ranges['start'], $ranges['end'], $ranges['prev_start'], $ranges['prev_end']);

        $this->assertEquals(3, $metrics['units_sold']['current']);

        // Check Top Products includes inactive product historically
        $topProducts = $service->getTopProducts($ranges['start'], $ranges['end'], 'units');
        $this->assertCount(2, $topProducts);
        $names = $topProducts->pluck('product_name')->toArray();
        $this->assertContains('Dây chuyền cũ', $names);
    }

    // ==========================================
    // 4. INVENTORY HEALTH & BUNDLE LIMITING COMPONENT
    // ==========================================

    public function test_bundle_uses_component_stock_and_identifies_limiting_component(): void
    {
        // Component A: stock 10
        $compA = $this->createProduct(['sku' => 'COMP-A', 'name' => 'Linh kiện A', 'stock_quantity' => 10]);
        // Component B: stock 2 (Bottleneck)
        $compB = $this->createProduct(['sku' => 'COMP-B', 'name' => 'Linh kiện B', 'stock_quantity' => 2]);
        // Component C: stock 7
        $compC = $this->createProduct(['sku' => 'COMP-C', 'name' => 'Linh kiện C', 'stock_quantity' => 7]);

        // Bundle requires 1 of each
        $bundle = Product::create([
            'category_id' => $this->category->id,
            'sku' => 'BUNDLE-GIFT',
            'name' => 'Bộ Quà Tặng Vũ Trụ',
            'slug' => 'bo-qua-tang-vu-tru',
            'product_type' => 'gift',
            'regular_price' => 1500000,
            'stock_quantity' => 999, // Should be IGNORED
            'stock_status' => 'in_stock',
            'is_active' => true,
        ]);

        $bundle->bundleItems()->create(['component_product_id' => $compA->id, 'quantity' => 1, 'sort_order' => 1]);
        $bundle->bundleItems()->create(['component_product_id' => $compB->id, 'quantity' => 1, 'sort_order' => 2]);
        $bundle->bundleItems()->create(['component_product_id' => $compC->id, 'quantity' => 1, 'sort_order' => 3]);

        $this->assertEquals(2, $bundle->availableQuantity());

        $service = app(AnalyticsService::class);
        $limiting = $service->findLimitingComponent($bundle);

        $this->assertNotNull($limiting);
        $this->assertEquals('COMP-B', $limiting['sku']);
        $this->assertEquals(2, $limiting['stock']);
        $this->assertEquals(2, $limiting['available_for_bundle']);
    }

    // ==========================================
    // 5. CUSTOMER 360 & LIFETIME SPEND
    // ==========================================

    public function test_customer_360_calculates_lifetime_spend_and_order_history_correctly(): void
    {
        // Order 1: Completed, 800,000 VND
        $order1 = $this->createOrder([
            'user_id' => $this->customer->id,
            'order_status' => Order::STATUS_COMPLETED,
            'grand_total' => 800000,
        ]);

        // Order 2: Completed, 500,000 VND
        $order2 = $this->createOrder([
            'user_id' => $this->customer->id,
            'order_status' => Order::STATUS_COMPLETED,
            'grand_total' => 500000,
        ]);

        // Order 3: Cancelled, 1,000,000 VND (Excluded)
        $this->createOrder([
            'user_id' => $this->customer->id,
            'order_status' => Order::STATUS_CANCELLED,
            'grand_total' => 1000000,
        ]);

        // Refund 100,000 on order 1
        $payment = Payment::create([
            'order_id' => $order1->id,
            'provider' => 'vnpay',
            'amount' => 800000,
            'status' => 'paid',
            'txn_ref' => 'TXN-' . uniqid(),
        ]);

        PaymentRefund::create([
            'payment_id' => $payment->id,
            'order_id' => $order1->id,
            'request_id' => 'REF-' . uniqid(),
            'refund_type' => 'partial',
            'amount' => 100000,
            'status' => PaymentRefund::STATUS_SUCCEEDED,
        ]);

        // Add an address, review, and support message for customer 360
        Address::create([
            'user_id' => $this->customer->id,
            'recipient_name' => 'Nguyễn Văn A',
            'phone' => '0912345678',
            'address_line' => '123 Phố Huế',
            'ward' => 'Hàng Bài',
            'district' => 'Hoàn Kiếm',
            'city' => 'Hà Nội',
            'is_default' => true,
        ]);

        Review::create([
            'user_id' => $this->customer->id,
            'product_id' => $this->createProduct()->id,
            'rating' => 5,
            'comment' => 'Bạc rất sáng và đẹp!',
            'status' => 'approved',
        ]);

        ContactMessage::create([
            'reference' => 'SUP-TEST-123',
            'user_id' => $this->customer->id,
            'name' => $this->customer->name,
            'email' => $this->customer->email,
            'phone' => '0912345678',
            'subject' => 'Hỏi về bảo hành',
            'message' => 'Shop có hỗ trợ đánh sáng trọn đời không?',
            'status' => ContactMessage::STATUS_NEW,
        ]);

        $insights = app(CustomerInsightsService::class);
        $data360 = $insights->getCustomer360($this->customer);

        // Lifetime Spend = (800,000 + 500,000) - 100,000 = 1,200,000
        $this->assertEquals(1200000, $data360['summary']['lifetime_spend']);
        $this->assertEquals(2, $data360['summary']['completed_orders']);
        $this->assertEquals(3, $data360['summary']['total_orders']);
        $this->assertCount(1, $data360['reviews']);
        $this->assertCount(1, $data360['contact_messages']);
        $this->assertCount(1, $data360['addresses']);
        $this->assertEquals(CustomerInsightsService::SEGMENT_REPEAT, $data360['summary']['segment']);
    }

    // ==========================================
    // 6. GLOBAL ADMIN SEARCH TESTS
    // ==========================================

    public function test_global_search_returns_grouped_results_for_orders_skus_and_customers(): void
    {
        $this->createOrder([
            'order_code' => 'LNS-999999',
            'customer_name' => 'Trần Thị B',
            'customer_email' => 'tranthib@gmail.com',
        ]);

        $prod = $this->createProduct([
            'sku' => 'NH-CELESTIAL-01',
            'name' => 'Nhẫn Bạc Nữ Tinh Khôi',
        ]);

        ContactMessage::create([
            'reference' => 'SUP-999888',
            'name' => 'Khách Cần Tư Vấn',
            'email' => 'tuvan@gmail.com',
            'subject' => 'Cần hỗ trợ đổi size nhẫn',
            'message' => 'Nhẫn bị chật đổi được không?',
            'status' => 'new',
        ]);

        $this->actingAs($this->admin);

        // Search Order Code
        $resOrder = $this->getJson(route('admin.search.global', ['q' => '999999']));
        $resOrder->assertOk();
        $this->assertTrue(str_contains(json_encode($resOrder->json()), 'LNS-999999'));

        // Search SKU
        $resSku = $this->getJson(route('admin.search.global', ['q' => 'CELESTIAL']));
        $resSku->assertOk();
        $this->assertTrue(str_contains(json_encode($resSku->json()), 'NH-CELESTIAL-01'));

        // Search Support Reference
        $resSup = $this->getJson(route('admin.search.global', ['q' => 'SUP-999']));
        $resSup->assertOk();
        $this->assertTrue(str_contains(json_encode($resSup->json()), 'SUP-999888'));
    }

    // ==========================================
    // 7. ATTENTION CENTER DETECTION TESTS
    // ==========================================

    public function test_attention_center_detects_pending_orders_low_stock_and_unresolved_support(): void
    {
        $this->createOrder(['order_status' => Order::STATUS_PENDING]);
        $this->createProduct(['sku' => 'LOW-01', 'stock_quantity' => 2]); // Low stock
        Review::create([
            'user_id' => $this->customer->id,
            'product_id' => $this->createProduct()->id,
            'rating' => 4,
            'comment' => 'Khá ổn',
            'status' => 'pending',
        ]);

        $attention = app(AttentionService::class);
        $items = $attention->getAttentionItems();

        $ids = array_column($items, 'id');
        $this->assertContains('pending_orders', $ids);
        $this->assertContains('low_stock', $ids);
        $this->assertContains('pending_reviews', $ids);
    }

    // ==========================================
    // 8. SECURITY & AUTHORIZATION TESTS
    // ==========================================

    public function test_normal_user_cannot_access_admin_dashboard_customers_search_or_export(): void
    {
        $this->actingAs($this->customer);

        $this->get(route('admin.dashboard'))->assertForbidden();
        $this->get(route('admin.customers.index'))->assertForbidden();
        $this->get(route('admin.customers.show', $this->customer->id))->assertForbidden();
        $this->getJson(route('admin.search.global', ['q' => 'test']))->assertForbidden();
        $this->get(route('admin.export', ['type' => 'orders']))->assertForbidden();
    }

    public function test_admin_can_access_dashboard_and_export_orders_csv(): void
    {
        $this->createOrder(['order_status' => Order::STATUS_COMPLETED, 'grand_total' => 450000]);

        $this->actingAs($this->admin);

        $responseDash = $this->get(route('admin.dashboard'));
        $responseDash->assertOk();
        $responseDash->assertSee('Bảng điều khiển &amp; Chỉ số vận hành', false);

        $responseCust = $this->get(route('admin.customers.index'));
        $responseCust->assertOk();
        $responseCust->assertSee('Danh bạ khách hàng');

        $response360 = $this->get(route('admin.customers.show', $this->customer->id));
        $response360->assertOk();
        $response360->assertSee('Customer 360');

        $responseExport = $this->get(route('admin.export', ['type' => 'orders']));
        $responseExport->assertOk();
        $this->assertEquals('text/csv; charset=UTF-8', $responseExport->headers->get('content-type'));
    }

    public function test_orders_by_status_and_payment_breakdown_aggregates(): void
    {
        $this->createOrder(['order_status' => Order::STATUS_PENDING, 'payment_method' => 'cod']);
        $this->createOrder(['order_status' => Order::STATUS_COMPLETED, 'payment_method' => 'vnpay', 'grand_total' => 600000]);

        $service = app(AnalyticsService::class);
        $ranges = $service->resolveDateRanges('30d');

        $byStatus = $service->getOrdersByStatus($ranges['start'], $ranges['end']);
        $this->assertEquals(1, $byStatus['pending']['count']);
        $this->assertEquals(1, $byStatus['completed']['count']);

        $byPayment = $service->getPaymentBreakdown($ranges['start'], $ranges['end']);
        $this->assertEquals(1, $byPayment['cod']['orders_count']);
        $this->assertEquals(1, $byPayment['vnpay']['orders_count']);
        $this->assertEquals(600000, $byPayment['vnpay']['total_amount']);
    }

    public function test_customer_segmentation_logic(): void
    {
        $insights = app(CustomerInsightsService::class);

        // New customer (registered today, 0 orders)
        $newCustomer = User::factory()->create([
            'role' => User::ROLE_USER,
            'created_at' => now(),
        ]);
        $newCustomer->lifetime_spend = 0;
        $newCustomer->completed_orders_count = 0;
        $this->assertEquals(CustomerInsightsService::SEGMENT_NEW, $insights->determineSegment($newCustomer));

        // Repeat customer (2 completed orders)
        $repeatCustomer = User::factory()->create([
            'role' => User::ROLE_USER,
            'created_at' => now()->subDays(60),
        ]);
        $repeatCustomer->lifetime_spend = 1000000;
        $repeatCustomer->completed_orders_count = 2;
        $this->assertEquals(CustomerInsightsService::SEGMENT_REPEAT, $insights->determineSegment($repeatCustomer));

        // High value customer (>= 5,000,000 VND)
        $vipCustomer = User::factory()->create([
            'role' => User::ROLE_USER,
            'created_at' => now()->subDays(60),
        ]);
        $vipCustomer->lifetime_spend = 6000000;
        $vipCustomer->completed_orders_count = 1;
        $this->assertEquals(CustomerInsightsService::SEGMENT_HIGH_VALUE, $insights->determineSegment($vipCustomer));
    }

    public function test_customer_360_never_exposes_password_or_tokens(): void
    {
        $this->actingAs($this->admin);

        $response = $this->get(route('admin.customers.show', $this->customer->id));
        $response->assertOk();

        // Ensure passwords and remember tokens never leak into HTML output
        $content = $response->getContent();
        $this->assertStringNotContainsString($this->customer->password, $content);
        $this->assertStringNotContainsString('remember_token', $content);
    }
}

