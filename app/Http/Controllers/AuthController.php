<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
	public function __construct() {
		$this->middleware("auth:api")->except(["register", "login"]);
	}

	public function register() {
		
	}

	public function login() {
		$token = auth()->attempt(request()->validate([
			"email" => "required",
			"password" => "required"
		]));

		if($token) {
			return [
				"token" => $token,
				"user" => auth()->user()
			];
		}
		else {
			return response()->json(["error" => "Unauthorized"], 401);
		}
	}

	public function logout() {
        auth()->logout();
    }
}