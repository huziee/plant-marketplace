<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ProductType;
use App\Enums\StockStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Plant;
use App\Models\PlantProblem;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Services\InventoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function __construct(
        protected InventoryService $inventoryService
    ) {}

    public function index(Request $request)
    {
        $query = Product::with(['category', 'featuredImage', 'plant']);

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category_id')) {
            $query->where('product_category_id', $request->input('category_id'));
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('product_type')) {
            $query->where('product_type', $request->input('product_type'));
        }

        $products = $query->latest()->paginate(15)->withQueryString();
        $categories = ProductCategory::orderBy('name')->get();
        $productTypes = ProductType::cases();

        return view('admin.products.index', compact('products', 'categories', 'productTypes'));
    }

    public function create()
    {
        $categories = ProductCategory::orderBy('name')->get();
        $plants = Plant::orderBy('name')->get();
        $plantProblems = PlantProblem::orderBy('title')->get();
        $productTypes = ProductType::cases();

        return view('admin.products.create', compact('categories', 'plants', 'plantProblems', 'productTypes'));
    }

    public function store(StoreProductRequest $request)
    {
        $data = $request->validated();
        $data['slug'] = !empty($data['slug']) ? Str::slug($data['slug']) : Str::slug($data['name']);
        $data['is_featured'] = !empty($data['is_featured']);
        $data['is_new'] = !empty($data['is_new']);
        $data['is_best_seller'] = !empty($data['is_best_seller']);
        $data['created_by'] = auth()->id();
        $data['published_at'] = $data['status'] === 'published' ? now() : null;

        $qty = (int) ($data['stock_quantity'] ?? 0);
        $data['stock_status'] = $qty <= 0 ? StockStatus::OUT_OF_STOCK->value : ($qty <= ($data['low_stock_threshold'] ?? 5) ? StockStatus::LOW_STOCK->value : StockStatus::IN_STOCK->value);

        $product = Product::create($data);

        // Record initial inventory movement if quantity > 0
        if ($qty > 0) {
            $this->inventoryService->increaseStock(
                $product,
                $qty,
                null,
                \App\Enums\InventoryMovementType::INITIAL,
                'Product',
                $product->id,
                'Initial Product Stock Creation',
                auth()->user()
            );
        }

        return redirect()->route('admin.products.edit', $product)->with('success', 'Product created successfully.');
    }

    public function edit(Product $product)
    {
        $product->load(['category', 'featuredImage', 'images.media', 'plant', 'plantProblems', 'relatedProducts']);
        $categories = ProductCategory::orderBy('name')->get();
        $plants = Plant::orderBy('name')->get();
        $plantProblems = PlantProblem::orderBy('title')->get();
        $productTypes = ProductType::cases();
        $allProducts = Product::where('id', '!=', $product->id)->orderBy('name')->get();

        return view('admin.products.edit', compact('product', 'categories', 'plants', 'plantProblems', 'productTypes', 'allProducts'));
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $data = $request->validated();
        $data['slug'] = !empty($data['slug']) ? Str::slug($data['slug']) : Str::slug($data['name']);
        $data['is_featured'] = !empty($data['is_featured']);
        $data['is_new'] = !empty($data['is_new']);
        $data['is_best_seller'] = !empty($data['is_best_seller']);
        $data['updated_by'] = auth()->id();

        if ($data['status'] === 'published' && !$product->published_at) {
            $data['published_at'] = now();
        }

        $oldQty = $product->stock_quantity;
        $newQty = (int) ($data['stock_quantity'] ?? 0);

        if ($oldQty !== $newQty) {
            $diff = $newQty - $oldQty;
            if ($diff > 0) {
                $this->inventoryService->increaseStock($product, $diff, null, \App\Enums\InventoryMovementType::ADJUSTMENT, 'Product', $product->id, 'Manual Stock Adjustment via Edit', auth()->user());
            } else {
                $this->inventoryService->decreaseStock($product, abs($diff), null, 'Product', $product->id, 'Manual Stock Adjustment via Edit', auth()->user());
            }
        }

        $product->update($data);

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Product soft deleted.');
    }
}
