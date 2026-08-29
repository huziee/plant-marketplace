<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlistItems = Wishlist::where('user_id', auth()->id())
            ->with(['product.featuredImage', 'product.category'])
            ->latest()
            ->paginate(12);

        return view('frontend.account.wishlist.index', compact('wishlistItems'));
    }

    public function toggle(Request $request, Product $product)
    {
        $user = auth()->user();
        $existing = Wishlist::where('user_id', $user->id)->where('product_id', $product->id)->first();

        if ($existing) {
            $existing->delete();
            $added = false;
            $msg = "{$product->name} removed from your wishlist.";
        } else {
            Wishlist::create(['user_id' => $user->id, 'product_id' => $product->id]);
            $added = true;
            $msg = "{$product->name} added to your wishlist.";
        }

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'added' => $added, 'message' => $msg]);
        }

        return redirect()->back()->with('success', $msg);
    }
}
