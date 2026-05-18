<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{
    public function toResponse($request)
    {
        $user = $request->user();

        // 🔥 Your logic here
        if ($user->role == 'admin') {
            return redirect()->route('dashboard');
        }

        if ($user->role == 'lecturer') {
            return redirect()->route('lecturer.dashboard');
        }

        return redirect()->route('login');
    }
}