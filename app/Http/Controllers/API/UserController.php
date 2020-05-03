<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Requests\StoreUser;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use App\Http\Resources\User as UserResource;

use JWTAuth;

class UserController extends Controller 
{
    public function register(StoreUser $request){
        
        \Log::info('Req=API\UserController@register Called');
      
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);
        
        if(!$token = auth()->attempt($request->only(['email', 'password']))){
            return abort(401);
        }

        return (new UserResource($request->user()))->additional([
            'meta' => [
                'token' => $token

            ]
        ]);
       
    }


    public function login(LoginRequest $request){
        
        \Log::info('Req=API\UserController@login Called');

        if(!$token = Auth()->attempt($request->only(['email', 'password']))){
            return response()->json([
                'errors' => [
                    'email' => 'Sorry, we can\'t find you on details'
                ]
                ], 422);
        }

        return (new UserResource($request->user()))->additional([
            'meta' => [
                'token' => $token
            ]
        ]);
    }

    public function user(Request $request){

        \Log::info('Req=API\UserController@user Called');

        try {

                if (! $user = JWTAuth::parseToken()->authenticate()) {
                        return response()->json(['user_not_found'], 404);
                }

            } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

                    return response()->json(['token_expired'], $e->getStatusCode());

            } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

                    return response()->json(['token_invalid'], $e->getStatusCode());

            } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

                    return response()->json(['token_absent'], $e->getStatusCode());

            }

        return response()->json(compact('user'));
    }

    public function logout(){

        auth()->logout();
    }



   

}

