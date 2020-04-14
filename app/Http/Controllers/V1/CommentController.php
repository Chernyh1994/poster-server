<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\V1\Comment\CreateCommentRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr;
use App\Models\Comment;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return ResponseJson
     */
    public function index($id)
    {
        $comments = Comment::where('post_id', '=', $id)->with('author')->paginate(10);
        return response()->json(compact('comments'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateCommentRequest  $request
     * @return ResponseJson
     */
    public function store(CreateCommentRequest $request, $id)
    {
        $data = Arr::add($request->validated(), 'author_id', Auth::id());
        $data = Arr::add($data, 'post_id', $id);
        $comment = Comment::create($data);
        return response()->json(compact('comment'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return ResponseJson
     */
    public function show($postId, $id)
    {
        $comment = Comment::where('post_id', '=', $postId)->with(['author', 'comments'])->findOrFail($id);
        return response()->json(compact('comment'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
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
     * @param  int  $id
     * @return ResponseJson
     */
    public function destroy($postId, $id)
    {
        $comment = Comment::has('author_id', Auth::id())->findOrFail($id);
        $comment->delete();
        return response()->json(['message' => 'comment delete']);
    }
}
