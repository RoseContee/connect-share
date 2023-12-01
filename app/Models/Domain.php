<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Domain extends Model
{
    use HasFactory;

    protected $fillable = [
        'domain', 'installed', 'home_banner_title', 'home_banner_image',
        'hide_profile_banner', 'profile_banner_image', 'widgets',
        'token', 'requested_email', 'notify_to', 'status', 'reason',
    ];

    public function scopeDomain($query, $domain) {
        $query->where('domain', $domain);
    }

    public function scopeInstalled($query) {
        $query->where('installed', 2);
    }

    public function scopePending($query) {
        $query->where('status', 'pending');
    }

    public function scopeActive($query) {
        $query->where('status', 'active');
    }

    public function scopeBlocked($query) {
        $query->where('status', 'blocked');
    }

    public function users() {
        return $this->hasMany(User::class, 'domain', 'domain');
    }

    /*
     * Functions
     */
    public function unlinkHomeBanner() {
        if (getPath($this->attributes['home_banner_image'] ?? null)) {
            unlink(public_path($this->attributes['home_banner_image']));
        }
    }

    public function unlinkProfileBanner() {
        if (getPath($this->attributes['profile_banner_image'] ?? null)) {
            unlink(public_path($this->attributes['profile_banner_image']));
        }
    }

    /*
     * Widget related
     */
    public function hasWidget($widget) {
        return in_array($widget, explode(',', $this['widgets']));
    }
}
