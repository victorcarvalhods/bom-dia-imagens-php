<?php

namespace App\Http\Controllers;

use App\Exceptions\InvalidCredentialsException;
use App\Exceptions\UserAlreadyExistsException;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    //

    public function createUser(Request $request)
    {
        try {
            $rules = [
                'name' => 'required|string',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:8'
            ];

            $validatedRequestData = $request->validate($rules);

            $validatedRequestData['password'] = Hash::make($validatedRequestData['password']);

            $user = User::create($validatedRequestData);

            return response()->json($user, 201);
        } catch (\Throwable $th) {
            if ($th instanceof ValidationException){
                return response()->json(['error' => $th->errors()], 400);
            } else {
                Log::error($th);
                return response()->json(['error' => 'Internal Server Error'], 500);
            }
        }

        
    }

    public function authenticate(Request $request){
        $requestRules = [
            'email' => 'required|email',
            'password' => 'required|string'
        ];

        $validatedRequestData = $request->validate($requestRules);

        try {
            $user = User::where('email', $validatedRequestData['email'])->first();

            if (!$user || !Hash::check($validatedRequestData['password'], $user->password)) {
                throw new InvalidCredentialsException();
            }

            return response()->json($user, 200);
        } catch (\Throwable $th) {
            if ($th instanceof InvalidCredentialsException){
                return response()->json(['error' => 'Invalid credentials'], 401);
            } else {
                Log::error($th);
                return response()->json(['error' => 'Internal Server Error'], 500);
            }
        }
    }

    public function profile(Request $request){
        $rules = [
            'id' => 'required|integer'
        ];

        $validatedRequestData = $request->validate($rules);

        $user = User::find($validatedRequestData['id']);

        return response()->json($user, 200);
    }


}
