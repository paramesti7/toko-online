<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;

Route::get('/debug/users', function () {
    $users = User::select('id', 'email', 'is_admin')->get();
    return response()->json($users);
});

Route::get('/debug/test-login/{email}/{password}', function ($email, $password) {
    $user = User::where('email', $email)->first();
    
    if (!$user) {
        return response()->json(['error' => 'User tidak ditemukan']);
    }
    
    return response()->json([
        'user_found' => true,
        'email' => $user->email,
        'is_admin' => $user->is_admin,
        'password_match' => \Illuminate\Support\Facades\Hash::check($password, $user->password),
    ]);
});
