<?php

namespace App\Http\Controllers;

use App\Profile;
use Illuminate\Http\Request;

class PersonalitiesController extends Controller
{
    public function show(Profile $profile){
        if($profile->hasPersonality() == false)
            return 404;
        return $profile->personalities();
    }
}
