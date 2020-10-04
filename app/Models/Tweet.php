<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tweet extends Model
{
    use HasFactory;

    protected $fillable = ["content", "user_id", "gif"];
    protected $with = ["user"];
    protected $withCount = ["likes"];
    protected $appends = ["liked"];

    public function user() {
    	return $this->belongsTo(User::class);
    }

    public function likes() {
    	return $this->belongsToMany(User::class, "likes");
    }

    public function getLikedAttribute() {
        return $this->likes()->where("user_id", auth()->id())->exists();
    }

    public function getCreatedAtAttribute($value) {
    	return Carbon::parse($value)->diffForHumans();
    }
}
