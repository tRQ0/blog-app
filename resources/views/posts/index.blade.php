@extends('layouts/default')

@section('content')
    <div class="col">
        @foreach ($posts as $post)
        <div class="card">
            <div class="card-header">
                <div class="data float-end">
                    Created on - {{$post->created_at}}
                </div>
            </div>
            <div class="card-body">
                <h1><a href='{{route('post.show', $post->id)}}'><u>{!!$post->title!!}</u></a></h1>
                <hr>
                Author: {{$post->user->name}}
            </div>
        </div>
        @endforeach
        <div class="row row-outline">
            <div class="col d-flex justify-content-center">
                {{$posts->links()}}
            </div>
        </div>
    </div>

@endsection