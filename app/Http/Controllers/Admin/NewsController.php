<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::orderBy('sort_order', 'asc')->get();
        return view('admin.news.index', compact('news'));
    }

    public function create()
    {
        return view('admin.news.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'file'  => 'nullable|mimes:pdf|max:10240',
            'status'=> 'required|boolean',
            'publish_date' => 'nullable|date'
        ]);

        $path = null;

        if ($request->hasFile('file')) {
            $file = $request->file('file');

            $path = $file->storeAs(
                'news',
                time().'_'.$file->getClientOriginalName(),
                'public'
            );
        }

        News::create([
            'title'        => $data['title'],
            'slug'         => Str::slug($data['title']),
            'file_path'    => $path,
            'publish_date' => $data['publish_date'],
            'status'       => $data['status'],
            'sort_order'   => (News::max('sort_order') ?? 0) + 1
        ]);

        return redirect()->route('admin.news.index')
            ->with('success', 'News added successfully');
    }

    public function destroy(News $news)
    {
        if ($news->file_path && file_exists(storage_path('app/public/'.$news->file_path))) {
            unlink(storage_path('app/public/'.$news->file_path));
        }

        $news->delete();

        return back()->with('success', 'News deleted successfully');
    }
}
