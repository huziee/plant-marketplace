<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductReview;
use Illuminate\Http\Request;

class ProductReviewController extends Controller
{
    public function index(Request $request)
    {
        $query = ProductReview::with(['product', 'user']);

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $reviews = $query->latest()->paginate(15)->withQueryString();

        return view('admin.reviews.index', compact('reviews'));
    }

    public function updateStatus(Request $request, ProductReview $review)
    {
        $request->validate(['status' => 'required|string|in:pending,approved,rejected']);
        $review->update(['status' => $request->input('status')]);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Review status updated successfully.',
                'status' => $review->status
            ]);
        }

        return redirect()->back()->with('success', 'Review status updated successfully.');
    }

    public function destroy(Request $request, ProductReview $review)
    {
        $review->delete();

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Review deleted successfully.']);
        }

        return redirect()->back()->with('success', 'Review deleted successfully.');
    }
}
