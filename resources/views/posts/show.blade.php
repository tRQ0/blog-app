@extends('layouts/default')

@section('content')
<div class="col">
    <a href='/post' class="btn btn-outline-primary">Go Back</a>   
    <form action='/post/{{$post->id}}' method='POST' class="float-right">
        @csrf
        @method('DELETE')
        <div class="btn-group">
            <a href='/post/{{$post->id}}/edit' class="btn btn-primary">Edit Post</a>
            <input type='submit' value='Delete' class="btn btn-danger">
        </div>
    </form>
    <hr>
    <h1>{{$post->title}}</h1>
    <h2>{{$post->body}}</h2>
    <hr>
    <small>Created on - {{$post->created_at}}</small><br/>
    {!!(isset($post->updated_at)) ? 
        "<small> Updated on - $post->updated_at<small>" : '' 
    !!}
</div>
@endsection