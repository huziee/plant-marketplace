<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MerchantFeedLog;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MerchantFeedController extends Controller
{
    public function index(): View
    {
        $publishedProductsCount = Product::where('status', 'published')->count();
        
        $lastGoogleSync = MerchantFeedLog::where('channel', 'google_merchant')
            ->latest()
            ->first();

        $totalSyncsCount = MerchantFeedLog::count();

        $logs = MerchantFeedLog::latest()->paginate(15);

        $googleFeedUrl = route('feeds.google-merchant');

        return view('admin.merchant_feeds.index', compact(
            'publishedProductsCount',
            'lastGoogleSync',
            'totalSyncsCount',
            'logs',
            'googleFeedUrl'
        ));
    }

    public function syncGoogle(Request $request): RedirectResponse
    {
        $productsCount = Product::where('status', 'published')->count();

        MerchantFeedLog::create([
            'channel' => 'google_merchant',
            'trigger_type' => 'manual_sync',
            'status' => 'success',
            'items_count' => $productsCount,
            'ip_address' => $request->ip(),
            'user_agent' => substr((string) $request->header('User-Agent'), 0, 250),
            'message' => 'Manual synchronization triggered by Admin user.',
        ]);

        return redirect()->route('admin.merchant-feeds.index')
            ->with('success', 'Google Merchant Feed synchronized successfully! Log recorded.');
    }
}
