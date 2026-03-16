<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TabTableRows extends Model
{
    use HasFactory;

    protected $table = 'tab_table_rows';

    protected $fillable = [
        'tab_id',
        'row_group',
        'column_name',
        'file_path',
        'column_value',
        'sort_order',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function tab()
    {
        return $this->belongsTo(Tabs::class, 'tab_id', 'id');
    }
    public function scopeActive($query)
{
    return $query->where('status', true);
}

}
