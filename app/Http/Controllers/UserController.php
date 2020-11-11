<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\Users as UsersResourse;
use App\Http\Resources\UserShow as UserShowResource;
use App\User;

class UserController extends Controller
{
    //
    public function index()
    {
        $users = User::paginate(5);
        return UsersResourse::collection($users);
    }
    public function show(Request $request)
    {
        //limit 5 created=at,fee
        // User::find($request->id)->post()->
        return new UserShowResource(User::find($request->id));
    }
}
