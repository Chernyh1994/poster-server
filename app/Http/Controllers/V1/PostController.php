<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Arr;
use App\Models\Post;
use App\Models\Image;
use App\Http\Requests\V1\Post\CreatePostRequest;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return ResponseJson
     */
    public function index()
    {
        $posts = Post::with(['author', 'images'])->paginate(10);
        return response()->json(compact('posts'));
    }

    /**
     * Display a listing from user of the resource.
     *
     * @return ResponseJson
     */
    public function showPostsUser()
    {
        $user_posts = Post::where('author_id', Auth::id())->with(['author', 'images'])->get();
        return response()->json(compact('user_posts'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreatePostRequest $request
     * @return ResponseJson
     */
    public function store(CreatePostRequest $request)
    {
        $data = Arr::add($request->validated(), 'author_id', Auth::id());
        $post = Post::create($data);
        if($request->file('images')){
            $path = $request->file('images')->store('upload', 'public');
            $post->images()->create([
                'path' => $path,
                'post_id' => $post->id
            ]);
        }
        return response()->json(compact('post'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return ResponseJson
     */
    public function show($id)
    {
        $post = Post::with(['author', 'comments', 'images'])->findOrFail($id);
        return response()->json(compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return ResponseJson
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();
        return response()->json(['message' => 'post delete']);
    }
}
