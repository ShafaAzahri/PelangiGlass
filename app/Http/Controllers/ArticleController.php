<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ArticleCategory;
use App\Models\Setting;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $categories = ArticleCategory::orderBy('sort_order')->get();

        $query = Article::published()->with(['category', 'author']);

        if ($request->filled('kategori')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->kategori);
            });
        }

        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'ilike', "%{$search}%")
                    ->orWhere('excerpt', 'ilike', "%{$search}%");
            });
        }

        $articles = $query->paginate(9)->withQueryString();
        $settings = Setting::all()->pluck('value', 'key');

        return view('pages.artikel.index', compact('articles', 'categories', 'settings'));
    }

    public function show(string $slug)
    {
        $article = Article::published()->where('slug', $slug)->with(['category', 'author'])->firstOrFail();
        $relatedArticles = Article::published()
            ->where('id', '!=', $article->id)
            ->where('category_id', $article->category_id)
            ->take(3)
            ->get();

        $settings = Setting::all()->pluck('value', 'key');

        return view('pages.artikel.show', compact('article', 'relatedArticles', 'settings'));
    }
}
