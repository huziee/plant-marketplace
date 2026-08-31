<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Services\CartService;
use App\Services\CouponService;
use App\Services\ShippingService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct(
        protected CartService $cartService,
        protected ShippingService $shippingService,
        protected CouponService $couponService
    ) {}

    public function index(Request $request)
    {
        $cart = $this->cartService->getCart(auth()->user());
        $shippingMethods = $this->shippingService->getAvailableMethods($cart->subtotal);

        $appliedCoupon = null;
        $discountAmount = 0.00;

        if (session()->has('coupon_code')) {
            $couponRes = $this->couponService->validateCoupon(session('coupon_code'), $cart->subtotal, auth()->user());
            if ($couponRes['valid']) {
                $appliedCoupon = $couponRes['coupon'];
                $discountAmount = $couponRes['discount'];
            } else {
                session()->forget('coupon_code');
            }
        }

        return view('frontend.cart.index', compact('cart', 'shippingMethods', 'appliedCoupon', 'discountAmount'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'variant_id' => 'nullable|exists:product_variants,id',
            'quantity' => 'nullable|integer|min:1',
        ]);

        $product = Product::findOrFail($request->input('product_id'));
        $variant = $request->filled('variant_id') ? ProductVariant::find($request->input('variant_id')) : null;
        $quantity = (int) ($request->input('quantity', 1));

        $result = $this->cartService->addItem($product, $quantity, $variant, auth()->user());

        if ($request->wantsJson()) {
            return response()->json($result);
        }

        if (!$result['success']) {
            return redirect()->back()->with('error', $result['message']);
        }

        return redirect()->route('frontend.cart.index')->with('success', $result['message']);
    }

    public function update(Request $request, int $id)
    {
        $request->validate(['quantity' => 'required|integer|min:0']);
        $result = $this->cartService->updateQuantity($id, (int) $request->input('quantity'), auth()->user());

        if ($request->wantsJson()) {
            return response()->json($result);
        }

        return redirect()->back()->with($result['success'] ? 'success' : 'error', $result['message']);
    }

    public function remove(Request $request, int $id)
    {
        $result = $this->cartService->removeItem($id, auth()->user());

        if ($request->wantsJson()) {
            return response()->json($result);
        }

        return redirect()->back()->with('success', $result['message']);
    }

    public function applyCoupon(Request $request)
    {
        $request->validate(['coupon_code' => 'required|string']);
        $cart = $this->cartService->getCart(auth()->user());

        $res = $this->couponService->validateCoupon($request->input('coupon_code'), $cart->subtotal, auth()->user());

        if (!$res['valid']) {
            if ($request->wantsJson()) {
                return response()->json(['success' => false, 'message' => $res['message']], 422);
            }
            return redirect()->back()->with('error', $res['message']);
        }

        session(['coupon_code' => $res['coupon']->code]);

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'message' => $res['message'], 'coupon_code' => $res['coupon']->code, 'discount' => $res['discount']]);
        }

        return redirect()->back()->with('success', $res['message']);
    }

    public function removeCoupon(Request $request)
    {
        session()->forget('coupon_code');

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Coupon removed.']);
        }

        return redirect()->back()->with('success', 'Coupon removed.');
    }
}
