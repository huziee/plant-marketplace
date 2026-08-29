<?php

namespace Tests\Feature;

use App\Enums\OrderStatus;
use App\Models\Cart;
use App\Models\Coupon;
use App\Models\CustomerAddress;
use App\Models\InventoryMovement;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ShippingMethod;
use App\Models\User;
use App\Services\CartService;
use App\Services\CheckoutService;
use App\Services\InventoryService;
use App\Services\OrderService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EcommerceTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected User $admin;
    protected ProductCategory $category;
    protected Product $product;
    protected ShippingMethod $shippingMethod;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create(['role' => 'customer']);
        $this->admin = User::factory()->create(['role' => 'admin']);

        $this->category = ProductCategory::create([
            'name' => 'Indoor Plants',
            'slug' => 'indoor-plants',
            'status' => 'active',
        ]);

        $this->product = Product::create([
            'name' => 'Fiddle Leaf Fig',
            'slug' => 'fiddle-leaf-fig',
            'sku' => 'PLT-FIG-01',
            'product_category_id' => $this->category->id,
            'price' => 2500.00,
            'stock_quantity' => 20,
            'status' => 'published',
        ]);

        $this->shippingMethod = ShippingMethod::create([
            'name' => 'Express Courier',
            'code' => 'express',
            'price' => 200.00,
            'status' => 'active',
        ]);
    }

    public function test_guest_can_view_shop_index_and_product_detail(): void
    {
        $response = $this->get('/shop');
        $response->assertStatus(200);
        $response->assertSee('Fiddle Leaf Fig');

        $detailResponse = $this->get("/shop/products/{$this->product->slug}");
        $detailResponse->assertStatus(200);
        $detailResponse->assertSee('Fiddle Leaf Fig');
        $detailResponse->assertSee('Rs. 2,500');
    }

    public function test_customer_can_add_product_to_cart(): void
    {
        $response = $this->actingAs($this->user)->post('/cart/add', [
            'product_id' => $this->product->id,
            'quantity' => 2,
        ]);

        $response->assertRedirect('/cart');

        $cart = Cart::where('user_id', $this->user->id)->first();
        $this->assertNotNull($cart);
        $this->assertEquals(1, $cart->items()->count());
        $this->assertEquals(2, $cart->items()->first()->quantity);
        $this->assertEquals(5000.00, $cart->subtotal);
    }

    public function test_coupon_validation_and_discount(): void
    {
        $coupon = Coupon::create([
            'code' => 'WELCOME10',
            'type' => 'percentage',
            'value' => 10.00,
            'status' => 'active',
        ]);

        $this->actingAs($this->user)->post('/cart/add', [
            'product_id' => $this->product->id,
            'quantity' => 1,
        ]);

        $response = $this->actingAs($this->user)->post('/cart/coupon', [
            'coupon_code' => 'WELCOME10',
        ]);

        $response->assertSessionHas('coupon_code', 'WELCOME10');
    }

    public function test_checkout_creates_order_and_deducts_inventory(): void
    {
        // Add product to user cart
        $this->actingAs($this->user)->post('/cart/add', [
            'product_id' => $this->product->id,
            'quantity' => 3,
        ]);

        $checkoutData = [
            'shipping_address' => [
                'first_name' => 'Ali',
                'last_name' => 'Khan',
                'email' => 'ali@example.com',
                'phone' => '03001234567',
                'address_line_1' => 'Street 10, Gulberg III',
                'city' => 'Lahore',
                'country' => 'Pakistan',
            ],
            'shipping_method_id' => $this->shippingMethod->id,
            'payment_method' => 'cash_on_delivery',
        ];

        $response = $this->actingAs($this->user)->post('/checkout', $checkoutData);

        $order = Order::where('user_id', $this->user->id)->first();
        $this->assertNotNull($order);
        $response->assertRedirect("/checkout/success/{$order->order_number}");

        $this->assertEquals(1, $order->items()->count());
        $this->assertEquals(3, $order->items()->first()->quantity);

        // Verify stock deduction
        $this->product->refresh();
        $this->assertEquals(17, $this->product->stock_quantity);

        // Verify inventory movement record
        $this->assertDatabaseHas('inventory_movements', [
            'product_id' => $this->product->id,
            'type' => 'sale',
            'quantity' => -3,
        ]);
    }

    public function test_customer_can_cancel_pending_order_and_restores_stock(): void
    {
        $checkoutService = app(CheckoutService::class);
        $cartService = app(CartService::class);

        $cartService->addItem($this->product, 4, null, $this->user);

        $order = $checkoutService->processCheckout($this->user, [
            'shipping_address' => [
                'first_name' => 'Sara',
                'last_name' => 'Ahmed',
                'email' => 'sara@example.com',
                'phone' => '03009876543',
                'address_line_1' => 'DHA Phase 5',
                'city' => 'Lahore',
                'country' => 'Pakistan',
            ],
            'shipping_method_id' => $this->shippingMethod->id,
            'payment_method' => 'cash_on_delivery',
        ]);

        $this->assertEquals(16, $this->product->fresh()->stock_quantity);

        $response = $this->actingAs($this->user)->post("/account/orders/{$order->order_number}/cancel");
        $response->assertRedirect();

        $order->refresh();
        $this->assertEquals(OrderStatus::CANCELLED, $order->status);

        // Verify stock restoration
        $this->assertEquals(20, $this->product->fresh()->stock_quantity);

        $this->assertDatabaseHas('inventory_movements', [
            'product_id' => $this->product->id,
            'type' => 'cancelled_order_restore',
            'quantity' => 4,
        ]);
    }

    public function test_sitemap_includes_products_xml(): void
    {
        $response = $this->get('/sitemap.xml');
        $response->assertStatus(200);
        $response->assertSee('/sitemaps/products.xml');

        $prodSitemap = $this->get('/sitemaps/products.xml');
        $prodSitemap->assertStatus(200);
        $prodSitemap->assertSee("/shop/products/{$this->product->slug}");
    }
}
