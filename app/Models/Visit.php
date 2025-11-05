<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    protected $fillable = [
        'client_id',
        'visited_at',
        'note',
    ];

    protected $casts = [
        'visited_at' => 'datetime'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
