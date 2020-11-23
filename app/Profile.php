<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $guarded = [];
    /**
    *
    * Assign the profile to the user that created it.
    *
    */
    public function user(){
        return $this->belongsTo(User::class);
    }

    /**
    *
    * Assign profile to its child messages.
    *
    */
    public function messages(){
        return $this->hasMany(Message::class);
    }

    /**
     *
     * Assign profile to its child personalities.
     *
     */
    public function personalities(){
        return $this->hasMany(Personality::class);
    }

    public function hasPersonality(){
        if($this->personalities()->count() > 0)
            return '1';
        return '0';
    }
}
