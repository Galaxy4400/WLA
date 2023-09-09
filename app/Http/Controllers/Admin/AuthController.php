<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Admin\Auth\LoginRequest;

class AuthController extends Controller
{
	
	public function loginForm()
	{
		return view('admin.auth.login');
	}


	public function login(LoginRequest $request)
	{
		$validator = Validator::make(['email' => $request->login], [
			'email' => ['required', 'email']
		]);

		$data = $request->validated();
		
		if(!$validator->fails()){
			unset($data['login']);
			$data['email'] = $validator->validated()['email'];
		}

		if (auth('admin')->attempt($data)) {
			$request->session()->regenerate();
			
			return redirect()->route('admin.home');
		}

		return redirect()->route('admin.login')->withErrors(['login' => 'Пользователь не найден, либо данные введены не правильно']);
	}


	public function logout(Request $request)
	{
		auth('admin')->logout();

		$request->session()->invalidate();
		$request->session()->regenerateToken();

		return redirect()->route('home');
	}
}
