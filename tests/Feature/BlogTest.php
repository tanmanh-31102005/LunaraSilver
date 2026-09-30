<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\PostCategory;
use App\Models\User;
use Database\Seeders\BlogSeeder;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class BlogTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected User $customer;

    protected PostCategory $category;

    protected Post $publishedPost;

    protected Post $draftPost;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
        $this->seed(BlogSeeder::class);

        $this->admin = User::factory()->create(['role' => User::ROLE_ADMIN]);
        $this->customer = User::factory()->create(['role' => User::ROLE_USER]);

        $this->category = PostCategory::where('slug', 'bao-quan-bac-925')->firstOrFail();
        $this->publishedPost = Post::where('slug', 'bi-quyet-bao-quan-trang-suc-bac-925-sang-bong-tai-nha')->firstOrFail();
        $this->draftPost = Post::where('slug', 'ban-nhap-xu-huong-trang-suc-toi-gian-mua-thu-dong-2026')->firstOrFail();
    }

    public function test_blog_index_page_loads_with_featured_post_and_categories(): void
    {
        $response = $this->get(route('blog.index'));

        $response->assertStatus(200);
        $response->assertSee('Nhật Ký Ánh Trăng');
        $response->assertSee($this->category->name);
        $response->assertSee($this->publishedPost->title);
        $response->assertDontSee($this->draftPost->title);
    }

    public function test_blog_search_filters_posts_by_keyword(): void
    {
        $response = $this->get(route('blog.index', ['q' => 'Bảo Quản']));

        $response->assertStatus(200);
        $response->assertSee($this->publishedPost->title);
        $response->assertDontSee('Nghệ Thuật Phối Lớp (Layering)');
    }

    public function test_blog_category_filter_shows_only_category_posts(): void
    {
        $response = $this->get(route('blog.category', $this->category->slug));

        $response->assertStatus(200);
        $response->assertSee($this->category->name);
        $response->assertSee($this->publishedPost->title);
        $response->assertDontSee('Ý Nghĩa Biểu Tượng Mặt Trăng Và Vì Sao');
    }

    public function test_single_published_post_page_displays_content_and_related_posts(): void
    {
        $response = $this->get(route('blog.show', $this->publishedPost->slug));

        $response->assertStatus(200);
        $response->assertSee($this->publishedPost->title);
        $response->assertSee('phút đọc');
        $response->assertSee('Bài viết cùng chủ đề');
    }

    public function test_draft_post_returns_404_for_guest_and_regular_user(): void
    {
        // Guest receives 404
        $this->get(route('blog.show', $this->draftPost->slug))
            ->assertStatus(404);

        // Regular authenticated customer receives 404
        $this->actingAs($this->customer)
            ->get(route('blog.show', $this->draftPost->slug))
            ->assertStatus(404);
    }

    public function test_draft_post_is_viewable_by_admin_with_preview_notice(): void
    {
        $response = $this->actingAs($this->admin)->get(route('blog.show', $this->draftPost->slug));

        $response->assertStatus(200);
        $response->assertSee($this->draftPost->title);
        $response->assertSee('Chế độ xem trước (Bản nháp)');
    }

    public function test_homepage_displays_lunara_journal_section_with_published_posts(): void
    {
        $response = $this->get(route('home'));

        $response->assertStatus(200);
        $response->assertSee('Nhật Ký Lunara');
        $response->assertSee($this->publishedPost->title);
        $response->assertDontSee($this->draftPost->title);
    }

    public function test_html_sanitizer_removes_malicious_scripts_and_attributes(): void
    {
        $dirtyHtml = '
            <h2>Tiêu đề an toàn</h2>
            <script>alert("xss")</script>
            <p onclick="stealCookies()" onload="bad()">Đoạn văn hợp lệ <a href="javascript:alert(1)">Liên kết</a></p>
            <iframe src="https://attacker.com/malware"></iframe>
            <blockquote>Trích dẫn an toàn</blockquote>
        ';

        $clean = Post::sanitizeHtml($dirtyHtml);

        $this->assertStringNotContainsString('<script', $clean);
        $this->assertStringNotContainsString('alert(', $clean);
        $this->assertStringNotContainsString('onclick', $clean);
        $this->assertStringNotContainsString('onload', $clean);
        $this->assertStringNotContainsString('<iframe', $clean);
        $this->assertStringNotContainsString('javascript:', $clean);

        $this->assertStringContainsString('<h2>Tiêu đề an toàn</h2>', $clean);
        $this->assertStringContainsString('Đoạn văn hợp lệ', $clean);
        $this->assertStringContainsString('<blockquote>Trích dẫn an toàn</blockquote>', $clean);
    }

    public function test_admin_can_list_posts_with_status_filter(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.posts.index', ['status' => 'draft']));

        $response->assertStatus(200);
        $response->assertSee($this->draftPost->title);
    }

    public function test_admin_can_create_new_post_with_cover_image(): void
    {
        Storage::fake('public');

        $file = UploadedFile::fake()->create('test-cover.jpg', 100, 'image/jpeg');

        $response = $this->actingAs($this->admin)->post(route('admin.posts.store'), [
            'title' => 'Bài viết thử nghiệm Lunara 2026',
            'post_category_id' => $this->category->id,
            'excerpt' => 'Đoạn tóm tắt thử nghiệm bài viết mới.',
            'content' => '<p>Nội dung chi tiết bài viết mới hoàn toàn.</p>',
            'status' => Post::STATUS_PUBLISHED,
            'is_featured' => true,
            'image' => $file,
            'seo_title' => 'SEO Title Thử Nghiệm',
            'seo_description' => 'SEO Description Thử Nghiệm',
        ]);

        $response->assertRedirect(route('admin.posts.index'));
        $this->assertDatabaseHas('posts', [
            'title' => 'Bài viết thử nghiệm Lunara 2026',
            'post_category_id' => $this->category->id,
            'is_published' => true,
            'status' => 'published',
            'is_featured' => true,
            'seo_title' => 'SEO Title Thử Nghiệm',
        ]);
    }

    public function test_admin_can_update_post_and_toggle_feature(): void
    {
        $response = $this->actingAs($this->admin)->put(route('admin.posts.update', $this->publishedPost), [
            'title' => 'Tiêu đề đã được cập nhật',
            'post_category_id' => $this->category->id,
            'content' => '<p>Nội dung mới đã sửa đổi.</p>',
            'status' => Post::STATUS_DRAFT,
        ]);

        $response->assertRedirect(route('admin.posts.index'));
        $this->assertEquals('Tiêu đề đã được cập nhật', $this->publishedPost->fresh()->title);
        $this->assertEquals(Post::STATUS_DRAFT, $this->publishedPost->fresh()->status);
        $this->assertFalse($this->publishedPost->fresh()->is_published);

        // Toggle feature
        $originalFeatured = $this->publishedPost->fresh()->is_featured;

        $this->actingAs($this->admin)
            ->patch(route('admin.posts.toggle-feature', $this->publishedPost))
            ->assertRedirect();

        $this->assertNotEquals($originalFeatured, $this->publishedPost->fresh()->is_featured);
    }

    public function test_admin_can_delete_post(): void
    {
        $this->actingAs($this->admin)
            ->delete(route('admin.posts.destroy', $this->draftPost))
            ->assertRedirect(route('admin.posts.index'));

        $this->assertDatabaseMissing('posts', ['id' => $this->draftPost->id]);
    }

    public function test_admin_can_crud_post_categories(): void
    {
        // Create category
        $this->actingAs($this->admin)
            ->post(route('admin.post-categories.store'), [
                'name' => 'Xu hướng trang sức mới',
                'description' => 'Mô tả danh mục mới',
                'sort_order' => 5,
                'is_active' => true,
            ])
            ->assertRedirect(route('admin.post-categories.index'));

        $this->assertDatabaseHas('post_categories', [
            'name' => 'Xu hướng trang sức mới',
            'slug' => 'xu-huong-trang-suc-moi',
        ]);

        $category = PostCategory::where('slug', 'xu-huong-trang-suc-moi')->firstOrFail();

        // Update category
        $this->actingAs($this->admin)
            ->put(route('admin.post-categories.update', $category), [
                'name' => 'Xu hướng trang sức 2026',
                'sort_order' => 10,
                'is_active' => true,
            ])
            ->assertRedirect(route('admin.post-categories.index'));

        $this->assertEquals('Xu hướng trang sức 2026', $category->fresh()->name);

        // Delete category
        $this->actingAs($this->admin)
            ->delete(route('admin.post-categories.destroy', $category))
            ->assertRedirect(route('admin.post-categories.index'));

        $this->assertDatabaseMissing('post_categories', ['id' => $category->id]);
    }

    public function test_non_admin_cannot_access_admin_blog_management(): void
    {
        $this->actingAs($this->customer)
            ->get(route('admin.posts.index'))
            ->assertStatus(403);

        $this->actingAs($this->customer)
            ->get(route('admin.post-categories.index'))
            ->assertStatus(403);
    }
}
