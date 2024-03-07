<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Http\Resources\LoginResource;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class AuthController extends AppBaseController
{



    public function __construct()
    {
        $this->middleware(['auth:api'],['except'=>['Login','Register','auth','refresh']]);

    }

     private function auth($user)
    {
        $token = auth()->login($user);
        $message ='User login successfully';
        $expires_in = auth()->factory()->getTTL() * 6000;

        return $this->sendResponse([
            "user" => new UserResource($user),
            "access_token"=>$token,
            'expires_in' => $expires_in,
            ],$message);
    }


    public function refresh(){
        $current_token  = JWTAuth::getToken();
        $token          = JWTAuth::refresh($current_token);
        $message ='token refresh successfully';
        return $this->sendResponse(["token" => $token],$message);
    }




    public function Register(RegisterRequest $request)
    {
        $input = $request->all();
        $user = User::create($input);

        return $this->auth($user);
    }

    public function Login(LoginRequest $request){


        $email = $request->email;
        $password = $request->password;

        if(!auth()->attempt($request->all())){

            $errors = 'Email Or Password Incorect';
            return $this->sendError($errors);
        }
            $user=User::where('email',$email)->first();
            return $this->auth($user);

    }


    public function logout(Request $request)
    {

        $user = Auth::user();

        if ($user) {
            $user->tokens->each(function ($token, $key) {
                $token->delete();
            });

            return response()->json(['message' => 'Successfully logged out']);
        }

        return response()->json(['error' => 'Unauthorized'], 401);

    }


}
