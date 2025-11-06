<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminArticleController extends Controller
{
    public function index()
    {
        $articles = Article::with('creator')->latest()->paginate(15);
        return view('admin.articles.index', compact('articles'));
    }

    public function create()
    {
        return view('admin.articles.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|max:2048',
            'is_published' => 'boolean',
        ]);

        $validated['created_by'] = auth()->id();

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('articles', 'public');
        }

        Article::create($validated);

        return redirect()->route('admin.articles.index')->with('success', 'Artikel berhasil dibuat');
    }

    public function show(Article $article)
    {
        return view('admin.articles.show', compact('article'));
    }

    public function edit(Article $article)
    {
        return view('admin.articles.edit', compact('article'));
    }

    public function update(Request $request, Article $article)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|max:2048',
            'is_published' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            if ($article->image) {
                Storage::disk('public')->delete($article->image);
            }
            $validated['image'] = $request->file('image')->store('articles', 'public');
        }

        $article->update($validated);

        return redirect()->route('admin.articles.index')->with('success', 'Artikel berhasil diperbarui');
    }

    public function destroy(Article $article)
    {
        if ($article->image) {
            Storage::disk('public')->delete($article->image);
        }

        $article->delete();

        return redirect()->route('admin.articles.index')->with('success', 'Artikel berhasil dihapus');
    }
}