<?php

namespace App\Http\Controllers;

use App\Message;
use App\Profile;
use Illuminate\Http\Request;

class MessagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Profile $profile
     * @param int $type
     * @return \Illuminate\Http\Response
     */
    public function show(Profile $profile, int $type)
    {
        if($type == 0){
            $data = Message::where(['profile_id' => $profile->id, 'quote' => 0])->latest()->paginate(10);
        }else{
            $data = Message::where(['profile_id' => $profile->id, 'quote' => 1])->latest()->paginate(10);
        }
        return response()->json($data);

    }
}
