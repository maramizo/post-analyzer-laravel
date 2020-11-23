<?php

namespace App\Http\Controllers;

use App\Personality;
use App\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class IBMController extends Controller
{
    //
    public function type(Profile $profile){
        $messages = implode(" ", $profile->messages()->pluck('content')->toArray());

        $response = Http::withBasicAuth(env('IBM_USER'), env('IBM_PASS'))->withHeaders([
            'Accept' => 'application/json'
        ])->withBody($messages, 'text/plain;charset=utf-8')->post(env('IBM_URL'));

        if($response->successful()){
            /*
             *  Response format:
             * {
             *      personality: [{
             *          "trait_id": "big5_openness",
             *          "name": "openness",
             *          "percentile": xxx
             *      }, (...)]
             * }
             */
            $info = json_decode($response->body(), true);

            $data = ([
                'open' => $info['personality'][0]['percentile'],
                'con' => $info['personality'][1]['percentile'],
                'ext' => $info['personality'][2]['percentile'],
                'agr' => $info['personality'][3]['percentile'],
                'neu' => $info['personality'][4]['percentile'],
            ]);

            $profile->personalities()->create($data);
        }
    }
}
