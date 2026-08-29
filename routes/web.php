<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Frontend\ArticleController;
use App\Http\Controllers\Frontend\AuthorController;
use App\Http\Controllers\Frontend\ContentCategoryController;
use App\Http\Controllers\Frontend\GuideController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\NewsController;
use App\Http\Controllers\Frontend\NewsletterController;
use App\Http\Controllers\Frontend\PlantController;
use App\Http\Controllers\Frontend\PlantProblemController;
use App\Http\Controllers\Frontend\SearchController;
use App\Http\Controllers\Frontend\ShopController;
use App\Http\Controllers\Frontend\SitemapController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - Plantora Frontend & Auth
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('frontend.home');

// Shop Public Routes
Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
Route::get('/shop/category/{slug}', [ShopController::class, 'category'])->name('frontend.shop.category');
Route::get('/shop/products/{slug}', [ShopController::class, 'show'])->name('frontend.shop.product');

// Cart Routes
Route::get('/cart', [\App\Http\Controllers\Frontend\CartController::class, 'index'])->name('frontend.cart.index');
Route::post('/cart/add', [\App\Http\Controllers\Frontend\CartController::class, 'add'])->name('frontend.cart.add');
Route::put('/cart/items/{id}', [\App\Http\Controllers\Frontend\CartController::class, 'update'])->name('frontend.cart.update');
Route::delete('/cart/items/{id}', [\App\Http\Controllers\Frontend\CartController::class, 'remove'])->name('frontend.cart.remove');
Route::post('/cart/coupon', [\App\Http\Controllers\Frontend\CartController::class, 'applyCoupon'])->name('frontend.cart.coupon');
Route::delete('/cart/coupon', [\App\Http\Controllers\Frontend\CartController::class, 'removeCoupon'])->name('frontend.cart.coupon.remove');

// Plant Encyclopedia Public Routes
Route::get('/plants', [PlantController::class, 'index'])->name('plants.index');
Route::get('/plants/{plant:slug}', [PlantController::class, 'show'])->name('plants.show');

// Plant Doctor / Problems Public Routes
Route::get('/plant-problems', [PlantProblemController::class, 'index'])->name('problems.index');
Route::get('/plant-problems/{plantProblem:slug}', [PlantProblemController::class, 'show'])->name('problems.show');

// Content Publishing Public Routes (Articles, Guides, News, Categories, Authors)
Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');
Route::get('/articles/category/{slug}', [ContentCategoryController::class, 'show'])->name('content-categories.show');
Route::get('/articles/{slug}', [ArticleController::class, 'show'])->name('articles.show');

Route::get('/guides', [GuideController::class, 'index'])->name('guides.index');
Route::get('/guides/{slug}', [GuideController::class, 'show'])->name('guides.show');

Route::get('/news', [NewsController::class, 'index'])->name('news.index');
Route::get('/news/{slug}', [NewsController::class, 'show'])->name('news.show');

Route::get('/authors/{user}', [AuthorController::class, 'show'])->name('authors.show');

Route::get('/search', [SearchController::class, 'index'])->name('search.index');
Route::post('/newsletter/subscribe', [NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');

// Sitemaps
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');
Route::get('/sitemaps/{type}.xml', [SitemapController::class, 'show'])->name('sitemap.show');

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);

    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);

    Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('/email/verify', [VerificationController::class, 'show'])->name('verification.notice');
    Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->middleware('signed')->name('verification.verify');
    Route::post('/email/verification-notification', [VerificationController::class, 'resend'])->middleware('throttle:6,1')->name('verification.send');

    // Wishlist Toggle
    Route::post('/wishlist/toggle/{product}', [\App\Http\Controllers\Frontend\WishlistController::class, 'toggle'])->name('frontend.wishlist.toggle');

    // Checkout Routes
    Route::get('/checkout', [\App\Http\Controllers\Frontend\CheckoutController::class, 'index'])->name('frontend.checkout.index');
    Route::post('/checkout', [\App\Http\Controllers\Frontend\CheckoutController::class, 'process'])->name('frontend.checkout.process');
    Route::get('/checkout/success/{order_number}', [\App\Http\Controllers\Frontend\CheckoutController::class, 'success'])->name('frontend.checkout.success');

    // Customer Account Area
    Route::get('/account/dashboard', [\App\Http\Controllers\Frontend\CustomerAccountController::class, 'dashboard'])->name('frontend.account.dashboard');
    Route::get('/account/orders', [\App\Http\Controllers\Frontend\CustomerAccountController::class, 'orders'])->name('frontend.account.orders');
    Route::get('/account/orders/{order_number}', [\App\Http\Controllers\Frontend\CustomerAccountController::class, 'showOrder'])->name('frontend.account.orders.show');
    Route::post('/account/orders/{order_number}/cancel', [\App\Http\Controllers\Frontend\CustomerAccountController::class, 'cancelOrder'])->name('frontend.account.orders.cancel');
    Route::get('/account/addresses', [\App\Http\Controllers\Frontend\CustomerAccountController::class, 'addresses'])->name('frontend.account.addresses');
    Route::post('/account/addresses', [\App\Http\Controllers\Frontend\CustomerAccountController::class, 'storeAddress'])->name('frontend.account.addresses.store');
    Route::delete('/account/addresses/{address}', [\App\Http\Controllers\Frontend\CustomerAccountController::class, 'deleteAddress'])->name('frontend.account.addresses.delete');
    Route::get('/account/wishlist', [\App\Http\Controllers\Frontend\WishlistController::class, 'index'])->name('frontend.account.wishlist');

    // Reviews
    Route::post('/products/{product}/reviews', [\App\Http\Controllers\Frontend\ProductReviewController::class, 'store'])->name('frontend.products.reviews.store');
});
