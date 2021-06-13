<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;
use App\Events\ParkUserAttached;

class ParkUser extends Pivot
{
    protected $dispatchesEvents = [
        'created'=> ParkUserAttached::class,
        'deleted'=> ParkUserAttached::class,
    ];

    public function park() {
        return $this->belongsTo(Park::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
