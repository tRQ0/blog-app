<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\Api\V1\PostRequestValidator;
use App\Filters\V1\PostFilter;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $itemsOnPage = $request->query('items');
       $posts = Post::orderBy('id')->with(['user' => function ($query) {
        $query->select('id', 'name');
       }])->paginate($itemsOnPage)->appends($request->query());
    //    $posts = json_encode($posts);
    //    $posts = json_decode($posts);
    //    $posts->data = collect($posts->data);
       
    //    $filter = new PostFilter();
    // //    function ($arr) {
    // //     $arr = $filter->transform($arr);
    // //     return $arr;
    // //    } 
    //    foreach($posts->data as $post) {
    //     // $post = $filter->transform($post);
    //     var_dump($post);
    //    }
        return $posts;
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
        $post = Post::where('id', $id)->with(['user' => function ($query) {
            return $query->select('id', 'name', 'email');
        }])->get();

        //fetch comment count
        $commentCount = Post::find($id)->comments()->count();

        // var_dump(isset($post->get(0)['cover_image']));

        //return cover image link if exists
        $coverImageLink = [];
         if(isset($post->get(0)['cover_image'])) {
            $coverImageLink = ['cover_image' => config('app.url') . '/storage/cover_images/' . $post->get(0)['cover_image']];
         }
        
        //conver $post to array and merge values at index 0
        $p = array_merge(
            $post->get(0)->toArray(), ['commentCount' => $commentCount],
            ['link' => route('post.show', $id)],
            $coverImageLink
        );

        //filter snake_case to camelCase
        $filter = new PostFilter();
        $p = $filter->transform($p);
        
        //replace the index 0 with merged and translated values
        $post->put(0, $p);

        return $post;
    }

}
