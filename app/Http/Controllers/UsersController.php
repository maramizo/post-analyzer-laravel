<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{

    /**
     * User index page controller.
     *
     * @param User $user : user object loaded through Laravel.
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(User $user){
        return view('user/index', compact('user'));
    }
}
