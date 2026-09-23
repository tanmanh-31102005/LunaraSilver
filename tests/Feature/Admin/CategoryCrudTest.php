<?php

namespace Tests\Feature\Admin;

use App\Models\Category;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryCrudTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);

        $this->admin = User::factory()->create();
        $this->admin->role = User::ROLE_ADMIN;
        $this->admin->save();

        $this->user = User::factory()->create();
    }

    public function test_admin_can_list_categories(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.categories.index'));

        $response->assertOk();
        $response->assertSee('Danh mục sản phẩm');
        $response->assertViewHas('categories');
    }

    public function test_admin_can_create_category_with_auto_generated_slug(): void
    {
        $payload = [
            'name' => 'Lắc Chân Bạc Moon',
            'description' => 'Bộ sưu tập lắc chân bạc cao cấp',
            'is_active' => '1',
            'sort_order' => 10,
        ];

        $response = $this->actingAs($this->admin)->post(route('admin.categories.store'), $payload);

        $response->assertRedirect(route('admin.categories.index'));
        $this->assertDatabaseHas('categories', [
            'name' => 'Lắc Chân Bạc Moon',
            'slug' => 'lac-chan-bac-moon',
            'is_active' => true,
        ]);
    }

    public function test_admin_can_create_category_with_custom_slug(): void
    {
        $payload = [
            'name' => 'Cài Áo Bạc',
            'slug' => 'cai-ao-tinh-te',
            'is_active' => '1',
            'sort_order' => 5,
        ];

        $response = $this->actingAs($this->admin)->post(route('admin.categories.store'), $payload);

        $response->assertRedirect(route('admin.categories.index'));
        $this->assertDatabaseHas('categories', [
            'name' => 'Cài Áo Bạc',
            'slug' => 'cai-ao-tinh-te',
        ]);
    }

    public function test_invalid_category_creation_is_rejected(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.categories.store'), [
            'name' => '',
        ]);

        $response->assertSessionHasErrors(['name']);
    }

    public function test_duplicate_slug_is_rejected_on_creation(): void
    {
        $existing = Category::firstOrFail();

        $response = $this->actingAs($this->admin)->post(route('admin.categories.store'), [
            'name' => 'Tên Mới Nào Đó',
            'slug' => $existing->slug,
        ]);

        $response->assertSessionHasErrors(['slug']);
    }

    public function test_admin_can_update_category(): void
    {
        $category = Category::create([
            'name' => 'Danh Mục Cũ',
            'slug' => 'danh-muc-cu',
            'is_active' => true,
        ]);

        $response = $this->actingAs($this->admin)->put(route('admin.categories.update', $category), [
            'name' => 'Danh Mục Mới',
            'slug' => 'danh-muc-moi',
            'is_active' => '1',
            'sort_order' => 2,
        ]);

        $response->assertRedirect(route('admin.categories.index'));
        $this->assertDatabaseHas('categories', [
            'id' => $category->id,
            'name' => 'Danh Mục Mới',
            'slug' => 'danh-muc-moi',
        ]);
    }

    public function test_category_deletion_is_blocked_if_it_contains_products(): void
    {
        $category = Category::whereHas('products')->firstOrFail();

        $response = $this->actingAs($this->admin)->delete(route('admin.categories.destroy', $category));

        $response->assertRedirect(route('admin.categories.index'));
        $response->assertSessionHas('error');
        $this->assertDatabaseHas('categories', ['id' => $category->id]);
    }

    public function test_empty_category_can_be_deleted(): void
    {
        $category = Category::create([
            'name' => 'Danh Mục Trống',
            'slug' => 'danh-muc-trong',
            'is_active' => true,
        ]);

        $response = $this->actingAs($this->admin)->delete(route('admin.categories.destroy', $category));

        $response->assertRedirect(route('admin.categories.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
    }

    public function test_normal_user_cannot_crud_category(): void
    {
        $this->actingAs($this->user)->post(route('admin.categories.store'), ['name' => 'Test'])->assertForbidden();
        $category = Category::firstOrFail();
        $this->actingAs($this->user)->put(route('admin.categories.update', $category), ['name' => 'Update'])->assertForbidden();
        $this->actingAs($this->user)->delete(route('admin.categories.destroy', $category))->assertForbidden();
    }
}
