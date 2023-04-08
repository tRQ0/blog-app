@extends('layouts/default')

@section('content')
    <div class="col">
        <h1>Create Post</h1>
        <hr>
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('post.store') }}" enctype="multipart/form-data">
                    <div class="form-group">
                        @csrf
                        <label for='title' class='form-label'>Title</label>
                        <input type='text' id='title' name='title' placeholder='Post title'
                            class="form-control @error('body') is-invalid @enderror" />
                        <label for='body' class='form-label'>Body</label>
                        <textarea type='text' id='body' name='body' placeholder='Post body'
                            class="form-control @error('body') is-invalid @enderror"></textarea>
                        <label for='coverImage' class='form-label pt-3'>Cover Image</label>
                        <div class="form-group">
                            <input type="file" class="btn btn-primary" id="coverImage" name="coverImage" />
                        </div>
                    </div>
            </div>
            <div class="card-footer">
                <input type='submit' value='Create Post' class='btn btn-primary'><br>
            </div>
            </form>
        </div>

    </div>
@endsection
