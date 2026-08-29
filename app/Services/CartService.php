<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CartService
{
    public function __construct(
        protected InventoryService $inventoryService
    ) {}

    public function getCart(?User $user = null): Cart
    {
        $sessionId = Session::getId();

        if ($user) {
            $cart = Cart::where('user_id', $user->id)->where('status', 'active')->first();
            if (!$cart) {
                $cart = Cart::create([
                    'user_id' => $user->id,
                    'session_id' => $sessionId,
                    'status' => 'active',
                ]);
            }
            return $cart->load(['items.product.featuredImage', 'items.variant']);
        }

        $cart = Cart::where('session_id', $sessionId)->whereNull('user_id')->where('status', 'active')->first();
        if (!$cart) {
            $cart = Cart::create([
                'session_id' => $sessionId,
                'status' => 'active',
            ]);
        }

        return $cart->load(['items.product.featuredImage', 'items.variant']);
    }

    public function addItem(Product $product, int $quantity = 1, ?ProductVariant $variant = null, ?User $user = null): array
    {
        $cart = $this->getCart($user);
        $variantId = $variant?->id;

        if (!$this->inventoryService->checkStock($product, $quantity, $variant)) {
            return ['success' => false, 'message' => 'Requested quantity exceeds available stock.'];
        }

        $price = $variant ? $variant->effective_price : (float) $product->price;

        $item = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $product->id)
            ->where('product_variant_id', $variantId)
            ->first();

        if ($item) {
            $newQty = $item->quantity + $quantity;
            if (!$this->inventoryService->checkStock($product, $newQty, $variant)) {
                return ['success' => false, 'message' => 'Cannot add more units of this item. Stock limit reached.'];
            }
            $item->update([
                'quantity' => $newQty,
                'unit_price' => $price,
            ]);
        } else {
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $product->id,
                'product_variant_id' => $variantId,
                'quantity' => $quantity,
                'unit_price' => $price,
            ]);
        }

        $cart->refresh();

        return [
            'success' => true,
            'message' => "{$product->name} added to cart.",
            'cart_count' => $cart->item_count,
            'cart_subtotal' => $cart->subtotal,
        ];
    }

    public function updateQuantity(int $cartItemId, int $quantity, ?User $user = null): array
    {
        $cart = $this->getCart($user);
        $item = CartItem::where('cart_id', $cart->id)->where('id', $cartItemId)->first();

        if (!$item) {
            return ['success' => false, 'message' => 'Cart item not found.'];
        }

        if ($quantity <= 0) {
            $item->delete();
        } else {
            if (!$this->inventoryService->checkStock($item->product, $quantity, $item->variant)) {
                return ['success' => false, 'message' => 'Requested quantity is out of stock.'];
            }
            $item->update([
                'quantity' => $quantity,
                'unit_price' => $item->variant ? $item->variant->effective_price : (float) $item->product->price,
            ]);
        }

        $cart->refresh();

        return [
            'success' => true,
            'message' => 'Cart updated successfully.',
            'cart_count' => $cart->item_count,
            'cart_subtotal' => $cart->subtotal,
        ];
    }

    public function removeItem(int $cartItemId, ?User $user = null): array
    {
        $cart = $this->getCart($user);
        CartItem::where('cart_id', $cart->id)->where('id', $cartItemId)->delete();

        $cart->refresh();

        return [
            'success' => true,
            'message' => 'Item removed from cart.',
            'cart_count' => $cart->item_count,
            'cart_subtotal' => $cart->subtotal,
        ];
    }

    public function mergeGuestCart(User $user, string $guestSessionId): void
    {
        DB::transaction(function () use ($user, $guestSessionId) {
            $guestCart = Cart::where('session_id', $guestSessionId)->whereNull('user_id')->where('status', 'active')->first();
            if (!$guestCart || $guestCart->items->isEmpty()) {
                return;
            }

            $userCart = Cart::firstOrCreate(
                ['user_id' => $user->id, 'status' => 'active'],
                ['session_id' => Session::getId()]
            );

            foreach ($guestCart->items as $gItem) {
                $existing = CartItem::where('cart_id', $userCart->id)
                    ->where('product_id', $gItem->product_id)
                    ->where('product_variant_id', $gItem->product_variant_id)
                    ->first();

                if ($existing) {
                    $existing->update([
                        'quantity' => $existing->quantity + $gItem->quantity,
                        'unit_price' => $gItem->unit_price,
                    ]);
                } else {
                    $gItem->update(['cart_id' => $userCart->id]);
                }
            }

            $guestCart->update(['status' => 'converted']);
        });
    }

    public function clearCart(Cart $cart): void
    {
        $cart->items()->delete();
        $cart->update(['status' => 'converted']);
    }
}
