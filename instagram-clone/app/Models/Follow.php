<?php

namespace App\Models;

// use Jenssegers\Mongodb\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use MongoDB\Laravel\Eloquent\Model;


class Follow extends Model
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $connection = 'mongodb';
    protected $collection = 'follows';

    protected $fillable = [
        'follower_id', 
        'followed_id'
    ];

    // Relation to User model to find the follower
    public function follower()
    {
        return $this->belongsTo(User::class, 'follower_id');
    }

    // Relation to User model to find the user who is followed
    public function followed()
    {
        return $this->belongsTo(User::class, 'followed_id');
    }
}
