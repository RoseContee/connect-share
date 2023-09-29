<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shortcut extends Model
{
    use HasFactory;

    protected $fillable = [
        'icon', 'title', 'link', 'active',
    ];

    public function scopeActive($query) {
        $query->where('active', true);
    }
}
