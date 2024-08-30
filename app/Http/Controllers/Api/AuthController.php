<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function __invoke(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'string', 'email', 'max:255', Rule::exists('users', 'email')],
            'password' => ['required', 'string', Password::default()],
        ]);

        if (! auth()->attempt($data)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid email or password',
            ], 422);
        }

        $permissions = auth()->user()->hasAnyRole(['admin', 'moderator']) ? ['full'] : ['read'];

        $token = $request->user()->createToken(
            $request->get('device_name', 'api'),
            $permissions,
            now()->addMinutes(30)
        );

        return response()->json([
            'status' => 'success',
            'data' => [
                'token' => $token->plainTextToken,
            ],
        ]);
    }
}
