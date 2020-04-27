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
            $query->with('author');
        })->paginate(10);
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
        $comment = Post::findOrFail($id)->comments()->create(
            Arr::add($request->validated(), 'author_id', Auth::id())
        );
        return response()->json(compact('comment'));
    }

    /**
     * Display a lists comment for comment.
     *
     * @param  int $post_id, $id
     * @return ResponseJson
     */
    public function show($post_id, $id)
    {
        $sub_comments = Comment::where('parent_id', '=', $id)->with(['author'])->get();
        return response()->json(compact('sub_comments'));
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
        //
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
            return response()->json(['message' => 'comment delete']);
        }
        return response()->json(['message' => ' comment not delete'], 403);
    }
}
