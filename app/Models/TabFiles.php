<?php

namespace App\Models;
use App\Models\Tabs;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TabFiles extends Model
{
   use HasFactory;

    protected $fillable = [
        'tab_id',
        'category',
        'title',
        'file_path',
        'sort_order',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function tab()
    {
        return $this->belongsTo(Tabs::class);
    }

    /* =========================
       SCOPES
       ========================= */

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }
}
