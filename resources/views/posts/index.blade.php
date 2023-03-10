@extends('layouts/default')

@section('content')
    <div class="col">
@foreach ($posts as $post)
    <h1><a href='./post/{{$post->id}}'><u>{!!$post->title!!}</u></a></h1>
    created on - {{$post->created_at}}
    @endforeach
        <div class="row row-outline">
            <div class="col d-flex justify-content-center">
                {{$posts->links()}}
            </div>
        </div>
    </div>

@endsection