<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash; // Thêm vào để sử dụng Hash facade
use Illuminate\Support\Facades\Auth; // Để sử dụng Auth facade nếu cần

class AuthController extends Controller
{
   public function __construct(){
      $this->middleware('auth:api',['except' => ['login']]);
   }

   public function login(Request $request)
   {
       $credentials = $request->only(['email', 'password']);
   
       // Sử dụng 'auth:api' để gọi API guard
       if (!$token = auth('api')->attempt($credentials)) {
           return response()->json([
               'error' => 'Unauthorized'
           ], Response::HTTP_UNAUTHORIZED);
       }
   
       return $this->respondWithToken($token);
   }
   

   public function respondWithToken($token)
   {
       return response()->json([
           'access_token' => $token,
           'token_type' => 'bearer',
           'expires_in' => auth('api')->factory()->getTTL() * 60 // Lấy TTL của token trong giây
       ]);
   }
   
}
