<?php

namespace App\Models\Widgets;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CorporateNews extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'widget_corporate_news';

    protected $fillable = [
        'domain', 'email', 'access_token', 'refresh_token',
    ];
}
