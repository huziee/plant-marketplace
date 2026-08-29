<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ShippingMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ShippingMethodController extends Controller
{
    public function index()
    {
        $methods = ShippingMethod::orderBy('sort_order')->get();
        return view('admin.shipping.index', compact('methods'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:50|unique:shipping_methods,code',
            'type' => 'required|string|in:flat_rate,free_shipping,pickup',
            'price' => 'required|numeric|min:0',
            'free_shipping_threshold' => 'nullable|numeric|min:0',
            'description' => 'nullable|string',
            'status' => 'required|string|in:active,inactive',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $data['code'] = !empty($data['code']) ? Str::slug($data['code']) : Str::slug($data['name']);
        ShippingMethod::create($data);

        return redirect()->route('admin.shipping-methods.index')->with('success', 'Shipping method created successfully.');
    }

    public function update(Request $request, ShippingMethod $shippingMethod)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'code' => "nullable|string|max:50|unique:shipping_methods,code,{$shippingMethod->id}",
            'type' => 'required|string|in:flat_rate,free_shipping,pickup',
            'price' => 'required|numeric|min:0',
            'free_shipping_threshold' => 'nullable|numeric|min:0',
            'description' => 'nullable|string',
            'status' => 'required|string|in:active,inactive',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $shippingMethod->update($data);

        return redirect()->route('admin.shipping-methods.index')->with('success', 'Shipping method updated successfully.');
    }

    public function destroy(ShippingMethod $shippingMethod)
    {
        $shippingMethod->delete();
        return redirect()->route('admin.shipping-methods.index')->with('success', 'Shipping method deleted successfully.');
    }
}
