<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'refresh']]);
    }

    public function login(Request $request)
    {
        try {
            $credentials = $request->only(['email', 'password']);

            if (!$token = auth('api')->attempt($credentials)) {
                return response()->json([
                    'error' => 'Unauthorized'
                ], Response::HTTP_UNAUTHORIZED);
            }
            // Lấy người dùng sau khi xác thực
            $user = auth('api')->user();

            // Kiem tratra
            if ($user->id == 4 || $user->id == 5) {

                return response()->json([
                    'message' => 'Welcome, Admin!',
                    'is_admin' => true,
                    'token' => $token,
                    'user' => $user
                ], Response::HTTP_OK);
            }

            $data = [
                'sub' => auth('api')->user()->id,
                'random' => rand() . time(),
                'exp' => time() + config('jwt.refresh_ttl'),
            ];

            $refreshToken = $this->createRefreshToken();

            return $this->respondWithToken($token, $refreshToken);
        } catch (\Throwable $th) {
            Log::error(__CLASS__ . '@' . __FUNCTION__, [$th->getTraceAsString()]);

            return response()->json([
                'message' => 'errors'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    public function profile()
    {
        try {
            return response()->json(auth('api')->user());
        } catch (JWTException $exception) {
            Log::error(__CLASS__ . '@' . __FUNCTION__, [$exception->getTraceAsString()]);

            return response()->json([
                'message' => 'Errors'
            ], Response::HTTP_UNAUTHORIZED);
        }
    }
    public function logout()
    {
        try {
            auth('api')->logout();

            return response()->json([
                'message' => "Logout Success"
            ]);
        } catch (\Throwable $th) {
            Log::error(__CLASS__ . '@' . __FUNCTION__, [$th->getTraceAsString()]);

            return response()->json([
                'message' => 'errors'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function refresh()
    {
        try {
            $refreshToken = request()->refresh_token;

            $decoded = JWTAuth::getJWTProvider()->decode($refreshToken);
            $user = User::findOrFail($decoded['sub']);

            if (!$user) {
                return response()->json([
                    'errors' => "User not found"
                ], 404);
            }

            $token = auth('api')->login($user);

            $refreshToken = $this->createRefreshToken();

            return $this->respondWithToken($token, $refreshToken);

        } catch (JWTException $exception) {
            Log::error(__CLASS__ . '@' . __FUNCTION__, [$exception->getTraceAsString()]);

            return response()->json([
                'message' => 'errors'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    private function respondWithToken($token, $refreshToken)
    {
        return response()->json([
            'access_token' => $token,
            'refresh_token' => $refreshToken,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }
    private function createRefreshToken()
    {
        $data = [
            'sub' => auth('api')->user()->id,
            'random' => rand() . time(),
            'exp' => time() + config('jwt.refresh_ttl'),
        ];

        $refreshToken = JWTAuth::getJWTProvider()->encode($data);

        return $refreshToken;
    }

}
