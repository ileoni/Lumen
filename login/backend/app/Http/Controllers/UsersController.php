<?php

namespace App\Http\Controllers;

use App\Models\User as Eloquent;

class UsersController extends Controller
{
    private $user;
    public function __construct(Eloquent $user)
    {
        $this->user = $user;
    }

    public function register()
    {
        $user = $this->user;
        $hasher = app()->make('hash');

        $user->name = request('name');
        $user->email = request('email');
        $user->password = $hasher->make(request('password'));

        $user->save();

        return response()->json([
            'success' => true,
            'data' => $this->user->id
        ], 200);
    }
}