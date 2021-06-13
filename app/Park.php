<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Carbon\CarbonInterval;

class Park extends Model
{
    protected $guarded = [];


    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['in_queue','wait_time'];


    /**
     * relationships
     */
    public function users() {
        return $this->belongsToMany(User::class)->using(ParkUser::class)->withTimestamps();
    }

    /**
     * attributes
     */
    public function getIntermissionAttribute($data) {
        if($data > 0) {
            return CarbonInterval::seconds($data)->cascade()->forHumans();
        }

        return '-';
    }

    public function getInQueueAttribute() {       
        return $this->users()->count();
    }

    public function getWaitTimeAttribute() {
        $perBatch = $this->in_queue / $this->max_capacity;
        $ewt = $perBatch * $this->start_to_end;

        return CarbonInterval::seconds($ewt)->cascade()->forHumans();
    }
}
