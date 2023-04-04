<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends BaseController
{
    /**
     * @return \App\User
     */
    public function login(Request $request)
    {
        $data = $request->all();
        $validator = validator($data, [
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

        $authenticated = Auth::attempt([
            'email' => $data['email'],
            'password' => $data['password']
        ]);

        if (!$authenticated) {
            return response()->json([
                'error' => true,
                'message' => 'Invalid email or password.',
            ]);
        }

        $user = Auth::user();
        $tokens = [];
        foreach ($user->tokens as $personalToken) {
            $tokens[] = $personalToken->token;
        }
        return response()->json([
            'user' => [
                'email' => $user->email,
                'name' => $user->name
            ],
            'token' => $tokens
        ]);
    }
}
