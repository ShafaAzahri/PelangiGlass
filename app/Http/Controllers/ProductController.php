<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ProductController extends Controller
{
    public function index(Request $request): Response
    {
        $categories = ProductCategory::where('is_active', true)->orderBy('sort_order')->get();

        $query = Product::active()->with('category');

        if ($request->filled('kategori')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->kategori);
            });
        }

        if ($request->filled('q')) {
            $search = str_replace(['\\', '%', '_'], ['\\\\', '\\%', '\\_'], trim($request->q));
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('vehicle_compatibility', 'like', "%{$search}%")
                    ->orWhere('short_description', 'like', "%{$search}%");
            });
        }

        $products = $query->paginate(12)->withQueryString();

        return Inertia::render('Produk/Index', [
            'products' => $products,
            'categories' => $categories,
            'filters' => [
                'kategori' => $request->kategori,
                'q' => $request->q,
            ],
        ]);
    }

    public function show(string $slug): Response
    {
        $product = Product::active()->where('slug', $slug)->with('category')->firstOrFail();
        $relatedProducts = Product::active()
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->with('category')
            ->take(4)
            ->get();

        return Inertia::render('Produk/Show', [
            'product' => $product,
            'relatedProducts' => $relatedProducts,
        ]);
    }
}
