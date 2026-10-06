<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Setting;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $categories = ProductCategory::where('is_active', true)->orderBy('sort_order')->get();

        $query = Product::active()->with('category');

        if ($request->filled('kategori')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->kategori);
            });
        }

        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'ilike', "%{$search}%")
                    ->orWhere('vehicle_compatibility', 'ilike', "%{$search}%")
                    ->orWhere('short_description', 'ilike', "%{$search}%");
            });
        }

        $products = $query->paginate(12)->withQueryString();
        $settings = Setting::all()->pluck('value', 'key');

        return view('pages.produk.index', compact('products', 'categories', 'settings'));
    }

    public function show(string $slug)
    {
        $product = Product::active()->where('slug', $slug)->with('category')->firstOrFail();
        $relatedProducts = Product::active()
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->with('category')
            ->take(4)
            ->get();

        $settings = Setting::all()->pluck('value', 'key');

        return view('pages.produk.show', compact('product', 'relatedProducts', 'settings'));
    }
}
