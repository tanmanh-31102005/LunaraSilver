<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PostCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class PostCategoryController extends Controller
{
    /**
     * Display a listing of post categories.
     */
    public function index(): View
    {
        $categories = PostCategory::withCount('posts')
            ->orderBy('sort_order', 'asc')
            ->orderBy('name', 'asc')
            ->paginate(15);

        return view('admin.post_categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new post category.
     */
    public function create(): View
    {
        return view('admin.post_categories.create');
    }

    /**
     * Store a newly created post category in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:post_categories,slug'],
            'description' => ['nullable', 'string'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ], [
            'name.required' => 'Vui lòng nhập tên danh mục blog.',
            'slug.unique' => 'Đường dẫn (slug) danh mục này đã tồn tại.',
        ]);

        $slug = ! empty($validated['slug']) ? Str::slug($validated['slug']) : Str::slug($validated['name']);
        // Ensure unique slug
        $baseSlug = $slug;
        $count = 1;
        while (PostCategory::where('slug', $slug)->exists()) {
            $slug = "{$baseSlug}-{$count}";
            $count++;
        }

        PostCategory::create([
            'name' => $validated['name'],
            'slug' => $slug,
            'description' => $validated['description'] ?? null,
            'sort_order' => (int) ($validated['sort_order'] ?? 0),
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.post-categories.index')
            ->with('success', 'Đã thêm danh mục bài viết mới thành công.');
    }

    /**
     * Show the form for editing the specified post category.
     */
    public function edit(PostCategory $postCategory): View
    {
        return view('admin.post_categories.edit', ['category' => $postCategory]);
    }

    /**
     * Update the specified post category in storage.
     */
    public function update(Request $request, PostCategory $postCategory): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('post_categories', 'slug')->ignore($postCategory->id),
            ],
            'description' => ['nullable', 'string'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ], [
            'name.required' => 'Vui lòng nhập tên danh mục blog.',
            'slug.unique' => 'Đường dẫn (slug) danh mục này đã tồn tại.',
        ]);

        $slug = ! empty($validated['slug']) ? Str::slug($validated['slug']) : $postCategory->slug;
        if ($slug !== $postCategory->slug) {
            $baseSlug = $slug;
            $count = 1;
            while (PostCategory::where('slug', $slug)->where('id', '!=', $postCategory->id)->exists()) {
                $slug = "{$baseSlug}-{$count}";
                $count++;
            }
        }

        $postCategory->update([
            'name' => $validated['name'],
            'slug' => $slug,
            'description' => $validated['description'] ?? null,
            'sort_order' => (int) ($validated['sort_order'] ?? 0),
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.post-categories.index')
            ->with('success', 'Đã cập nhật danh mục bài viết thành công.');
    }

    /**
     * Remove the specified post category from storage.
     */
    public function destroy(PostCategory $postCategory): RedirectResponse
    {
        // Unlink posts before removing category
        $postCategory->posts()->update(['post_category_id' => null]);
        $postCategory->delete();

        return redirect()->route('admin.post-categories.index')
            ->with('success', 'Đã xóa danh mục bài viết thành công.');
    }
}
