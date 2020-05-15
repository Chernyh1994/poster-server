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
            ->with(['comments.author.avatar', 'author.avatar'])
            ->withCount(['comments', 'likes'])
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
        $comment = Post::findOrFail($post_id)->comments()
            ->with(['comments.author', 'author.avatar'])
            ->withCount(['comments', 'likes'])
            ->findOrFail($id);

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
        $data = $request->validated();
        $comment = Comment::findOrFail($id);

        Gate::authorize('update', $comment);

        $comment->update($data);

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
        Gate::authorize('delete', $comment);
        
        $comment->delete();

        return response()->json(['message' => 'Successful']);
    }

    /**
     * Add a like for comment.
     *
     * @param Request $request
     * 
     * @return ResponseJson
     */
    public function commentLike(Request $request)
    {
        $comment_id = $request['comment_id'];
        $comment = Comment::findOrFail($comment_id);
        $user = Auth::user();

        $like = $user->likes()->where('liketable_id', $comment_id)->first();

        if($like) {
           $like->delete();
           return response()->json(['message' => 'Delete successful']);
        }

        $like = new Like;
        $like->author_id = $user->id;

        $comment->likes()->save($like);

        return response()->json(compact('like'));
    }
}
