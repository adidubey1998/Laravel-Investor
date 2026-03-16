<?php

namespace App\Models;
use App\Models\TabFiles;
use App\Models\TabTableRows;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tabs extends Model
{
    use HasFactory;

    protected $fillable = [
        'parent_id',
        'name',
        'slug',
        'page_type',
        'has_hierarchy',
        'page_heading',
        'page_description',
        'meta_title',
        'meta_description',
        'sort_order',
        'status',
    ];

    protected $casts = [
        'has_hierarchy' => 'boolean',
        'status'        => 'boolean',
    ];

    /* =========================
       HIERARCHY RELATIONSHIPS
       ========================= */

    // Parent tab
    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    // Immediate children (ACTIVE ONLY)
 public function children()
{
    return $this->hasMany(self::class, 'parent_id')
        ->where('status', 1)
        ->orderBy('sort_order', 'asc');
}

public function childrenRecursive()
{
    return $this->children()
        ->with([
            'childrenRecursive' => function ($query) {
                $query->where('status', 1)
                      ->orderBy('sort_order', 'asc');
            }
        ])
        ->orderBy('sort_order', 'asc');
}

    // Recursive parent chain (for breadcrumbs / root)
    public function parentRecursive()
    {
        return $this->parent()->with('parentRecursive');
    }

    /* =========================
       FILE RELATIONSHIP
       ========================= */

public function files()
{
    return $this->hasMany(TabFiles::class, 'tab_id')
        ->where('status', 1)
        ->orderBy('sort_order', 'asc');
}

public function tableRows()
{
    return $this->hasMany(TabTableRows::class, 'tab_id')
        ->where('status', 1)
        ->orderBy('sort_order', 'asc');
}

    /* =========================
       SCOPES (CLEAN QUERIES)
       ========================= */

    // Only active tabs
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    // Top-level tabs only
    public function scopeRoot($query)
    {
        return $query->whereNull('parent_id');
    }
public function hasContent()
{
    // Description
    if (!empty($this->page_description)) {
        return true;
    }

    // Files
    if ($this->files()->where('status', 1)->exists()) {
        return true;
    }

    // Tables
    if ($this->tableRows()->where('status', 1)->exists()) {
        return true;
    }

    // Children recursive
    foreach ($this->childrenRecursive as $child) {
        if ($child->hasContent()) {
            return true;
        }
    }

    return false;
}

public function isLeafEmpty()
{
    return
        $this->childrenRecursive->count() === 0 &&
        empty($this->page_description) &&
        !$this->files()->active()->exists() &&
        !$this->tableRows()->active()->exists();
}
public function isLeaf()
{
    return $this->childrenRecursive->count() === 0;
}
public function firstChildWithContent()
{
    foreach ($this->childrenRecursive as $child) {

        if ($child->hasContent()) {
            return $child;
        }

        // Recursive fallback
        $nested = $child->firstChildWithContent();
        if ($nested) {
            return $nested;
        }
    }

    return null;
}


}
