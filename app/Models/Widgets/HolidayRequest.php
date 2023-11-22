<?php

namespace App\Models\Widgets;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HolidayRequest extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'widget_holiday_requests';

    protected $fillable = [
        'google_id', 'manager_id',
        'title', 'type', 'period', 'note',
        'status', 'reason',
        'parent', 'token',
    ];

    public function scopeOwner($query, $googleId) {
        $query->where('google_id', $googleId);
    }

    public function scopePending($query) {
        $query->where('status', 'pending');
    }

    public function scopeApproved($query) {
        $query->where('status', 'approved');
    }

    public function scopeRejected($query) {
        $query->where('status', 'rejected');
    }

    public function user() {
        return $this->belongsTo(User::class, 'google_id', 'google_id');
    }

    public function manager() {
        return $this->belongsTo(User::class, 'manager_id', 'google_id');
    }

    public function replies() {
        return $this->hasMany(self::class, 'parent', 'id');
    }

    public function latestReply() {
        return $this->hasOne(self::class, 'parent', 'id')->latestOfMany();
    }
}
