<?php

namespace App\Http\Controllers;

use App\Models\Promo;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class PromoController extends Controller
{
    public function index(Request $request): Response
    {
        $dbPromos = Promo::active()->with('product')->get();

        $categories = array_values(array_unique(array_merge(
            ['Semua', 'Kaca Film', 'Ganti Kaca', 'Perbaikan Kaca', 'Aksesoris & Perawatan'],
            $dbPromos->pluck('category')->filter()->toArray()
        )));

        $promos = $dbPromos->map(fn ($p) => [
            'id' => $p->id,
            'product_id' => $p->product_id,
            'product_slug' => $p->product?->slug,
            'product_name' => $p->product?->name,
            'slug' => $p->slug,
            'name' => $p->name,
            'category' => $p->category,
            'desc' => $p->desc,
            'img' => $p->image_url,
            'badge' => $p->badge,
            'original_price' => $p->original_price,
            'promo_price' => $p->promo_price,
            'discount_percent' => $p->discount_percent,
            'discount' => $p->discount,
            'code' => $p->code,
            'valid_until' => $p->valid_until,
            'vehicle_compatibility' => $p->vehicle_compatibility,
            'benefits' => $p->benefits ?? [],
        ])->toArray();

        return Inertia::render('Promo/Index', [
            'promos' => $promos,
            'categories' => $categories,
        ]);
    }

    public function show(string $slug): Response
    {
        $dbPromo = Promo::where('slug', $slug)->with('product')->firstOrFail();

        $promo = [
            'id' => $dbPromo->id,
            'product_id' => $dbPromo->product_id,
            'product_slug' => $dbPromo->product?->slug,
            'product_name' => $dbPromo->product?->name,
            'slug' => $dbPromo->slug,
            'name' => $dbPromo->name,
            'category' => $dbPromo->category,
            'desc' => $dbPromo->desc,
            'img' => $dbPromo->image_url,
            'badge' => $dbPromo->badge,
            'original_price' => $dbPromo->original_price,
            'promo_price' => $dbPromo->promo_price,
            'discount_percent' => $dbPromo->discount_percent,
            'discount' => $dbPromo->discount,
            'code' => $dbPromo->code,
            'valid_until' => $dbPromo->valid_until,
            'vehicle_compatibility' => $dbPromo->vehicle_compatibility,
            'benefits' => $dbPromo->benefits ?? [],
        ];

        return Inertia::render('Promo/Show', [
            'promo' => $promo,
        ]);
    }
}
