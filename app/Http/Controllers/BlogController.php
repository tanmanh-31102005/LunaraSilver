<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostCategory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BlogController extends Controller
{
    /**
     * Display the blog index with featured post and paginated articles.
     */
    public function index(Request $request): View
    {
        $search = trim((string) $request->input('q', ''));
        $categorySlug = $request->input('category');

        $baseQuery = Post::published()->with(['category', 'author']);

        if ($search !== '') {
            $baseQuery->search($search);
        }

        $currentCategory = null;
        if ($categorySlug) {
            $currentCategory = PostCategory::active()->where('slug', $categorySlug)->first();
            if ($currentCategory) {
                $baseQuery->where('post_category_id', $currentCategory->id);
            }
        }

        // Featured post (only on first page when not searching)
        $featuredPost = null;
        if ($search === '' && (! $request->has('page') || (int) $request->input('page') === 1)) {
            $featuredPost = (clone $baseQuery)->featured()->latest('published_at')->first();
            if (! $featuredPost && ! $currentCategory) {
                $featuredPost = (clone $baseQuery)->latest('published_at')->first();
            }
        }

        // Post listing
        $listingQuery = (clone $baseQuery)->latest('published_at');
        if ($featuredPost) {
            $listingQuery->where('id', '!=', $featuredPost->id);
        }

        $posts = $listingQuery->paginate(9)->withQueryString();

        $categories = PostCategory::active()
            ->ordered()
            ->withCount(['posts' => function ($q) {
                $q->published();
            }])
            ->get();

        return view('blog.index', compact('posts', 'featuredPost', 'categories', 'currentCategory', 'search'));
    }

    /**
     * Filter posts by category.
     */
    public function category(PostCategory $category, Request $request): View
    {
        if (! $category->is_active) {
            abort(404);
        }

        $search = trim((string) $request->input('q', ''));

        $query = Post::published()
            ->where('post_category_id', $category->id)
            ->with(['category', 'author'])
            ->latest('published_at');

        if ($search !== '') {
            $query->search($search);
        }

        $posts = $query->paginate(9)->withQueryString();

        $categories = PostCategory::active()
            ->ordered()
            ->withCount(['posts' => function ($q) {
                $q->published();
            }])
            ->get();

        $currentCategory = $category;
        $featuredPost = null;

        return view('blog.index', compact('posts', 'featuredPost', 'categories', 'currentCategory', 'search'));
    }

    /**
     * Display a single editorial post.
     */
    public function show(string $slug, Request $request): View
    {
        $post = Post::where('slug', $slug)
            ->with(['category', 'author'])
            ->firstOrFail();

        // Draft authorization: only admins can view unpublished posts
        if (! $post->isPublished()) {
            $isAdmin = auth()->check() && (
                (method_exists(auth()->user(), 'isAdmin') && auth()->user()->isAdmin()) ||
                auth()->user()->role === User::ROLE_ADMIN
            );

            if (! $isAdmin) {
                abort(404);
            }
        }

        // Related posts: up to 3 posts in the same category or latest
        $relatedQuery = Post::published()
            ->where('id', '!=', $post->id)
            ->with(['category']);

        if ($post->post_category_id) {
            $relatedQuery->where('post_category_id', $post->post_category_id);
        }

        $relatedPosts = $relatedQuery->latest('published_at')->limit(3)->get();

        // If not enough related posts in same category, supplement with latest published posts
        if ($relatedPosts->count() < 3) {
            $needed = 3 - $relatedPosts->count();
            $excludeIds = array_merge([$post->id], $relatedPosts->pluck('id')->all());

            $fallbackPosts = Post::published()
                ->whereNotIn('id', $excludeIds)
                ->with(['category'])
                ->latest('published_at')
                ->limit($needed)
                ->get();

            $relatedPosts = $relatedPosts->merge($fallbackPosts);
        }

        return view('blog.show', compact('post', 'relatedPosts'));
    }
}
