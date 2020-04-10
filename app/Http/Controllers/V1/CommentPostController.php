<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\V1\Comment\CreateCommentRequest;
use App\Http\Requests\V1\Comment\GetCommentsRequest;
use App\Models\CommentPost;

class CommentPostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  GetCommentsRequest  $request
     * @return ResponseJson
     */
    public function index(Request $request, $id, $offset)
    {
        $comment = CommentPost::offset($offset)->take(1)->where('post_id', $id)->with('user')->get();
        $hasMore = false;
        if(count($comment))
        {
            $hasMore = true;
        }
        return response()->json(compact('comment', 'hasMore'));
    }

    /**
     * Store a newly created comment in storage.
     *
     * @param  CreateCommentRequest  $request
     * @return ResponseJson
     */
    public function createComment(CreateCommentRequest $request)
    {
        $credentials = $request->validated();
        $comment = CommentPost::create($credentials);

        return response()->json(compact('comment'));
    }
}
