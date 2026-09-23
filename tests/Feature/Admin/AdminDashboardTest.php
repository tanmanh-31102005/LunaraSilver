<?php

namespace Tests\Feature\Admin;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminDashboardTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);

        $this->admin = User::factory()->create();
        $this->admin->role = User::ROLE_ADMIN;
        $this->admin->save();
    }

    public function test_dashboard_displays_real_metrics(): void
    {
        $totalProducts = Product::count();
        $totalCategories = Category::count();
        $activeProducts = Product::where('is_active', true)->count();
        $totalOrders = Order::count();
        $pendingOrders = Order::where('order_status', 'pending')->count();

        $response = $this->actingAs($this->admin)->get(route('admin.dashboard'));

        $response->assertOk();
        $response->assertViewHas('metrics', function (array $metrics) use ($totalProducts, $totalCategories, $activeProducts, $totalOrders, $pendingOrders): bool {
            return $metrics['total_products'] === $totalProducts
                && $metrics['total_categories'] === $totalCategories
                && $metrics['active_products'] === $activeProducts
                && $metrics['total_orders'] === $totalOrders
                && $metrics['pending_orders'] === $pendingOrders;
        });

        // Ensure real counts are rendered in HTML
        $response->assertSee(number_format($totalProducts));
        $response->assertSee(number_format($totalCategories));
    }

    public function test_dashboard_renders_recent_products_and_orders(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.dashboard'));

        $response->assertOk();
        $response->assertViewHas('recentProducts');
        $response->assertViewHas('recentOrders');

        // Check recent products count <= 5
        $recentProducts = $response->viewData('recentProducts');
        $this->assertLessThanOrEqual(5, $recentProducts->count());

        $recentOrders = $response->viewData('recentOrders');
        $this->assertLessThanOrEqual(5, $recentOrders->count());
    }
}
