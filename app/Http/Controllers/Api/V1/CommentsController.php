<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\V1\PostsController;
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
        $posts = new PostsController();

        $post = $posts -> show($id);

        $comments = $this->show($id, 'post_id');

        //combine the result
        $postComments = collect(['post' => [], 'comments' => []]);
        $postComments->put('post', $post[0]);
        $postComments->put('comments', $comments);
        
        return $postComments;
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @param string $searchParam
     * @return \Illuminate\Http\Response
     */
    public function show($id, $searchParam = 'id')
    {
        //
        $filter = new CommentFilter();

        $comment = Comment::where($searchParam, $id)->with(['childComment' => function($query) {
            return $query;
        }])->get();
        
        //if searchParam is not 'id' then transform iteratively
        if($searchParam !== 'id') {

            $c = $comment->toArray();
            // $c = $filter->transform($c);
            $i = 0;
            //transform property names for the comment
            foreach($comment->toArray() as $c) {
                $c = $filter->transform($c);
                for($j = 0; $j < (sizeof($c['replies'])); $j++) {
                    $c['replies'][$j] = $filter->transform($c['replies'][$j]);
                    // var_dump($c['replies'][$j]);
                }
                $comment->put($i, $c);
                $i++;        
            }
            return $comment;
        } 

        //else transform single array element

        //transform property names for the comment
        $c = $comment->get(0)->toArray();
        $c = $filter->transform($c);

        //transform property names for the replies
        for($j = 0; $j < (sizeof($c['replies'])); $j++) {
            $c['replies'][$j] = $filter->transform($c['replies'][$j]);
            // var_dump($c['replies'][$j]);
        }
        //update original collection with transformed values
        $comment->put(0, $c);   
        
        return $comment;
        // foreach($c['replies'] as $reply) {
            //     // $r = collect($reply)->get(0)->toArray();
            //     $reply = $filter->transform($reply);
            // }
    }
}
