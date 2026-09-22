<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\Setting;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        $categories = ServiceCategory::where('is_active', true)->orderBy('sort_order')->get();

        $query = Service::active()->with('category');

        if ($request->filled('kategori')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->kategori);
            });
        }

        $services = $query->paginate(12)->withQueryString();
        $settings = Setting::all()->pluck('value', 'key');

        return view('pages.servis', compact('services', 'categories', 'settings'));
    }

    public function show(string $slug)
    {
        $service = Service::active()->where('slug', $slug)->with('category')->firstOrFail();
        $otherServices = Service::active()
            ->where('id', '!=', $service->id)
            ->with('category')
            ->take(3)
            ->get();

        $settings = Setting::all()->pluck('value', 'key');

        return view('pages.servis_detail', compact('service', 'otherServices', 'settings'));
    }
}
