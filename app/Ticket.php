<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $guarded = [];

    protected $with = ['user'];

    /**
     * relationships
     */
    public function user() {
        return $this->belongsTo(User::class);
    }




}
