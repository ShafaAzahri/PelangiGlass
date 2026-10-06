<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Faq;
use App\Models\GalleryCategory;
use App\Models\GalleryItem;
use App\Models\HeroBanner;
use App\Models\Product;
use App\Models\Service;
use App\Models\Setting;
use App\Models\Testimonial;

class HomeController extends Controller
{
    public function index()
    {
        $banners = HeroBanner::active()->get();
        $featuredServices = Service::featured()->with('category')->take(6)->get();
        $galleryCategories = GalleryCategory::orderBy('sort_order')->get();
        $galleryItems = GalleryItem::active()->with('category')->get();
        $testimonials = Testimonial::featured()->get();
        $articles = Article::published()->with('category')->take(3)->get();
        $faqs = Faq::active()->get();
        $products = Product::active()->with('category')->take(4)->get();

        $settings = Setting::all()->pluck('value', 'key');

        return view('pages.home.index', compact(
            'banners',
            'featuredServices',
            'galleryCategories',
            'galleryItems',
            'testimonials',
            'articles',
            'faqs',
            'products',
            'settings'
        ));
    }
}
