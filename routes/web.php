<?php

use App\Http\Controllers\Account\AddressController;
use App\Http\Controllers\Account\DashboardController;
use App\Http\Controllers\Account\OrderController;
use App\Http\Controllers\Account\PasswordController;
use App\Http\Controllers\Account\ProfileController;
use App\Http\Controllers\Account\ReviewController as AccountReviewController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\CouponController as AdminCouponController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\FaqController as AdminFaqController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\PostCategoryController as AdminPostCategoryController;
use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\ProductImageController as AdminProductImageController;
use App\Http\Controllers\Admin\ReviewController as AdminReviewController;
use App\Http\Controllers\Admin\SupportController as AdminSupportController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\SupportController;
use App\Http\Controllers\VNPayController;
use App\Http\Controllers\WishlistController;
use Illuminate\Support\Facades\Route;

Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');
Route::get('/', HomeController::class)->name('home');

// Search System (Phase 19)
Route::get('/search', [SearchController::class, 'index'])->name('search');
Route::get('/api/search/suggestions', [SearchController::class, 'suggestions'])->name('api.search.suggestions');
Route::get('/search/suggestions', [SearchController::class, 'suggestions'])->name('search.suggestions');

// Wishlist System (Phase 19)
Route::get('/account/wishlist', [WishlistController::class, 'index'])->name('account.wishlist');
Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
Route::get('/wishlist/status', [WishlistController::class, 'status'])->name('wishlist.status');
Route::post('/wishlist/{product}', [WishlistController::class, 'toggle'])->whereNumber('product')->name('wishlist.toggle');
Route::delete('/wishlist/{product}', [WishlistController::class, 'destroy'])->whereNumber('product')->name('wishlist.destroy');

Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{category:slug}', [ProductController::class, 'index'])->name('products.category');
Route::get('/product/{product:slug}', [ProductController::class, 'show'])->name('products.show');
Route::post('/product/{product:slug}/reviews', [ReviewController::class, 'store'])->middleware('auth')->name('reviews.store');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::get('/cart/summary', [CartController::class, 'summary'])->name('cart.summary');
Route::post('/cart/items', [CartController::class, 'store'])->name('cart.items.store');
Route::patch('/cart/items/{item}', [CartController::class, 'update'])->whereNumber('item')->name('cart.items.update');
Route::delete('/cart/items/{item}', [CartController::class, 'destroy'])->whereNumber('item')->name('cart.items.destroy');
Route::delete('/cart', [CartController::class, 'clear'])->name('cart.clear');
Route::post('/cart/coupon', [CartController::class, 'applyCoupon'])->name('cart.coupon.apply');
Route::delete('/cart/coupon', [CartController::class, 'removeCoupon'])->name('cart.coupon.remove');
Route::get('/order-success/{orderCode}', [CheckoutController::class, 'success'])->name('orders.success');
Route::get('/media/{path}', MediaController::class)->where('path', '.*')->name('media.show');

// Editorial Journal & Blog routes
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/category/{category:slug}', [BlogController::class, 'category'])->name('blog.category');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');

// Customer Support & FAQ routes
Route::get('/support', [SupportController::class, 'faq'])->name('support.index');
Route::get('/support/faq', [SupportController::class, 'faq'])->name('support.faq');
Route::get('/contact', [SupportController::class, 'contact'])->name('contact');
Route::post('/contact', [SupportController::class, 'submitContact'])->name('contact.submit');

// Live Support Chat AJAX polling routes
Route::post('/support/chat/init', [SupportController::class, 'initChat'])->name('support.chat.init');
Route::get('/support/chat/{reference}/messages', [SupportController::class, 'getChatMessages'])->name('support.chat.messages');
Route::post('/support/chat/{reference}/messages', [SupportController::class, 'sendChatMessage'])->name('support.chat.send');

// VNPay gateway callback routes
Route::get('/payment/vnpay/return', [VNPayController::class, 'return'])->name('payment.vnpay.return');
Route::match(['get', 'post'], '/payment/vnpay/ipn', [VNPayController::class, 'ipn'])->name('payment.vnpay.ipn');

Route::middleware('guest')->group(function () {
    Route::view('/login', 'auth.login')->name('login');
    Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:6,1');
    Route::view('/register', 'auth.register')->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');
});

