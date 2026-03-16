<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tabs;
use App\Models\TabTableRows;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TabTableRowsController extends Controller
{
    /**
     * List table rows for a tab
     */
    public function index(Tabs $tab)
    {
        $rows = $tab->tableRows()->orderBy('sort_order')->get();

        return view('admin.tab-table-rows.index', compact('tab', 'rows'));
    }

    /**
     * Store a new table row
     */
        public function store(Request $request, Tabs $tab)
        {
            $data = $request->validate([
                'column_name'  => 'required|string|max:255',
                'column_value' => 'nullable|string',
                'profile_text' => 'nullable|string',
                'status'       => 'required|boolean',
            ]);

            TabTableRows::create([
                'tab_id'       => $tab->id,
                'column_name'  => $data['column_name'],
                'column_value' => $data['column_value'],
                'file_path'    => $data['profile_text'], // storing text now
                'status'       => $data['status'],
                'sort_order'   => $tab->tableRows()->max('sort_order') + 1,
            ]);

            return back()->with('success', 'Table row added successfully');
        }

    /**
     * Update a table row
     */
    public function update(Request $request, TabTableRows $row)
    {
        $data = $request->validate([
            'column_name'  => 'required|string|max:255',
            'column_value' => 'nullable|string',
            'status'       => 'required|boolean',
        ]);

        $row->update($data);

        return back()->with('success', 'Table row updated successfully');
    }

    /**
     * Delete a table row
     */
    public function destroy(TabTableRows $row)
    {
        $row->delete();

        return back()->with('success', 'Table row deleted successfully');
    }
}
