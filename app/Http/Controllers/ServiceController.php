<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\ServiceCategory;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ServiceController extends Controller
{
    public function index(Request $request): Response
    {
        $categories = ServiceCategory::where('is_active', true)->orderBy('sort_order')->get();

        $query = Service::active()->with('category');

        if ($request->filled('kategori')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->kategori);
            });
        }

        $services = $query->paginate(12)->withQueryString();

        return Inertia::render('Servis/Index', [
            'services' => $services,
            'categories' => $categories,
            'filters' => [
                'kategori' => $request->kategori,
            ],
        ]);
    }

    public function show(string $slug): Response
    {
        $service = Service::active()->where('slug', $slug)->with('category')->firstOrFail();
        $otherServices = Service::active()
            ->where('id', '!=', $service->id)
            ->with('category')
            ->take(3)
            ->get();

        return Inertia::render('Servis/Show', [
            'service' => $service,
            'otherServices' => $otherServices,
        ]);
    }
}
