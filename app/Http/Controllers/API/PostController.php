<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StorePostRequest;
use App\Models\Post;
use App\Http\Resources\Post as PostResource;
use App\Models\Topic;

class PostController extends Controller
{
    public function store(StorePostRequest $request, Post $post, Topic $topic){

        \Log::info("Req=API/PostController@store called");

        $post->body = $request->body;

        $post->user()->associate($request->user());
        
        $topic->posts()->save($post);

        return new PostResource($post);

    }
}