Route::middleware('auth')->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'show'])->name('checkout.show');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::match(['get', 'post'], '/payment/vnpay/retry/{orderCode}', [VNPayController::class, 'retry'])->name('payment.vnpay.retry');

    Route::prefix('account')->name('account.')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

        Route::get('/password', [PasswordController::class, 'edit'])->name('password.edit');
        Route::patch('/password', [PasswordController::class, 'update'])->name('password.update');

        Route::get('/addresses', [AddressController::class, 'index'])->name('addresses.index');
        Route::post('/addresses', [AddressController::class, 'store'])->name('addresses.store');
        Route::patch('/addresses/{address}', [AddressController::class, 'update'])->whereNumber('address')->name('addresses.update');
        Route::delete('/addresses/{address}', [AddressController::class, 'destroy'])->whereNumber('address')->name('addresses.destroy');
        Route::patch('/addresses/{address}/default', [AddressController::class, 'setDefault'])->whereNumber('address')->name('addresses.default');

        Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{orderCode}', [OrderController::class, 'show'])->name('orders.show');

        // Review Center (Phase 20.11)
        Route::get('/reviews', [AccountReviewController::class, 'index'])->name('reviews.index');
        Route::get('/reviews/create/{item}', [AccountReviewController::class, 'create'])->whereNumber('item')->name('reviews.create');
    });
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('categories', AdminCategoryController::class)->except(['show']);

    Route::post('products/bulk-action', [AdminProductController::class, 'bulkAction'])->name('products.bulk-action');
    Route::patch('products/{product}/toggle-status', [AdminProductController::class, 'toggleStatus'])->name('products.toggle-status');
    Route::patch('products/{product}/quick-stock', [AdminProductController::class, 'quickStock'])->name('products.quick-stock');
    Route::post('products/{product}/duplicate', [AdminProductController::class, 'duplicate'])->name('products.duplicate');
    Route::post('products/{product}/images', [AdminProductImageController::class, 'store'])->name('products.images.store');
    Route::patch('products/{product}/images/reorder', [AdminProductImageController::class, 'reorder'])->name('products.images.reorder');
    Route::patch('products/{product}/images/{image}', [AdminProductImageController::class, 'update'])->name('products.images.update');
    Route::delete('products/{product}/images/{image}', [AdminProductImageController::class, 'destroy'])->name('products.images.destroy');
    Route::resource('products', AdminProductController::class)->except(['show']);

    Route::get('orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{orderCode}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::patch('orders/{orderCode}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.status');
    Route::post('orders/{orderCode}/cancel', [AdminOrderController::class, 'cancel'])->name('orders.cancel');
    Route::match(['get', 'post'], 'orders/{orderCode}/reconcile', [AdminOrderController::class, 'reconcile'])->name('orders.reconcile');
    Route::match(['get', 'post'], 'orders/{orderCode}/refund', [AdminOrderController::class, 'refund'])->name('orders.refund');

    // Customer Reviews Moderation (Phase 20)
    Route::get('reviews', [AdminReviewController::class, 'index'])->name('reviews.index');
    Route::get('reviews/{review}', [AdminReviewController::class, 'show'])->whereNumber('review')->name('reviews.show');
    Route::post('reviews/{review}/approve', [AdminReviewController::class, 'approve'])->whereNumber('review')->name('reviews.approve');
    Route::post('reviews/{review}/reject', [AdminReviewController::class, 'reject'])->whereNumber('review')->name('reviews.reject');
    Route::post('reviews/{review}/reply', [AdminReviewController::class, 'reply'])->whereNumber('review')->name('reviews.reply');
    Route::delete('reviews/{review}', [AdminReviewController::class, 'destroy'])->whereNumber('review')->name('reviews.destroy');

    // Customer Support Inbox & Live Chat
    Route::get('support', [AdminSupportController::class, 'index'])->name('support.index');
    Route::get('support/chat', [AdminSupportController::class, 'chatIndex'])->name('support.chat');
    Route::get('support/chat/{conversation}', [AdminSupportController::class, 'chatShow'])->name('support.chat.show');
    Route::post('support/chat/{conversation}/reply', [AdminSupportController::class, 'chatReply'])->name('support.chat.reply');
    Route::post('support/chat/{conversation}/close', [AdminSupportController::class, 'chatClose'])->name('support.chat.close');
    Route::get('support/{support}', [AdminSupportController::class, 'show'])->name('support.show');
    Route::patch('support/{support}/status', [AdminSupportController::class, 'updateStatus'])->name('support.status');
    Route::patch('support/{support}/assign', [AdminSupportController::class, 'assign'])->name('support.assign');
    Route::post('support/{support}/notes', [AdminSupportController::class, 'saveNotes'])->name('support.notes');
    Route::post('support/{support}/reply', [AdminSupportController::class, 'reply'])->name('support.reply');

    // FAQs Management
    Route::patch('faqs/{faq}/toggle', [AdminFaqController::class, 'toggle'])->name('faqs.toggle');
    Route::resource('faqs', AdminFaqController::class)->except(['show']);

    // Marketing & Coupons Management
    Route::patch('coupons/{coupon}/toggle', [AdminCouponController::class, 'toggle'])->name('coupons.toggle');
    Route::resource('coupons', AdminCouponController::class);

    // Editorial Blog CMS
    Route::patch('posts/{post}/toggle-feature', [AdminPostController::class, 'toggleFeature'])->name('posts.toggle-feature');
    Route::resource('posts', AdminPostController::class);
    Route::resource('post-categories', AdminPostCategoryController::class)->except(['show']);
});
