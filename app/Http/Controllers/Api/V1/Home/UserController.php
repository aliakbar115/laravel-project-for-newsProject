<?php

namespace App\Http\Controllers\Api\V1\Home;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $validData = $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'api_token' => Str::random(100)
        ]);
        return [
            'status'=>'success',
            'message'=>"ثبت نام با موفقیت انجام شد",
        ];
    }
    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|exists:users,email',
            'password' => 'required|string|min:6',
        ]);
        if (! auth()->attempt($validated)) { // اگر اطلاعات درست باشد لاگین می کند
            return response([
                'message'=>'اطلاعات صحیح نیست',
            ],403);
        }
        $user=auth()->user();
        return new \App\Http\Resources\V1\User($user);
    }
}
