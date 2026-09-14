<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\CheckoutRequest;
use App\Models\Order;
use App\Services\CartService;
use App\Services\CheckoutService;
use App\Services\CouponService;
use App\Services\ShippingService;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function __construct(
        protected CartService $cartService,
        protected ShippingService $shippingService,
        protected CouponService $couponService,
        protected CheckoutService $checkoutService
    ) {}

    public function index(\App\Services\SEO\SeoService $seoService)
    {
        $seoService->setTitle('Secure Checkout')
                   ->setDescription('Complete your order securely.')
                   ->setCanonical(route('frontend.checkout.index'))
                   ->setRobots('noindex,nofollow');

        $user = auth()->user();
        $cart = $this->cartService->getCart($user);

        if ($cart->items->isEmpty()) {
            return redirect()->route('frontend.cart.index')->with('error', 'Your cart is empty. Add items before proceeding to checkout.');
        }

        $shippingMethods = $this->shippingService->getAvailableMethods($cart->subtotal);
        $userAddresses = $user->addresses;
        $defaultAddress = $userAddresses->where('is_default_shipping', true)->first() ?: $userAddresses->first();

        $couponCode = session('coupon_code');
        $discountAmount = 0.00;

        if ($couponCode) {
            $cRes = $this->couponService->validateCoupon($couponCode, $cart->subtotal, $user);
            if ($cRes['valid']) {
                $discountAmount = $cRes['discount'];
            }
        }

        return view('frontend.checkout.index', compact('cart', 'shippingMethods', 'userAddresses', 'defaultAddress', 'couponCode', 'discountAmount', 'seoService'));
    }

    public function process(CheckoutRequest $request)
    {
        try {
            $user = auth()->user();
            $data = $request->validated();
            $data['coupon_code'] = session('coupon_code');

            $order = $this->checkoutService->processCheckout($user, $data);
            session()->forget('coupon_code');

            return redirect()->route('frontend.checkout.success', $order->order_number)->with('success', 'Order placed successfully!');
        } catch (\InvalidArgumentException $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Failed to process your order. Please try again: ' . $e->getMessage());
        }
    }

    public function success(string $orderNumber, \App\Services\SEO\SeoService $seoService)
    {
        $seoService->setTitle('Order Confirmation')
                   ->setDescription('Thank you for your order.')
                   ->setCanonical(route('frontend.checkout.success', $orderNumber))
                   ->setRobots('noindex,nofollow');

        $order = Order::where('order_number', $orderNumber)
            ->where('user_id', auth()->id())
            ->with(['items.product.featuredImage'])
            ->firstOrFail();

        return view('frontend.checkout.success', compact('order', 'seoService'));
    }
}
