<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;

class RegisterController extends BaseController
{
    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    public function create(Request $request)
    {
        $validator = validator($request->all(), [
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        if ($validator->errors()->isNotEmpty()) {
            $errors = $validator->errors()->getMessages();
            $fieldErrors = array_keys($errors);
            return response()->json([
                'error' => true,
                'message' => array_map(function($field) use ($errors) {
                    return $errors[$field][0];
                }, $fieldErrors ),
            ]);
        }
 
        $data = $request->all();
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'api_token' => Str::random(60),
        ]);

        $token = $user->createToken('api_token')->plainTextToken;

        return response()->json([
            'user' => [
                'email' => $user->email,
                'name' => $user->name
            ],
            'token' => $token
        ]);
    }
}
