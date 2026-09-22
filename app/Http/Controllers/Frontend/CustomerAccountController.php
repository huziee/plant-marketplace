<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAddressRequest;
use App\Models\CustomerAddress;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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

    public function editPassword(\App\Services\SEO\SeoService $seoService)
    {
        $seoService->setTitle('Change Password - My Account')
                   ->setRobots('noindex,nofollow');

        $user = auth()->user();
        return view('frontend.account.password', compact('user', 'seoService'));
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = auth()->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'The provided current password does not match our records.']);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Password changed successfully!');
    }

    public function editProfile(\App\Services\SEO\SeoService $seoService)
    {
        $seoService->setTitle('My Profile & Account Settings')
                   ->setRobots('noindex,nofollow');

        $user = auth()->user()->load('authorProfile');

        return view('frontend.account.profile', compact('user', 'seoService'));
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $rules = [
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'phone' => ['nullable', 'string', 'max:30'],
            'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
        ];

        if (in_array($user->role, ['admin', 'editor', 'author'], true)) {
            $rules['job_title'] = ['nullable', 'string', 'max:150'];
            $rules['bio'] = ['nullable', 'string', 'max:1000'];
            $rules['website'] = ['nullable', 'url', 'max:255'];
            $rules['linkedin'] = ['nullable', 'string', 'max:255'];
            $rules['facebook'] = ['nullable', 'string', 'max:255'];
            $rules['instagram'] = ['nullable', 'string', 'max:255'];
        }

        $validated = $request->validate($rules);

        if ($request->hasFile('avatar')) {
            if ($user->avatar && \Illuminate\Support\Facades\Storage::disk('public')->exists($user->avatar)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($user->avatar);
            }
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $avatarPath;
        }

        $user->first_name = $validated['first_name'];
        $user->last_name = $validated['last_name'];
        $user->email = $validated['email'];
        $user->phone = $validated['phone'] ?? null;
        $user->save();

        if (in_array($user->role, ['admin', 'editor', 'author'], true)) {
            $authorData = [
                'job_title' => $request->input('job_title'),
                'bio' => $request->input('bio'),
                'website' => $request->input('website'),
                'linkedin' => $request->input('linkedin'),
                'facebook' => $request->input('facebook'),
                'instagram' => $request->input('instagram'),
            ];

            if ($user->authorProfile) {
                $user->authorProfile->update($authorData);
            } else {
                $user->authorProfile()->create($authorData);
            }
        }

        return redirect()->route('frontend.account.profile')->with('success', 'Profile updated successfully!');
    }
}
