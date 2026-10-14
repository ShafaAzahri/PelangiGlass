<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ArticleCategory;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ArticleController extends Controller
{
    public function index(Request $request): Response
    {
        $categories = ArticleCategory::orderBy('sort_order')->get();

        $query = Article::published()->with(['category', 'author']);

        if ($request->filled('kategori')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->kategori);
            });
        }

        if ($request->filled('q')) {
            $search = str_replace(['\\', '%', '_'], ['\\\\', '\\%', '\\_'], trim($request->q));
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('excerpt', 'like', "%{$search}%");
            });
        }

        $articles = $query->paginate(9)->withQueryString();

        return Inertia::render('Artikel/Index', [
            'articles' => $articles,
            'categories' => $categories,
            'filters' => [
                'kategori' => $request->kategori,
                'q' => $request->q,
            ],
        ]);
    }

    public function show(string $slug): Response
    {
        $article = Article::published()->where('slug', $slug)->with(['category', 'author'])->firstOrFail();
        $relatedArticles = Article::published()
            ->where('id', '!=', $article->id)
            ->where('category_id', $article->category_id)
            ->take(3)
            ->get();

        return Inertia::render('Artikel/Show', [
            'article' => $article,
            'relatedArticles' => $relatedArticles,
        ]);
    }
}
