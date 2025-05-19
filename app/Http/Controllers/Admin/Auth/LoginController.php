<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Exceptions\ApiException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function __invoke(LoginRequest $request)
    {

        if (!Auth::attempt($request->validated())) {
            throw new ApiException(401, 'Неверный логин или пароль');
        }

        $user = Auth::user();

        return [
            'user' => $user,
            'token' => $user->createToken('token')->plainTextToken,
        ];
    }
}
