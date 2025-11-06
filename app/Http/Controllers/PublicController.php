<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Agenda;
use App\Models\Contact;
use App\Models\User;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function index()
    {
        $recent_articles = Article::published()
            ->with('creator')
            ->latest()
            ->take(3)
            ->get();

        $upcoming_agendas = Agenda::upcoming()
            ->take(3)
            ->get();

        $guruBK = User::where('role', 'guru_bk')->get();

        return view('public.index', compact('recent_articles', 'upcoming_agendas', 'guruBK'));
    }

    public function articles()
    {
        $articles = Article::published()
            ->with('creator')
            ->latest()
            ->paginate(12);

        return view('public.articles.index', compact('articles'));
    }

    public function articleShow($slug)
    {
        $article = Article::published()
            ->with('creator')
            ->where('slug', $slug)
            ->firstOrFail();

        $related_articles = Article::published()
            ->where('id', '!=', $article->id)
            ->latest()
            ->take(3)
            ->get();

        return view('public.articles.show', compact('article', 'related_articles'));
    }

    public function agendas()
    {
        $upcoming_agendas = Agenda::upcoming()->paginate(12);
        $past_agendas = Agenda::past()->paginate(12);

        return view('public.agendas.index', compact('upcoming_agendas', 'past_agendas'));
    }

    public function contact()
    {
        $guruBK = User::where('role', 'guru_bk')->get();
        return view('public.contact', compact('guruBK'));
    }

    public function contactStore(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        Contact::create($validated);

        return redirect()->back()->with('success', 'Pesan Anda berhasil dikirim. Kami akan segera menghubungi Anda.');
    }
}