<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StorePostRequest;
use App\Models\Post;
use Validator;

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
        $posts = Post::orderBy('created_at','desc')->paginate(5);
        return view('posts/index')->with('posts', $posts);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePostRequest $request)
    {
        //
        $validated = $request->validated();
        $title = $validated['title'];
        $body = $validated['body'];
        $curTime = date('Y-m-d H:i:s');
        
        $res = Post::insert([
            'user_id' => auth()->user()->id,
            'title' => $title,
            'body' => $body,
            'created_at' => $curTime,
        ]);
        return redirect('post') -> with('success', 'Post Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
        $res = Post::find($id);
        if(Post::find($id) !== null) {
            $post = Post::find($id);
            return view('posts/show')->with('post', $post);
        }
        else {
            return redirect('post') -> with('error', 'The post you are view does not exist!');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //return the edit view
        $post = Post::find($id);
        return view('posts/edit')->with('post', $post);
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
        $validator = Validator::make($request->all(), [
            'body' => 'required|unique:posts',
        ], $messages = [
            'unique' => 'The body field was unchanged.',
        ]);
        $validated = $validator->validated();
        
        $body = $validated['body'];
        $curDate = date('Y-m-d H:i:s');
        $res = Post::where('id', $id) -> update([
            'body' => $body,
            'updated_at' => $curDate,
        ]);
        return redirect("post/$id") -> with('success', 'Post updated!');
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
        $post = Post::find($id) -> delete();
        return redirect('post') -> with('success', 'Post Removed  :)');

    }
}
