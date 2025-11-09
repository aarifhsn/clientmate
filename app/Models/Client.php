<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Category;
use App\Models\Visit;

class Client extends Model
{
    use HasFactory;
    protected $fillable = [

        'name',
        'user_id',
        'linkedin_url',
        'category_id',
        'priority',
        'activity',
        'connected',
        'is_favorite',
        'last_visited_at',
        'next_follow_up',
        'notes',
    ];

    protected $casts = [
        'connected' => 'boolean',
        'is_favorite' => 'boolean',
        'last_visited_at' => 'datetime',
        'next_follow_up' => 'date'
    ];

    protected $appends = ['engagement_status', 'days_since_visit', 'is_overdue'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function visits()
    {
        return $this->hasMany(Visit::class);
    }

    // Engagement status: active, warm, cold
    public function getEngagementStatusAttribute()
    {
        if (!$this->last_visited_at) {
            return 'cold';
        }

        $days = Carbon::now()->diffInDays($this->last_visited_at);

        if ($days <= 3)
            return 'active';
        if ($days <= 7)
            return 'warm';
        return 'cold';
    }

    public function getDaysSinceVisitAttribute()
    {
        return $this->last_visited_at
            ? Carbon::now()->diffInDays($this->last_visited_at)
            : null;
    }

    public function getIsOverdueAttribute()
    {
        return $this->next_follow_up
            ? Carbon::now()->isAfter($this->next_follow_up)
            : false;
    }

    public function recordVisit($note = null)
    {
        $this->update(['last_visited_at' => now()]);

        $this->visits()->create([
            'visited_at' => now(),
            'note' => $note
        ]);
    }
}
