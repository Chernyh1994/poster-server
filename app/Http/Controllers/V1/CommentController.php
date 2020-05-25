<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Like;
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
        $comments = Post::findOrFail($id)->comments()
            ->with(['subcomments.author.profile', 'author.profile'])
            ->withCount(['subcomments', 'likes'])
            ->latest()
            ->paginate(10);

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

        $comment->refresh()->load('author.profile');

        return response()->json(compact('comment'));
    }

    /**
     * Display a lists comment for post.
     *
     * @param  int $post_id, $id
     * @return ResponseJson
     */
    public function show($post_id, $created_at)
    {
        $comments = Post::findOrFail($post_id)->comments()
            ->with(['subcomments.author.profile', 'author.profile'])
            ->withCount(['subcomments', 'likes'])
            ->where('created_at', '<', $created_at)
            ->latest()
            ->limit(5)
            ->get();

        $has_more = (boolean)count($comments);

        return response()->json(compact('comments', 'has_more'));
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
        $data = $request->validated();
        $comment = Post::findOrFail($post_id)->comments()->findOrFail($id);

        Gate::authorize('update', $comment);

        $comment->update($data);
        $comment->refresh()->load(['author.profile', 'subcomments']);

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
        $comment = Post::findOrFail($post_id)->comments()->findOrFail($id);

        Gate::authorize('delete', $comment);
        
        $comment->delete();

        return response()->json(['message' => 'Successful']);
    }

    /**
     * Add a like for comment.
     *
     * @param  int $id
     * @return ResponseJson
     */
    public function commentLike($id)
    {
        $comment = Comment::findOrFail($id);
        $user = Auth::user();
        $like = $comment->likes()->where('author_id', $user->id)->first();

        if($like) {
           return response()->json(['message' => 'Comment already has like by you']);
        }
        
        $like = new Like;
        $like->author_id = $user->id;

        $comment->likes()->save($like);

        return response()->json(compact('like'));
    }

    /**
     * Add unlike for comment.
     *
     * @param  int $id
     * @return ResponseJson
     */
    public function commentUnlike($id)
    {
        $user = Auth::user();
        $like = Comment::findOrFail($id)->likes()->where('author_id', $user->id)->first();

        Gate::authorize('unlike', $like);

        $like->delete();

        return response()->json(['message' => 'Unlike successful']);
    }
}
