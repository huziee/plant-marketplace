<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReviewRequest;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductReview;
use Illuminate\Http\Request;

class ProductReviewController extends Controller
{
    public function store(StoreReviewRequest $request, Product $product)
    {
        $user = auth()->user();

        // Check verified purchase
        $verifiedOrder = Order::where('user_id', $user->id)
            ->where('status', 'delivered')
            ->whereHas('items', function ($q) use ($product) {
                $q->where('product_id', $product->id);
            })->first();

        ProductReview::updateOrCreate(
            [
                'product_id' => $product->id,
                'user_id' => $user->id,
            ],
            [
                'order_id' => $verifiedOrder?->id,
                'rating' => $request->input('rating'),
                'title' => $request->input('title'),
                'review' => $request->input('review'),
                'status' => 'approved', // Auto approve for verified or pending
                'verified_purchase' => (bool) $verifiedOrder,
            ]
        );

        return redirect()->back()->with('success', 'Thank you! Your product review has been published.');
    }
}
