<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index($email)
    {
        $user = User::where('email', $email)->first();
        return response()->json([
            'status' => 'success',
            'data' => $user,
        ]);
    }

    public function updateGoogleId(Request $request, $id)
    {
        $request->validate([
            'google_id' => 'required',
        ]);

        $user = User::find($id);

        if ($user) {
            $user->google_id = $request->google_id;
            $user->save();

            return response()->json([
                'status' => 'success',
                'data' => $user,
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found',
            ], 404);
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'google_id' => 'required',
            'ktp_number' => 'required',
            'birth_date' => 'required',
            'gender' => 'required',
            'phone_number' => 'required',
        ]);

        $data = $request->all();
        $user = User::find($id);
        $user->update($data);

        return response()->json([
            'status' => 'success',
            'data' => $user,
        ]);
    }

    public function checkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user) {
            return response()->json([
                'status' => 'success',
                'data' => 'Email already registered',
                'valid' => false,
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'User not registered',
                'valid' => true,
            ], 404);
        }
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $email = $request->email;
        $password = $request->password;

        $user = User::where('email', $email)->first();

        if (!$user || !Hash::check($password, $user->password)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid credentials',
            ], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'data' => [
                'user' => $user,
                'token' => $token,
            ],
        ], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Token deleted',
        ], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'role' => 'required',
        ]);

        $data = $request->all();
        $name = $request->name;
        $email = $request->email;
        $password = Hash::make($request->password);
        $role = $request->role;

        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'role' => $role,
        ]);

        return response()->json([
            'status' => 'success',
            'data' => $user,
        ], 200);
    }
}
