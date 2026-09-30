<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostCategory;
use App\Services\CloudinaryService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Throwable;

class PostController extends Controller
{
    protected CloudinaryService $cloudinary;

    public function __construct(CloudinaryService $cloudinary)
    {
        $this->cloudinary = $cloudinary;
    }

    /**
     * Display a listing of posts with search and status filters.
     */
    public function index(Request $request): View
    {
        $query = Post::with(['category', 'author'])->latest();

        if ($request->filled('search')) {
            $query->search($request->input('search'));
        }

        if ($request->filled('status')) {
            $status = $request->input('status');
            if ($status === 'published') {
                $query->where(function ($q) {
                    $q->where('status', Post::STATUS_PUBLISHED)->orWhere('is_published', true);
                });
            } elseif ($status === 'draft') {
                $query->where('status', Post::STATUS_DRAFT)->where('is_published', false);
            }
        }

        if ($request->filled('category_id')) {
            $query->where('post_category_id', $request->input('category_id'));
        }

        $posts = $query->paginate(15)->withQueryString();
        $categories = PostCategory::ordered()->get();

        return view('admin.posts.index', compact('posts', 'categories'));
    }

    /**
     * Show the form for creating a new post.
     */
    public function create(): View
    {
        $categories = PostCategory::ordered()->get();

        return view('admin.posts.create', compact('categories'));
    }

    /**
     * Store a newly created post in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:posts,slug'],
            'post_category_id' => ['nullable', 'exists:post_categories,id'],
            'excerpt' => ['nullable', 'string', 'max:1000'],
            'content' => ['required', 'string'],
            'status' => ['required', Rule::in([Post::STATUS_DRAFT, Post::STATUS_PUBLISHED])],
            'is_featured' => ['nullable', 'boolean'],
            'reading_time_minutes' => ['nullable', 'integer', 'min:1'],
            'seo_title' => ['nullable', 'string', 'max:255'],
            'seo_description' => ['nullable', 'string', 'max:500'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
        ], [
            'title.required' => 'Vui lòng nhập tiêu đề bài viết.',
            'content.required' => 'Vui lòng nhập nội dung bài viết.',
            'slug.unique' => 'Đường dẫn (slug) này đã tồn tại.',
            'image.image' => 'Tệp tải lên phải là hình ảnh hợp lệ.',
            'image.max' => 'Dung lượng ảnh không được vượt quá 5MB.',
        ]);

        $slug = ! empty($validated['slug']) ? Str::slug($validated['slug']) : Str::slug($validated['title']);
        $baseSlug = $slug;
        $count = 1;
        while (Post::where('slug', $slug)->exists()) {
            $slug = "{$baseSlug}-{$count}";
            $count++;
        }

        // Upload Cover Image
        $coverImageUrl = null;
        $cloudinaryPublicId = null;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            if ($this->cloudinary->isConfigured()) {
                try {
                    $folder = $this->cloudinary->generateFolder('blog');
                    $upload = $this->cloudinary->uploadFile($file, $folder);
                    $coverImageUrl = $upload['secure_url'];
                    $cloudinaryPublicId = $upload['public_id'];
                } catch (Throwable $e) {
                    Log::warning('Cloudinary upload fallback to local storage: '.$e->getMessage());
                    $path = $file->store('blog', 'public');
                    $coverImageUrl = asset('storage/'.$path);
                }
            } else {
                $path = $file->store('blog', 'public');
                $coverImageUrl = asset('storage/'.$path);
            }
        }

        // Sanitize content
        $sanitizedContent = Post::sanitizeHtml($validated['content']);

        $status = $validated['status'];
        $isPublished = ($status === Post::STATUS_PUBLISHED);
        $publishedAt = $isPublished ? now() : null;

        // Reading time
        $readingTime = ! empty($validated['reading_time_minutes'])
            ? (int) $validated['reading_time_minutes']
            : max(1, (int) ceil(str_word_count(strip_tags($sanitizedContent)) / 200));

        Post::create([
            'author_id' => auth()->id(),
            'post_category_id' => $validated['post_category_id'] ?? null,
            'title' => $validated['title'],
            'slug' => $slug,
            'excerpt' => $validated['excerpt'] ?? null,
            'content' => $sanitizedContent,
            'image_url' => $coverImageUrl,
            'cover_image_url' => $coverImageUrl,
            'cloudinary_public_id' => $cloudinaryPublicId,
            'status' => $status,
            'is_published' => $isPublished,
            'is_featured' => $request->boolean('is_featured'),
            'reading_time_minutes' => $readingTime,
            'seo_title' => $validated['seo_title'] ?? null,
            'seo_description' => $validated['seo_description'] ?? null,
            'published_at' => $publishedAt,
        ]);

        return redirect()->route('admin.posts.index')
            ->with('success', 'Đã tạo bài viết mới thành công.');
    }

    /**
     * Show the form for editing the specified post.
     */
    public function edit(Post $post): View
    {
        $categories = PostCategory::ordered()->get();

        return view('admin.posts.edit', compact('post', 'categories'));
    }

