<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrackingPoint extends Model
{
    protected $table = 'tracking_points';

    protected $fillable = [
        'tracking_session_id',
        'latitude',
        'longitude',
        'recorded_at',
    ];

    public $timestamps = true;

    public function session()
    {
        return $this->belongsTo(TrackingSession::class, 'tracking_session_id');
    }
}
