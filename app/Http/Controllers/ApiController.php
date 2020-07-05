<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Http\Resources\UserResource;

class ApiController extends Controller
{
    //
    public function login(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if (!empty($user)) {
            if (!Hash::check($request->password, $user->password)) {
                return response()->json(['success' => false, 'message' => 'Login Fail, pls check password']);
            }
            return new UserResource($user);
        } else {
            return json_encode(['error' => 'Login Fail, pls check  email']);
        }
    }
    public function register(Request $request)
    {
        $user = new User;
        $user->email = $request->email;
        $user->name = $request->name;
        $user->password = Hash::make($request->password);
        $user->save();
        return new UserResource($user);
    }
}
