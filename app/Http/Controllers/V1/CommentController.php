<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Models\Comment;
use App\Models\Post;
use App\Http\Requests\V1\Comment\CreateCommentRequest;
use App\Http\Requests\V1\Comment\UpdateCommentRequest;


class CommentController extends Controller
{
    /**
     * Display a lists comment for post.
     *
     * @return ResponseJson
     */
    public function index($id)
    {
        $comments = Post::findOrFail($id)->comments()->with(['comments.author.avatar', 'author.avatar'])->latest()->paginate(10);

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
        if(isset($data['parent_id'])) {
            $comment = Comment::findOrFail($data['parent_id'])->comments()->create($data);
        } else {
            $comment = Post::findOrFail($id)->comments()->create($data);
        }

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
     * @param  UpdateCommentRequest  $request
     * @param  int  $id
     * @return ResponseJson
     */
    public function update(UpdateCommentRequest $request, $post_id, $id)
    {
        $comment = Comment::findOrFail($id);
        $data = $request->validated();
        Gate::authorize('update-comment', $comment);

        $comment->fill($data)->save();

        return response()->json(compact('comment'));
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
        Gate::authorize('delete-comment', $comment);
        $comment->delete();
        return response()->json(['message' => 'Successful']);
    }
}
