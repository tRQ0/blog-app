@extends('layouts/default')

@section('content')
    <div class="col">
        <a href='/post' class="btn btn-outline-primary">Go Back</a>
        <hr>
        <div class="card">
            {{-- card header --}}
            <div class="card-header">
                @if (!Auth::guest() && Auth::user()->id == $post->user_id)
                    <form action='{{ route('post.destroy', $post->id) }}' method='POST' class='float-end'>
                        @csrf
                        @method('DELETE')
                        <div class="btn btn-group">
                            <a href='{{ route('post.edit', $post->id) }}' class="btn btn-primary">Edit Post</a>
                            <input type='submit' value='Delete' class="btn btn-danger">
                        </div>
                    </form>
                @endif
                <div class="data p-1">
                    <h2>{{ $post->title }}</h2>
                </div>

                {{-- card body --}}
            </div>
            <div class="card-body">
                {{ $post->body }}
            </div>
            <div class="card-footer">
                <div class="card-data">
                    <small>Created - {{ $post->created_at->diffForHumans() }}</small>
                    @if ($post->updated_at)
                        <small class="float-end">Updated - {{ $post->updated_at->diffForHumans() }}</small>
                    @endif
                </div>
            </div>
        </div>
        <hr>
        @include('partials/comments')
    </div>
@endsection
