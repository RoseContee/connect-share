<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Domain extends Model
{
    use HasFactory;

    protected $fillable = [
        'domain', 'installed',
    ];

    public function scopeDomain($query, $domain) {
        $query->where('domain', $domain);
    }

    public function scopeInstalled($query) {
        $query->where('installed', 2);
    }

    public function users() {
        return $this->hasMany(User::class, 'domain', 'domain');
    }
}
