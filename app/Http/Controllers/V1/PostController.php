<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Post;
use App\Models\Image;
use App\Http\Requests\V1\Post\CreatePostRequest;

class PostController extends Controller
{
    /**
     * Display a listing post.
     *
     * @return ResponseJson
     */
    public function index()
    {
        $posts = Post::with(['author', 'images'])->paginate(10);
        return response()->json(compact('posts'));
    }

    /**
     * Display a lists post for user.
     *
     * @return ResponseJson
     */
    public function showMyPosts()
    {
        $posts = Auth::user()->posts()->with(['author', 'images'])->paginate(10);
        return response()->json(compact('posts'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreatePostRequest $request
     * @return ResponseJson
     */
    public function store(CreatePostRequest $request)
    {
        $post = Auth::user()->posts()->create($request->validated());
        if($request->file('images')){
            $path = $request->file('images')->store('upload', 'public');
            $post->images()->create([
                'path' => $path
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
        $post = Post::with(['author', 'images'])->findOrFail($id);
        return response()->json(compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //TODO:
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
        if($post->author_id === Auth::id()){
            $post->delete();
            return response()->json(['message' => 'Post delete']);
        }
        return response()->json(['message' => 'Unauthorized'], 403);
    }
}
