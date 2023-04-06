@extends('layouts/default')

@section('content')
    <div class="col">
        @foreach ($posts as $post)
            <div class="card my-3">
                <div class="card-header">
                    <div class="data float-end">
                        Created - {{ $post->created_at->diffForHumans() }}
                    </div>
                </div>
                <div class="card-body">
                    <h1><a href='{{ route('post.show', $post->id) }}'><u>{!! $post->title !!}</u></a></h1>
                    <hr>
                    Author: {{ $post->user->name }}
                </div>
            </div>
        @endforeach
        {{-- <div class="row row-outline">
            <div class="col d-flex justify-content-center"> --}}
        {{ $posts->links('pagination::bootstrap-4') }}
        {{-- </div> --}}
        {{-- </div> --}}
    </div>
@endsection
