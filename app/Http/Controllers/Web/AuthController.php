<?php

namespace App\Http\Controllers\Web;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Jobs\ForgotPasswordJob;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Registered;
use App\Http\Requests\Web\Auth\LoginRequest;
use App\Http\Requests\Web\Auth\ForgotRequest;
use App\Http\Requests\Web\Auth\RegisterRequest;
use Illuminate\Foundation\Auth\EmailVerificationRequest;


class AuthController extends Controller
{

	public function loginForm()
	{
		return view('auth.login');
	}


	public function registerForm()
	{
		return view('auth.register');
	}


	public function forgotForm()
	{
		return view('auth.forgot');
	}


	public function login(LoginRequest $request)
	{
		if (auth('web')->attempt($request->validated())) {
			$request->session()->regenerate();
			
			return redirect()->route('home');
		}

		return redirect()->route('login.form')->withErrors(['email' => 'Пользователь не найден, либо данные введены не правильно']);
	}


	public function register(RegisterRequest $request)
	{
		$data = $request->validated();
		$data['password'] = bcrypt($data['password']);

		$user = User::create($data);
		
		if ($user) {
			event(new Registered($user));
		}

		return view('auth.verify-notice');
	}


	public function forgot(ForgotRequest $request)
	{
		$user = User::where('email', $request->validated()['email'])->firstOrFail();

		$password = Str::random(10);

		$user->password = bcrypt($password);
		$user->save();

		dispatch(new ForgotPasswordJob($user, $password));

		return redirect()->route('home');
	}


	public function verifyNotice()
	{
		return view('auth.verify-notice');
	}


	public function verify(EmailVerificationRequest $request)
	{
		$request->fulfill();

		return redirect()->route('home');
	}


	public function logout(Request $request)
	{
		auth('web')->logout();

		$request->session()->invalidate();
		$request->session()->regenerateToken();

		return redirect()->route('home');
	}
}