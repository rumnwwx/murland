<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Exceptions\ApiException;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function __invoke(Request $request)
    {
        $credentials = $request->validate([
            'login' => 'string|required',
            'password' => 'string',
        ]);

        if (!Auth::attempt($credentials)) {
            throw new ApiException(401, 'Неверый логин или пароль');
        }

        $user = Auth::user();

        return [
            'user' => $user,
            'token' => $user->createToken('token')->plainTextToken,
        ];
    }
}
