<div class="row p-3 border  ">
    <div class="col">

        {{-- Show post commenst --}}
        
        @if(sizeof($post->comments) > 0)
            @foreach( $post->comments as $comment)
            <div class="row p-3 border  ">
                <div class="col">
                    <div class="title"> 
                        {{$comment->user->name}}
                        <div class="small float-end">
                            {{$comment->created_at}}
                        </div>
                    </div>
                    <div class="body">
                        {{$comment->body}}
                    </div>
                </div>
            </div>
            @endforeach
        @else
        There are no comments on this post
        @endif
        
        <hr>

        {{-- Display login button if guest --}}
        @if(!Auth::guest())
        <form action="{{ route('posts.comment.store', $post->id) }}" method="POST">
        <div class="form-group">
                @csrf
                <label for="commentBody" class="form-label">Comment on the post</label>
                <input type="text" id="commentBody" name="commentBody" class="form-control @error('body') is-invalid @enderror" placeholder="Enter Comment body here"/>
                <input type="submit" value="Post Comment" class="btn btn-primary"><br>
            </div>
        </form>
        @else
        <a class="link" href="{{ route('login') }}">{{ __('Login') }}</a> to comment on the post
        @endif
    </div>
</div>