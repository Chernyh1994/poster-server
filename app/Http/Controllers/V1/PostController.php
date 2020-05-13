<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Gate;
use App\Models\Post;
use App\Models\Image;
use App\Http\Requests\V1\Post\CreatePostRequest;
use App\Http\Requests\V1\Post\UpdatePostRequest;

class PostController extends Controller
{
    /**
     * Display a listing post.
     *
     * @return ResponseJson
     */
    public function index()
    {
        $posts = Post::with(['author.avatar', 'images', 'video'])->withCount(['comments', 'likes'])->latest()->paginate(10);

        return response()->json(compact('posts'));
    }

    /**
     * Display a lists post for user.
     *
     * @return ResponseJson
     */
    public function showMyPosts()
    {
        $posts = Auth::user()->posts()->with(['author.avatar', 'images', 'video'])->withCount(['comments', 'likes'])->latest()->paginate(10);
        
        return response()->json(compact('posts'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreatePostRequest $request
     * 
     * @return ResponseJson
     */
    public function store(CreatePostRequest $request)
    {
        $data = $request->validated();
        $post = Auth::user()->posts()->create($data);
        if($request->file('images')){
            $request->file('images')->store('upload/postImages', 'public');
            $name = $request->file('images')->hashName();
            $path = asset('storage/upload/postImages/'.$name);
            $post->images()->create([
                'path' => $path,
                'name' => $name,
                'mime' => $request->file('images')->getMimeType(),
                'size' => $request->file('images')->getSize(),
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
        $post = Post::with(['author.avatar', 'images'])->findOrFail($id);

        return response()->json(compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdatePostRequest  $request
     * 
     * @param  int  $id
     * @return Response
     */
    public function update(UpdatePostRequest $request, $id)
    {
        $data = $request->validated();
        Gate::authorize('update-post', $post);

        $post = Post::findOrFail($id);
        $post->update($data);

        return response()->json(compact('post'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return ResponseJson
     */
    public function destroy($id)
    {
        Gate::authorize('delete-post', $post);

        $post = Post::findOrFail($id);
        $post->delete();

        return response()->json(['message' => 'Successful']);
    }
}
