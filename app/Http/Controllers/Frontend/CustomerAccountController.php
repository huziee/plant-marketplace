<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAddressRequest;
use App\Models\CustomerAddress;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\Request;

class CustomerAccountController extends Controller
{
    public function __construct(
        protected OrderService $orderService
    ) {}

    public function dashboard(\App\Services\SEO\SeoService $seoService)
    {
        $seoService->setTitle('My Account Dashboard')
                   ->setRobots('noindex,nofollow');

        $user = auth()->user();
        $recentOrders = Order::where('user_id', $user->id)->with('items')->latest()->take(5)->get();
        $totalOrders = Order::where('user_id', $user->id)->count();
        $defaultAddress = $user->addresses()->where('is_default_shipping', true)->first();

        return view('frontend.account.dashboard', compact('user', 'recentOrders', 'totalOrders', 'defaultAddress', 'seoService'));
    }

    public function orders(\App\Services\SEO\SeoService $seoService)
    {
        $seoService->setTitle('My Orders')
                   ->setRobots('noindex,nofollow');

        $orders = Order::where('user_id', auth()->id())->latest()->paginate(10);
        return view('frontend.account.orders.index', compact('orders', 'seoService'));
    }

    public function showOrder(string $orderNumber, \App\Services\SEO\SeoService $seoService)
    {
        $seoService->setTitle("Order #{$orderNumber}")
                   ->setRobots('noindex,nofollow');

        $order = Order::where('order_number', $orderNumber)
            ->where('user_id', auth()->id())
            ->with(['items.product.featuredImage', 'statusHistories', 'payments'])
            ->firstOrFail();

        return view('frontend.account.orders.show', compact('order', 'seoService'));
    }

    public function cancelOrder(Request $request, string $orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        try {
            $this->orderService->cancelOrder($order, 'Cancelled by customer from account panel', auth()->user());
            return redirect()->back()->with('success', 'Order cancelled successfully.');
        } catch (\InvalidArgumentException $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function addresses(\App\Services\SEO\SeoService $seoService)
    {
        $seoService->setTitle('My Saved Addresses')
                   ->setRobots('noindex,nofollow');

        $addresses = auth()->user()->addresses;
        return view('frontend.account.addresses.index', compact('addresses', 'seoService'));
    }

    public function storeAddress(StoreAddressRequest $request)
    {
        $user = auth()->user();
        $data = $request->validated();
        $data['user_id'] = $user->id;

        if (!empty($data['is_default_shipping'])) {
            CustomerAddress::where('user_id', $user->id)->update(['is_default_shipping' => false]);
        }

        if (!empty($data['is_default_billing'])) {
            CustomerAddress::where('user_id', $user->id)->update(['is_default_billing' => false]);
        }

        CustomerAddress::create($data);

        return redirect()->back()->with('success', 'Address added successfully.');
    }

    public function deleteAddress(CustomerAddress $address)
    {
        if ($address->user_id !== auth()->id()) {
            abort(403);
        }

        $address->delete();
        return redirect()->back()->with('success', 'Address deleted successfully.');
    }
}
