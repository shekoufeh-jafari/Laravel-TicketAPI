<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginUserRequest;
use App\Models\User;
use App\Permissions\V1\Abilities;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


use function Pest\Laravel\delete;

class AuthController extends Controller
{
    use ApiResponse;

    /**
     * Login
     * 
     * Authenticated the user and returns the user's API token
     * 
     * @unauthenticated
     * @group Authentication
     * @response 200 response{
     *  "data": {
        "token": "{YOUR_AUTH_KEY}"
    },
    "message": "Authenticated",
    "status": 200
    }
     * 
     */


    public function login(LoginUserRequest $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return $this->error('Invalid credentials', 401);
        }

        $user = User::firstWhere('email', $request->email);


        // logger(Abilities::getAbilities($user));


        return $this->ok(
            'Authenticated',
            [
                'token' => $user->createToken(
                    'API token for ' . $user->email,
                    Abilities::getAbilities($user),
                    now()->addMonth()
                )->plainTextToken
            ]
        );
    }


    /**
     * Logout
     * 
     * Signs out the user and destroy's the API token.
     * 
     * @group Authentication
     * @response 200 response{}
     * 
     * 
     */
    public function logout(Request $request)
    {
        // $request->user()->tokens()->delete();
        // $request->user()->tokens()->where('id', $tokenId)->delete();
        $request->user()->currentAccessToken()->delete();

        return $this->ok('');
    }
}
