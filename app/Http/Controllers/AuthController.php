<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
       $credentials = $request->validate([
           'email'      => ['required', 'email'],
           'password'   => 'required',
           'remember'   => 'boolean',
       ]);

       $remember = $credentials['remember'] ?? false;
       unset($credentials['remember']);

       if (!Auth::attempt($credentials, $remember)){
           return response([
               'message' => 'Email or Password is incorrect'
           ],422);
       }

       /** @var User $user*/
       $user = Auth::user();
       if (!$user->is_admin){
           Auth::logout();

           return response([
               'message' => 'You don\'t have permission to authenticated as asmin'
           ], 403);
       }
       /**Create a token*/
       $token = $user->createToken('main')->plainTextToken;

       return response([
           'user' => $user,
           'token' => $token
       ]);

    }


    public  function  logout()
    {
        /** @var User $user*/
        $user = Auth::user();
        $user->currentAccessToken()->delete();

        return response('', 204);
    }
}
