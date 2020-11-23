<?php

namespace App\Http\Controllers;

use App\Message;
use App\Profile;
use Illuminate\Http\Request;

class ProfilesController extends Controller
{

    /**
     * Show the requested profile based on ID.
     *
     * @param Profile $profile (Profile data, loaded automatically).
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Profile $profile)
    {
        $quotes = Message::where(['profile_id' => $profile->id, 'quote' => 0])->latest()->paginate(10);
        $posts = Message::where(['profile_id' => $profile->id, 'quote' => 1])->latest()->paginate(10);
        return view('profiles/index', [
            'profile' => $profile,
            'quotes' => $quotes,
            'posts' => $posts,
        ]);
    }

    public function create(){
        return view('profiles/create');
    }

    public function store(){
        $this->middleware('auth');

        //Ensure page ID is not already attached to a different profile.
        if($this->exists(request()->id) == false){
            $WC = new WikiController();
            $quotes = $WC->getQuotes(request()->id);
            $newProfile = $this->newProfile(request()->all());
            foreach($quotes as $quote){
                $newMessage = $newProfile->messages()->create([
                    'content' => $quote,
                    'quote' => 1,
                ]);
            }

            $pIBM = new IBMController();
            $pIBM->type($newProfile);

            return redirect('profile/' . $newProfile->id)->with([
                'profile' => $newProfile,
                'quotes' => null,
                'posts' => null,
            ]);
        }
    }

    protected function newProfile(array $data){
        return Profile::create([
            'name' => $data['name'],
            'description' => $data['description'],
            'wiki' => 'https://en.wikiquote.org/wiki/?curid=' . $data['id'],
            'page_id' => $data['id'],
            'picture' => $data['thumbnail'],
            'user_id' => Auth()->user()->id,
        ]);
    }

    public function exists($page_id){
        $profile = Profile::where('page_id', $page_id)->first();
        if($profile)
            return true;
        return false;
    }
}
