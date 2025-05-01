<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrackingSession extends Model
{
    protected $table = 'tracking_sessions';

    protected $fillable = [
        'user_id',
        'manufacturer',
        'modelName',
        'osVersion',
        'platformApiLevel',
        'started_at',
        'ended_at',
    ];

    public $timestamps = true;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function trackingPoints()
    {
        return $this->hasMany(TrackingPoint::class);
    }
}
