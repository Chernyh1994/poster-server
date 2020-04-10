<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\V1\Comment\CreateSubCommentRequest;
use App\Models\CommentPost;

class SubCommentController extends Controller
{
 /**
     * Store a newly created comment in storage.
     *
     * @param  CreateSubCommentRequest  $request
     * @return ResponseJson
     */
    public function createSubComment(CreateSubCommentRequest $request)
    {
        $credentials = $request->validated();
        $comment = CommentPost::create($credentials);

        return response()->json(compact('comment'));
    }

    /**
     * Display a listing of the resource.
     *
     * @param  Request  $request
     * @return ResponseJson
     */
    public function getSubComment(Request $request, $parenId)
    {
        $subComment = CommentPost::where('parent_id', $parenId)->with('user')->get();
        return response()->json(compact('subComment'));
    }
}
