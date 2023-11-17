<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response as HttpResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\QueryException;
use Auth;

class AuthController extends Controller
{
    public function signUp(Request $request)
    {
        try {
            $this->validate($request, [
                'name' => 'required|min:3|max:50',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:6|max:50',
                'confirm_password' => 'required|same:password'
            ]);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            $response = [
                'status' => HttpResponse::HTTP_CREATED,
                'message' => 'User berhasil dibuat',
                'data' => [
                    'user' => $user,
                ],
            ];

            return response()->json($response, HttpResponse::HTTP_CREATED);

        } catch (\Illuminate\Validation\ValidationException $e) {
            $response = [
                'status' => HttpResponse::HTTP_BAD_REQUEST,
                'message' => $e->errors(),
            ];
            return response()->json($response, HttpResponse::HTTP_BAD_REQUEST);

        } catch (\Illuminate\Database\QueryException $e) {
            $response = [
                'status' => HttpResponse::HTTP_BAD_REQUEST,
                'message' => $e->errors(),
            ];
            return response()->json($response, HttpResponse::HTTP_BAD_REQUEST);

        } catch (\Throwable $th) {
            $response = [
                'status' => HttpResponse::HTTP_INTERNAL_SERVER_ERROR,
                'message' => 'Internal Server Error',
            ];
            return response()->json($response, HttpResponse::HTTP_INTERNAL_SERVER_ERROR);

        } catch (\Throwable $th) {
            $response = [
                'status' => HttpResponse::HTTP_INTERNAL_SERVER_ERROR,
                'message' => 'Internal Server Error',
            ];
        }

    }

    public function signIn(Request $request)
    {
        try {
            $this->validate($request, [
                'email' => 'required|email',
                'password' => 'required|min:6|max:50',
            ]);

            $user = User::where('email', $request->email)->first();

            if($user) {
                if(Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                    $user = Auth::user();
                    $token = $user->createToken('auth_token')->plainTextToken;

                    $response = [
                        'status' => HttpResponse::HTTP_OK,
                        'message' => 'User berhasil login',
                        'data' => [
                            'user' => $user,
                            'token' => $token,
                        ],
                    ];

                    return response()->json($response, HttpResponse::HTTP_OK);
                } else {
                    $response = [
                        'status' => HttpResponse::HTTP_UNAUTHORIZED,
                        'message' => 'Email atau password salah',
                    ];
                    return response()->json($response, HttpResponse::HTTP_UNAUTHORIZED);
                }
            } else {
                $response = [
                    'status' => HttpResponse::HTTP_UNAUTHORIZED,
                    'message' => 'Email tidak terdaftar',
                ];
                return response()->json($response, HttpResponse::HTTP_UNAUTHORIZED);
            }

        } catch (\Illuminate\Validation\ValidationException $e) {
            $response = [
                'status' => HttpResponse::HTTP_BAD_REQUEST,
                'message' => $e->errors(),
            ];
            return response()->json($response, HttpResponse::HTTP_BAD_REQUEST);

        } catch (\Throwable $th) {
            $response = [
                'status' => HttpResponse::HTTP_INTERNAL_SERVER_ERROR,
                'message' => 'Internal Server Error',
            ];
            return response()->json($response, HttpResponse::HTTP_INTERNAL_SERVER_ERROR);

        }
    }

    public function signOut(Request $request)
    {
        try {
            $request->user()->currentAccessToken()->delete();

            $response = [
                'status' => HttpResponse::HTTP_OK,
                'message' => 'User berhasil logout',
            ];

            return response()->json($response, HttpResponse::HTTP_OK);

        } catch (\Throwable $th) {
            $response = [
                'status' => HttpResponse::HTTP_INTERNAL_SERVER_ERROR,
                'message' => 'Internal Server Error',
            ];
            return response()->json($response, HttpResponse::HTTP_INTERNAL_SERVER_ERROR);

        }
    }
}
