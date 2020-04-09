<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\V1\Comment\CreateCommentRequest;
use App\Http\Requests\V1\Comment\GetCommentsRequest;
use App\Http\Requests\V1\Comment\CreateSubCommentRequest;
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
    public function getSubComment(Request $request, $id)
    {
        $comment = CommentPost::where('parent_id', $id)->with('user')->get();
        return response()->json(compact('subComment'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
