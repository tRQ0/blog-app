@extends('layouts/default')

@section('content')
    <div class="col">
        <div class="card">
            <div class="card-header">
                <h1>Edit Post: <small><u>{!! $post->title !!}</u></small></h1>
            </div>
            <div class="card-body">
                <form id='loginform' method='POST' action='{{ route('post.update', $post->id) }}'
                    enctype="multipart/form-data">
                    <div class='form-group'>
                        @csrf
                        @method('PUT')
                        <label for='title' class='form-label'>Title</label>
                        <input type="text" name="title" value='{{ $post->title }}' class='form-control' readonly>
                        <label for='body' class='form-label mt-2'>Body</label>
                        <textarea type='text' id='body' name='body' class="form-control @error('body') is-invalid @enderror">{{ $post->body }}</textarea>
                        @if ($post->cover_image)
                            <div class="row">
                                <div class="col-md-4 col-sm-4" style="height: 50%;">
                                    <label for='currentCoverImage' class="form-label mt-2">Current cover Image</label>
                                    <img src="/storage/cover_images/{{ $post->cover_image }}"
                                        style="width: 100%; object-fit: contain; object-position: 100% 0;"
                                        class="form-label" />
                                </div>
                            </div>
                        @endif
                        <label for='newCoverImage' class="form-label mt-2">New cover Image</label>
                        <input type="file" class="form-control btn-primary" name="newCoverImage" />
                        <input type="text" hidden name="oldCoverImage" value="{{ $post->cover_image }}" />
                        <input type='submit' value='Edit' class='btn btn-primary mt-3'>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
