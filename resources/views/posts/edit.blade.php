@extends('layouts/default')

@section('content')
<div class="col">
    <h1>Edit Post: <small><u>{!!$post -> title!!}</u></small></h1>
    <form id='loginform' method='POST' action='/post/{{$post -> id}}'>
        <div class='form-group'>
            @csrf
            @method('PUT')
            <label for='title' class='form-label'>Title</label>
            <input type="text" name="title" value='{{$post -> title}}' class='form-control' readonly>
            <label for='body' class='form-label'>Body</label>
            <textarea type='text' id='body' name='body' class="form-control @error('body') is-invalid @enderror">{{$post -> body}}</textarea>
            <br/>
            <input type='submit' value='Edit' class='btn btn-primary'><br>
        </div>
    </form>
</div>
@endsection 