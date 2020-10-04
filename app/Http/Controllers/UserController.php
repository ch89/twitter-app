<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\UserFollowed;
use Illuminate\Http\Request;

class UserController extends Controller
{
	public function index() {
		return User::where("id", "!=", auth()->id())->withCount("tweets")->get();
	}

	public function show(User $user) {
		return $user->load("tweets")->loadCount(["following", "followers"]);
	}

	public function update(User $user) {
		$data = request()->validate([
			"name" => "required",
			"avatar" => "image"
		]);

		if(request()->has("avatar")) {
			$data["avatar"] = request("avatar")->store("avatars");
		}

		$user->update($data);

		return $user;
	}

	public function follow(User $user) {
		auth()->user()->following()->toggle($user);

		$user->notify(new UserFollowed);
	}
}