    /**
     * Update the specified post in storage.
     */
    public function update(Request $request, Post $post): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('posts', 'slug')->ignore($post->id),
            ],
            'post_category_id' => ['nullable', 'exists:post_categories,id'],
            'excerpt' => ['nullable', 'string', 'max:1000'],
            'content' => ['required', 'string'],
            'status' => ['required', Rule::in([Post::STATUS_DRAFT, Post::STATUS_PUBLISHED])],
            'is_featured' => ['nullable', 'boolean'],
            'reading_time_minutes' => ['nullable', 'integer', 'min:1'],
            'seo_title' => ['nullable', 'string', 'max:255'],
            'seo_description' => ['nullable', 'string', 'max:500'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
        ], [
            'title.required' => 'Vui lòng nhập tiêu đề bài viết.',
            'content.required' => 'Vui lòng nhập nội dung bài viết.',
            'slug.unique' => 'Đường dẫn (slug) này đã tồn tại.',
            'image.image' => 'Tệp tải lên phải là hình ảnh hợp lệ.',
            'image.max' => 'Dung lượng ảnh không được vượt quá 5MB.',
        ]);

        $slug = ! empty($validated['slug']) ? Str::slug($validated['slug']) : $post->slug;
        if ($slug !== $post->slug) {
            $baseSlug = $slug;
            $count = 1;
            while (Post::where('slug', $slug)->where('id', '!=', $post->id)->exists()) {
                $slug = "{$baseSlug}-{$count}";
                $count++;
            }
        }

        $coverImageUrl = $post->cover_image_url ?? $post->image_url;
        $cloudinaryPublicId = $post->cloudinary_public_id;

        if ($request->hasFile('image')) {
            $file = $request->file('image');

            // Delete old Cloudinary asset if exists
            if ($cloudinaryPublicId && $this->cloudinary->isConfigured()) {
                try {
                    $this->cloudinary->deleteFile($cloudinaryPublicId);
                } catch (Throwable $e) {
                    Log::warning('Could not delete old Cloudinary image: '.$e->getMessage());
                }
            }

            if ($this->cloudinary->isConfigured()) {
                try {
                    $folder = $this->cloudinary->generateFolder('blog');
                    $upload = $this->cloudinary->uploadFile($file, $folder);
                    $coverImageUrl = $upload['secure_url'];
                    $cloudinaryPublicId = $upload['public_id'];
                } catch (Throwable $e) {
                    Log::warning('Cloudinary upload fallback to local storage: '.$e->getMessage());
                    $path = $file->store('blog', 'public');
                    $coverImageUrl = asset('storage/'.$path);
                }
            } else {
                $path = $file->store('blog', 'public');
                $coverImageUrl = asset('storage/'.$path);
            }
        }

        $sanitizedContent = Post::sanitizeHtml($validated['content']);
        $status = $validated['status'];
        $isPublished = ($status === Post::STATUS_PUBLISHED);

        $publishedAt = $post->published_at;
        if ($isPublished && ! $publishedAt) {
            $publishedAt = now();
        }

        $readingTime = ! empty($validated['reading_time_minutes'])
            ? (int) $validated['reading_time_minutes']
            : max(1, (int) ceil(str_word_count(strip_tags($sanitizedContent)) / 200));

        $post->update([
            'post_category_id' => $validated['post_category_id'] ?? null,
            'title' => $validated['title'],
            'slug' => $slug,
            'excerpt' => $validated['excerpt'] ?? null,
            'content' => $sanitizedContent,
            'image_url' => $coverImageUrl,
            'cover_image_url' => $coverImageUrl,
            'cloudinary_public_id' => $cloudinaryPublicId,
            'status' => $status,
            'is_published' => $isPublished,
            'is_featured' => $request->boolean('is_featured'),
            'reading_time_minutes' => $readingTime,
            'seo_title' => $validated['seo_title'] ?? null,
            'seo_description' => $validated['seo_description'] ?? null,
            'published_at' => $publishedAt,
        ]);

        return redirect()->route('admin.posts.index')
            ->with('success', 'Đã cập nhật bài viết thành công.');
    }

    /**
     * Remove the specified post from storage.
     */
    public function destroy(Post $post): RedirectResponse
    {
        if ($post->cloudinary_public_id && $this->cloudinary->isConfigured()) {
            try {
                $this->cloudinary->deleteFile($post->cloudinary_public_id);
            } catch (Throwable $e) {
                Log::warning('Could not delete Cloudinary image on post delete: '.$e->getMessage());
            }
        }

        $post->delete();

        return redirect()->route('admin.posts.index')
            ->with('success', 'Đã xóa bài viết thành công.');
    }

    /**
     * Toggle featured status for post.
     */
    public function toggleFeature(Post $post): RedirectResponse
    {
        $post->update([
            'is_featured' => ! $post->is_featured,
        ]);

        $message = $post->is_featured
            ? 'Đã đặt bài viết làm bài nổi bật.'
            : 'Đã hủy đánh dấu bài viết nổi bật.';

        return back()->with('success', $message);
    }
}
