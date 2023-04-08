<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use App\Http\Requests\StorePostRequest;

use Illuminate\Http\Request;
use Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

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
        //image handling
        if($request->hasFile('coverImage')) {
            $filename = 'usr_' . Auth::id(). '_' . time();
            $extention = $request->file('coverImage')->getClientOriginalExtension();
            $fileNameToStore = $filename  . '.' . $extention;
            //upload image
            $path = $request->file('coverImage')->storeAs('public\cover_images', $fileNameToStore);
        } else {
            $fileNameToStore = null;
        }



        $validated = $request->validated();
        // $title = $validated['title'];
        // $body = $validated['body'];
        // $curTime = date('Y-m-d H:i:s');
        
        $res = Post::insert([
            'user_id' => Auth::id(),
            'title' => $validated['title'],
            'body' => $validated['body'],
            'cover_image' => $fileNameToStore,
            'created_at' => now(),
        ]);
        return redirect() -> action([PostsController::class, 'index']) -> with('success', 'Post Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
        $post = Post::find($id);
        if($post) {
            // $comments = Comment::find($post->id);
            return view('posts/show')->with('post', $post);
        }
        
        return redirect()-> action([PostsController::class, 'index']) -> with('error', 'The post you are trying to view does not exist!');
        
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
        if((Auth::id()) == $post -> user_id) {
            return view('posts/edit')->with('post', $post);
        }
        return redirect() -> action([PostsController::class, 'show'], ['post' => $id]) -> with('error', 'You are not the author of this post!');
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
        // This is overly complex and verbose
        // $validator = Validator::make($request->all(), [
        //     'body' => 'bail|required|unique:posts',                                                      //<- fix
        //     // 'body' => [
        //     //     'required', 
        //     //     Rule::unique('body') -> where(function ($query) {
        //     //         return $query -> where('id', $id);
        //     //     })
        //     // ]

        // ]);
        // $validated = $validator->validated();

        $validated = $request->validate([
            'body' => 'bail|required|unique:posts',                                                     //<- fix
            'newCoverImage' => 'image|nullable|max:1999',
        ]);

        //check for new cover image
        if($request->hasFile('newCoverImage')) {
            //delete old cover image form storage
            Storage::delete('public/cover_images/' . $request['oldCoverImage']);
            //process new cover image
            $filename = 'usr_' . Auth::id(). '_' . time();
            $extention = $request->file('newCoverImage')->getClientOriginalExtension();
            $fileNameToStore = $filename  . '.' . $extention;
            //upload image
            $path = $request->file('newCoverImage')->storeAs('public\cover_images', $fileNameToStore);
        } else {
            $fileNameToStore = $request['oldCoverImage'];
        }

        
        $body = $validated['body'];
        $curDate = date('Y-m-d H:i:s');
        $res = Post::where('id', $id) -> update([
            'body' => $body,
            'cover_image' => $fileNameToStore,
            'updated_at' => $curDate,
        ]);
        return redirect() -> action([PostsController::class, 'show'], ['post' => $id]) -> with('success', 'Post updated!');
    }
        
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //check if post belong to user
        $post = Post::find($id);
        if((Auth::id()) == $post -> user_id) {
            //Delete cover image from storage if post had one
            if(!is_null($post->cover_image)) {
                Storage::delete('public/cover_images/' . $post->cover_image);
            }
            //delete post from db
            $post -> delete();
            return redirect() -> action([PostsController::class, 'index']) -> with('success', 'Post Removed  :(');
        } 
        return redirect() -> action([PostsController::class, 'show'], ['post' => $id]) -> with('error', 'You are not the author of this post!');
    }
}
