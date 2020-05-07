<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\V1\Comment\CreateCommentRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr;
use App\Models\Comment;
use App\Models\Post;

class CommentController extends Controller
{
    /**
     * Display a lists comment for post.
     *
     * @return ResponseJson
     */
    public function index($id)
    {
        $comments = Post::findOrFail($id)->comments(function($query) {
            $query;
        })->with(['comments.author', 'author'])->latest()->paginate(10);
        return response()->json(compact('comments'));
    }

    /**
     * Created new comment in storage.
     *
     * @param  CreateCommentRequest  $request
     * @return ResponseJson
     */
    public function store(CreateCommentRequest $request, $id)
    {
        $data = $request->validated();
        $comment = Post::findOrFail($id)->comments()->create($data);
        return response()->json(compact('comment'));
    }

    /**
     * Show comment with under comment.
     *
     * @param  int $post_id, $id
     * @return ResponseJson
     */
    public function show($post_id, $id)
    {
        $comment = Post::findOrFail($post_id)->comments()->with(['comments.author'])->findOrFail($id);
        return response()->json(compact('comment'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return ResponseJson
     */
    public function update(Request $request, $id)
    {
        //TODO
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $post_id, $id
     * @return ResponseJson
     */
    public function destroy($post_id, $id)
    {
        $comment = Comment::findOrFail($id);
        if($comment->author_id === Auth::id()){
            $comment->delete();
            return response()->json(['message' => 'Comment delete']);
        }
        return response()->json(['message' => 'Unauthorized'], 403);
    }
}
