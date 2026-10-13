<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Faq;
use App\Models\GalleryCategory;
use App\Models\GalleryItem;
use App\Models\HeroBanner;
use App\Models\Product;
use App\Models\Service;
use App\Models\Testimonial;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    public function index(): Response
    {
        $banners = HeroBanner::active()->get();
        $featuredServices = Service::featured()->with('category')->take(6)->get();
        $galleryCategories = GalleryCategory::orderBy('sort_order')->get();
        $galleryItems = GalleryItem::active()->with('category')->get();
        $testimonials = Testimonial::featured()->get();
        $articles = Article::published()->with('category')->take(3)->get();
        $faqs = Faq::active()->get();
        $products = Product::active()->with('category')->take(4)->get();

        return Inertia::render('Home/Index', [
            'banners' => $banners,
            'featuredServices' => $featuredServices,
            'galleryCategories' => $galleryCategories,
            'galleryItems' => $galleryItems,
            'testimonials' => $testimonials,
            'articles' => $articles,
            'faqs' => $faqs,
            'products' => $products,
        ]);
    }
}
