<?php

namespace App\Http\Controllers;

use App\Models\HelpArticle;
use Illuminate\Http\Request;

class HelpCenterController extends Controller
{
    public function index()
    {
        $featured = HelpArticle::published()->featured()->orderBy('order')->take(6)->get();
        $categories = HelpArticle::published()
            ->selectRaw('category, COUNT(*) as count')
            ->groupBy('category')
            ->get();
        
        return view('support.help-center', compact('featured', 'categories'));
    }

    public function category($category)
    {
        $articles = HelpArticle::published()
            ->where('category', $category)
            ->orderBy('order')
            ->orderBy('created_at')
            ->get();
            
        return view('support.help-category', compact('articles', 'category'));
    }

    public function show($slug)
    {
        $article = HelpArticle::published()->where('slug', $slug)->firstOrFail();
        $article->incrementViews();
        
        $related = HelpArticle::published()
            ->where('category', $article->category)
            ->where('id', '!=', $article->id)
            ->take(3)
            ->get();
            
        return view('support.help-article', compact('article', 'related'));
    }

    public function search(Request $request)
    {
        $query = $request->get('q');
        $articles = HelpArticle::published()
            ->where(function($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                  ->orWhere('content', 'like', "%{$query}%");
            })
            ->orderBy('views', 'desc')
            ->get();
            
        return view('support.help-search', compact('articles', 'query'));
    }
}