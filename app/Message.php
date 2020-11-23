<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $guarded = [];
    /**
    *
    * Assigns the message to the profile that created it.
    *
    */
    public function profile(){
        return $this->belongsTo(Profile::class);
    }
}
