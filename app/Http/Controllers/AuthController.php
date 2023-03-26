<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api', 'role_or_permission:admin|seller'])->except(['login', 'register']);
    }
    //
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        
        if (! $token = JWTAuth::attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        
        return response()->json(['token' => $token]);
    }
    //register
    public function register(Request $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);

        // Assign the 'customer' role to the new user
        $customerRole = Role::where('name', 'customer')->first();
        $user->assignRole($customerRole);
        $user->save();

        return response()->json(['user' => $user,]);
    }
    public function forgotPassword(Request $request)
{
    // Validate the request data
    $validator = Validator::make($request->all(), [
        'email' => 'required|email',
    ]);

    if ($validator->fails()) {
        return response()->json(['error' => $validator->errors()], 400);
    }

    // Find the user by email
    $user = User::where('email', $request->email)->first();

    if (!$user) {
        return response()->json(['error' => 'Email not found'], 404);
    }

    // Create a new password reset request
    $token = Str::random(60);
    $passwordReset = PasswordReset::create([
        'email' => $user->email,
        'token' => $token
    ]);

    // Send the password reset email
    Mail::to($user->email)->send(new PasswordResetEmail($token));

    return response()->json(['message' => 'Password reset link sent to your email']);
    }

    
  

public function resetPassword(Request $request, $token)
{
    // Find the password reset request by token
    $passwordReset = PasswordReset::where('token', $token)->first();

    if (!$passwordReset) {
        return response()->json(['error' => 'Invalid token'], 400);
    }

    // Find the user by email
    $user = User::where('email', $passwordReset->email)->first();

    if (!$user) {
        return response()->json(['error' => 'Email not found'], 404);
    }

    // Validate the request data
    $validator = Validator::make($request->all(), [
        'password' => 'required|min:8|confirmed',
    ]);

    if ($validator->fails()) {
        return response()->json(['error' => $validator->errors()], 400);
    }

    // Update the user's password
    $user->password = Hash::make($request->password);
    $user->save();

    // Delete the password reset request
    $passwordReset->delete();

    return response()->json(['message' => 'Password reset successful']);
}

}