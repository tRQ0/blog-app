@extends('layouts/default')

@section('content')
<div class="col">
    <h1>Create Post</h1>
    <hr>
    <form method='POST' action='/post'>
        <div class='form-group'>
            @csrf
            <label for='title' class='form-label'>Title</label>
            <input type='text' id='title' name='title' placeholder='Post title' class="form-control @error('body') is-invalid @enderror"/>
            <label for='body' class='form-label'>Body</label>
            <textarea type='text' id='body' name='body' placeholder='Post body' class="form-control @error('body') is-invalid @enderror"></textarea>
            <input type='submit' value='Create Post' class='btn btn-primary'><br>
        </div>        
    </form>
</div>
@endsection