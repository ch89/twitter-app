<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
	public function index() {
		return User::where("id", "!=", auth()->id())->withCount("tweets")->get();
	}

	public function follow(User $user) {
		auth()->user()->following()->toggle($user);
	}
}
