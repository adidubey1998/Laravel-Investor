<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tabs;   // ✅ FIXED
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TabsController extends Controller
{
    public function index()
    {
        $tabs = Tabs::whereNull('parent_id')
            ->with('childrenRecursive')
            ->orderBy('sort_order')
            ->get();

        return view('admin.tabs.index', compact('tabs'));
    }

    public function create()
    {
        $parentTabs = Tabs::orderBy('name')->get();

        return view('admin.tabs.create', compact('parentTabs'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:tabs,id',
            'page_type' => 'required|in:same_page,new_page',
            'slug' => 'nullable|required_if:page_type,new_page|unique:tabs,slug',
            'has_hierarchy' => 'required|boolean',
            'page_heading' => 'nullable|string|max:255',
            'page_description' => 'nullable|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'status' => 'required|boolean',
        ]);

        if ($data['page_type'] === 'new_page' && empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        if ($data['page_type'] === 'same_page') {
            $data['slug'] = null;
        }

        $data['sort_order'] =
            Tabs::where('parent_id', $data['parent_id'])->max('sort_order') + 1;

        Tabs::create($data);

        return redirect()
            ->route('admin.tabs.index')
            ->with('success', 'Tab created successfully');
    }

    public function edit(Tabs $tab)
    {
        $parentTabs = Tabs::where('id', '!=', $tab->id)->orderBy('name')->get();

        return view('admin.tabs.edit', compact('tab', 'parentTabs'));
    }

    public function update(Request $request, Tabs $tab)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:tabs,id|not_in:' . $tab->id,
            'page_type' => 'required|in:same_page,new_page',
            'slug' => 'nullable|required_if:page_type,new_page|unique:tabs,slug,' . $tab->id,
            'has_hierarchy' => 'required|boolean',
            'page_heading' => 'nullable|string|max:255',
            'page_description' => 'nullable|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'status' => 'required|boolean',
        ]);

        if ($data['page_type'] === 'same_page') {
            $data['slug'] = null;
        }

        $tab->update($data);

        return redirect()
            ->route('admin.tabs.index')
            ->with('success', 'Tab updated successfully');
    }

    public function destroy(Tabs $tab)
    {
        $tab->delete();

        return redirect()
            ->route('admin.tabs.index')
            ->with('success', 'Tab deleted successfully');
    }

    public function sort(Request $request)
    {
        foreach ($request->order as $index => $id) {
            Tabs::where('id', $id)->update(['sort_order' => $index]);
        }

        return response()->json(['success' => true]);
    }
}
