@extends('layouts/default')

@section('content')
    <div class="col">
        @foreach ($posts as $post)
            <div class="card my-3">
                <div class="card-body">
                    {{-- load when cover image exist --}}
                    @if ($post->cover_image)
                        <div class="row">
                            <div class="col-md-4 col-sm-4" style="height: 50%;">

                                <img style="width: 100%; object-fit: contain; object-position: 100% 0;"
                                    src="storage/cover_images/{{ $post->cover_image }}">


                            </div>
                            <div class="col-md-8 col-sm-4">
                                <h1>
                                    <a href="{{ route('post.show', $post->id) }}"><u>{!! $post->title !!}</u></a>
                                </h1>
                            </div>
                        </div>
                    @else
                        {{-- load when cover image does not exist --}}
                        <h1><a href="{{ route('post.show', $post->id) }}"><u>{!! $post->title !!}</u></a></h1>
                    @endif
                    <hr>

                    Author: {{ $post->user->name }}
                    <div class="data float-end">
                        Created - {{ $post->created_at->diffForHumans() }}
                    </div>
                </div>

            </div>
        @endforeach
        <div class="row row-outline">
            <div class="col d-flex justify-content-center">
                {{ $posts->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
@endsection
