<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Comment;
use App\Filters\V1\CommentFilter;


class CommentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param int $id //post ID
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        //
        return Post::find($id)->comments()->paginate(5);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $comment = Comment::where('id', $id)->with(['childComment' => function($query) {
            return $query;
        }])->get();
        
        $filter = new CommentFilter();
        $c = $comment->get(0)->toArray();
        $c = $filter->transform($c);
        foreach($c['replies'] as $reply) {
        $r = $reply->get(0)->toArray();
        $r = $filter->transform($r);
        }
        $comment->put(0, $c);
       
        return $c['replies'];
    }
}
