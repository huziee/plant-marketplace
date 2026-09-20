<?php

use App\Http\Controllers\Admin\ContentCategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MediaController;
use App\Http\Controllers\Admin\NewsletterSubscriberController;
use App\Http\Controllers\Admin\PlantCategoryController;
use App\Http\Controllers\Admin\PlantController;
use App\Http\Controllers\Admin\PlantProblemController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:admin,editor,author'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        // Users Management
        Route::resource('users', UserController::class)->only(['index', 'show', 'edit', 'update']);

        // Plant Categories Management
        Route::resource('plant-categories', PlantCategoryController::class)->except(['show']);

        // Plants Management
        Route::post('plants/{plant}/duplicate', [PlantController::class, 'duplicate'])->name('plants.duplicate');
        Route::resource('plants', PlantController::class)->except(['show']);

        // Plant Problems Management
        Route::resource('plant-problems', PlantProblemController::class)->except(['show']);

        // Content Publishing Management (Articles, Guides, News)
        Route::post('posts/{post}/duplicate', [PostController::class, 'duplicate'])->name('posts.duplicate');
        Route::get('posts/{post}/preview', [PostController::class, 'preview'])->name('posts.preview');
        Route::resource('posts', PostController::class)->except(['show']);
        Route::resource('content-categories', ContentCategoryController::class)->except(['show']);
        Route::resource('tags', TagController::class)->only(['index', 'store', 'update', 'destroy']);

        // Content Automation Suite (GDELT News & OpenAlex Articles)
        Route::get('content-automation', [\App\Http\Controllers\Admin\ContentAutomationController::class, 'index'])->name('content-automation.index');
        Route::get('content-automation/settings', [\App\Http\Controllers\Admin\ContentAutomationController::class, 'settings'])->name('content-automation.settings');
        Route::post('content-automation/settings', [\App\Http\Controllers\Admin\ContentAutomationController::class, 'updateSettings'])->name('content-automation.settings.update');
        Route::post('content-automation/topics', [\App\Http\Controllers\Admin\ContentAutomationController::class, 'storeTopic'])->name('content-automation.topics.store');
        Route::delete('content-automation/topics/{topic}', [\App\Http\Controllers\Admin\ContentAutomationController::class, 'deleteTopic'])->name('content-automation.topics.destroy');
        Route::get('content-automation/{candidate}', [\App\Http\Controllers\Admin\ContentAutomationController::class, 'show'])->name('content-automation.show');
        Route::post('content-automation/{candidate}/select', [\App\Http\Controllers\Admin\ContentAutomationController::class, 'select'])->name('content-automation.select');
        Route::post('content-automation/{candidate}/reject', [\App\Http\Controllers\Admin\ContentAutomationController::class, 'reject'])->name('content-automation.reject');
        Route::post('content-automation/{candidate}/generate', [\App\Http\Controllers\Admin\ContentAutomationController::class, 'generate'])->name('content-automation.generate');
        Route::post('content-automation/{candidate}/retry', [\App\Http\Controllers\Admin\ContentAutomationController::class, 'retry'])->name('content-automation.retry');

        // Ecommerce Admin System
        Route::resource('product-categories', \App\Http\Controllers\Admin\ProductCategoryController::class);
        Route::resource('products', \App\Http\Controllers\Admin\ProductController::class);
        Route::get('inventory', [\App\Http\Controllers\Admin\InventoryController::class, 'index'])->name('inventory.index');
        Route::get('orders', [\App\Http\Controllers\Admin\OrderController::class, 'index'])->name('orders.index');
        Route::get('orders/{order}', [\App\Http\Controllers\Admin\OrderController::class, 'show'])->name('orders.show');
        Route::post('orders/{order}/status', [\App\Http\Controllers\Admin\OrderController::class, 'updateStatus'])->name('orders.update-status');
        Route::resource('coupons', \App\Http\Controllers\Admin\CouponController::class)->only(['index', 'store', 'destroy']);
        Route::get('reviews', [\App\Http\Controllers\Admin\ProductReviewController::class, 'index'])->name('reviews.index');
        Route::post('reviews/{review}/status', [\App\Http\Controllers\Admin\ProductReviewController::class, 'updateStatus'])->name('reviews.update-status');
        Route::delete('reviews/{review}', [\App\Http\Controllers\Admin\ProductReviewController::class, 'destroy'])->name('reviews.destroy');
        Route::resource('shipping-methods', \App\Http\Controllers\Admin\ShippingMethodController::class)->only(['index', 'store', 'update', 'destroy']);
        Route::resource('product-collections', \App\Http\Controllers\Admin\ProductCollectionController::class)->only(['index', 'store', 'destroy']);

        // Settings System
        Route::get('settings', [SettingsController::class, 'index'])->name('settings.index');
        Route::post('settings', [SettingsController::class, 'update'])->name('settings.update');

        // Media Library
        Route::get('media', [MediaController::class, 'index'])->name('media.index');
        Route::post('media', [MediaController::class, 'store'])->name('media.store');
        Route::put('media/{media}', [MediaController::class, 'update'])->name('media.update');
        Route::delete('media/{media}', [MediaController::class, 'destroy'])->name('media.destroy');

        // Pages CMS System
        Route::resource('pages', \App\Http\Controllers\Admin\PageController::class);

        // Contact Messages Management
        Route::get('contact-messages', [\App\Http\Controllers\Admin\ContactMessageController::class, 'index'])->name('contact-messages.index');
        Route::get('contact-messages/{message}', [\App\Http\Controllers\Admin\ContactMessageController::class, 'show'])->name('contact-messages.show');
        Route::patch('contact-messages/{message}/status', [\App\Http\Controllers\Admin\ContactMessageController::class, 'updateStatus'])->name('contact-messages.update-status');
        Route::delete('contact-messages/{message}', [\App\Http\Controllers\Admin\ContactMessageController::class, 'destroy'])->name('contact-messages.destroy');

        // Newsletter Subscribers
        Route::get('newsletter-subscribers', [NewsletterSubscriberController::class, 'index'])->name('subscribers.index');
        Route::delete('newsletter-subscribers/{subscriber}', [NewsletterSubscriberController::class, 'destroy'])->name('subscribers.destroy');
    });
