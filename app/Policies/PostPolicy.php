<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\Post;


class PostPolicy
{
    use HandlesAuthorization;

    public function update(User $user, Post $post){
        
        \Log::info("Req=PostPolicy@update called");
        
        return $user->id === $post->user_id;

    }

    public function delete(User $user, Post $post){
        
        \Log::info("Req=PostPolicy@delete called");

        return $user->id == $post->user_id;
    }
}