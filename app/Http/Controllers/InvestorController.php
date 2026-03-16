<?php

namespace App\Http\Controllers;

use App\Models\Tabs;
use App\Models\TabFiles;
use App\Models\TabTableRows;
use Illuminate\Http\Request;
use App\Models\News;

class InvestorController extends Controller
{
    public function index()
    {
        $tabs = Tabs::with([
            'children' => function ($q) {
                $q->where('status', 1)->orderBy('sort_order');
            },
            'files' => fn ($q) => $q->where('status', 1)->orderBy('sort_order'),
            'tableRows' => fn ($q) => $q->where('status', 1)->orderBy('sort_order'),
        ])
        ->whereNull('parent_id')
        ->where('status', 1)
        ->orderBy('sort_order')
        ->get();
        $latestNews = News::where('status', 1)
        ->orderBy('created_at', 'desc')
        ->get();

                return view('welcome', [
            'tabs' => $tabs,
            'latestNews' => $latestNews,
            'context' => 'welcome',
            'activeTabId' => null
            ]);
    }
    
     public function show(string $slug)
{
    $tab = Tabs::where('slug', $slug)
        ->where('status', 1)
        ->with([
            'childrenRecursive.files' => fn ($q) => $q->active(),
            'childrenRecursive.tableRows' => fn ($q) => $q->active(),
            'files' => fn ($q) => $q->active(),
            'tableRows' => fn ($q) => $q->active(),
            'parentRecursive',
            'childrenRecursive'
        ])
        ->firstOrFail();

    /*
    |--------------------------------------------------------------------------
    | 🔥 Find FIRST tab that actually has content or files
    |--------------------------------------------------------------------------
    */

    $activeTab = $tab;

    // If current tab has no content → go deeper
    if (!$activeTab->hasContent()) {

        $activeTab = $activeTab->firstChildWithContent();
    }

    if (!$activeTab) {
        abort(404); // no content anywhere
    }

    $activeTabId = $activeTab->id;

    /*
    |--------------------------------------------------------------------------
    | Root Sidebar
    |--------------------------------------------------------------------------
    */

    $rootTab = $tab;
    while ($rootTab->parent) {
        $rootTab = $rootTab->parent;
    }

    $rootIndex = Tabs::whereNull('parent_id')
        ->active()
        ->orderBy('sort_order')
        ->pluck('id')
        ->search($rootTab->id);

    return view('welcome-diff', [
        'tab' => $activeTab,      // 👈 IMPORTANT
        'rootTab' => $rootTab,
        'rootIndex' => $rootIndex + 1,
        'activeTabId' => $activeTabId,
        'context' => 'slug'
    ]);
}





}