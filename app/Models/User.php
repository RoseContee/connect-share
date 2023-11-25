<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Widgets\CorporateNews as WidgetCorporateNews;
use App\Models\Widgets\HolidayRequest as WidgetHolidayRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'google_id', 'email', 'given_name', 'family_name', 'phone', 'avatar',
        'org_title', 'org_department',
        'drive_usage', 'gmail_usage', 'photos_usage',
        'manager_id', 'show_in_org', 'is_admin',
        'domain', 'access_token', 'refresh_token',
    ];

    public function scopeDomain($query, $domain) {
        $query->where('domain', $domain);
    }

    public function scopeShowInOrg($query) {
        $query->where('show_in_org', true);
    }

    public function intranet() {
        return $this->belongsTo(Domain::class, 'domain', 'domain');
    }

    public function users() {
        return $this->hasMany(self::class, 'domain', 'domain');
    }

    public function manager() {
        return $this->belongsTo(self::class, 'manager_id', 'google_id');
    }

    public function members() {
        return $this->hasMany(self::class, 'manager_id', 'google_id');
    }

    public function links() {
        return $this->hasMany(UsefulLink::class, 'domain', 'domain');
    }

    public function documents() {
        return $this->hasMany(CompanyDocument::class, 'domain', 'domain');
    }

    /*
     * Widgets relation
     */
    public function holidayRequests() {
        return $this->hasMany(WidgetHolidayRequest::class, 'google_id', 'google_id');
    }

    public function holidayApprovals() {
        return $this->hasMany(WidgetHolidayRequest::class, 'manager_id', 'google_id');
    }

    public function corporateNews() {
        return $this->belongsTo(WidgetCorporateNews::class, 'domain', 'domain');
    }

    public function hasWidget($widget) {
        return in_array($widget, explode(',', $this['intranet']['widgets'] ?? ''));
    }
}
