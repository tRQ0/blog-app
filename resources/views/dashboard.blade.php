@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        {{ __('You are logged in!') }} 

                        <div class="row p-3">
                            <div class="col">

                                    @if( count($posts) > 0)
                                    
                                    <button class="btn btn-primary" data-bs-toggle="collapse" data-bs-target="#posts" aria-expanded="false" aria-controls=".row">Show posts</button>
                                    <div class="row collapse p-2" id="posts">
                                        <table class="table table-striped">
                                                <tr>
                                                    <th>Title</th>
                                                    <th></th>
                                                    <th></th>
                                                </tr>
                                                @foreach($posts as $post)
                                                <tr>
                                                    <td><a href='{{route('post.show', $post->id)}}'>{{$post->title}}</a></td>
                                                    <td><a href="{{route('post.edit', $post->id)}}" class="btn btn-success">Edit</a></td>
                                                    <td>
                                                        <form action='{{route('post.destroy', $post->id)}}' method='POST'>
                                                            @csrf
                                                            @method('DELETE')
                                                            <input type='submit' value='Delete' class="btn btn-danger">
                                                        </form>
                                                    </td>      
                                                </tr>
                                                @endforeach
                                            </table>
                                    </div>
                                
                                @else
                                    You have no posts
                                @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
