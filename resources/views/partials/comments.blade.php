{{-- <div class="row p-3"> --}}
<div class="col">

    {{-- comment creation box --}}
    <div class="card">
        {{-- card body  --}}
        <div class="card-body">
            {{-- Display login button if guest --}}
            @if (!Auth::guest())
                <form action="{{ route('posts.comment.store', $post->id) }}" method="POST">
                    <div class="form-group">
                        @csrf
                        <label for="commentBody" class="form-label"> {{ __('Comment on the post') }} </label>
                        <input type="text" id="commentBody" name="commentBody"
                            class="form-control @error('body') is-invalid @enderror"
                            placeholder="Enter Comment body here" />
                        <input type="submit" value="Post Comment" class="btn btn-primary mt-2"><br>
                    </div>
                </form>
            @else
                <a class="link" href="{{ route('login') }}">{{ __('Login') }}</a> to comment on the post or to
                reply to comments
            @endif
        </div>
    </div>

    {{-- Show post commenst --}}

    {{-- @if (sizeof($post->comments) > 0) --}}
    <div class="card">
        <div class="card-header">
            <button class="btn btn-link" data-bs-toggle="collapse" data-bs-target="#comment-box" aria-expanded="false"
                aria-controls=".comment-box">{{ __('Show comments') }}</button>
        </div>
        <div class="collapse" id="comment-box">
            <div class="card-body">
                {{-- Parent Comment --}}
                @forelse($post->comments as $comment)
                    <div class="card m-2" id="comment-box">
                        <div class="card-header">
                            {{ $comment->user->name }}
                            <div class="data float-end">
                                {{ $comment->created_at->diffForHumans() }}

                                {{-- open collapsed reply menu --}}
                                @if (!Auth::guest())
                                    <button class="btn btn-secondary" data-bs-toggle="collapse"
                                        data-bs-target="#reply_{{ $comment->id }}" aria-expanded="false"
                                        aria-controls=".reply_{{ $comment->id }}">Reply</button>
                                @endif
                            </div>
                        </div>
                        <div class="card-body">
                            {{ $comment->body }}

                            {{-- Child Comment --}}
                            @forelse($comment->childComment as $reply)
                                <div class="card mt-3">
                                    <div class="card-header">
                                        {{ $reply->user->name }}
                                        <div class="data float-end">
                                            {{ $reply->created_at->diffForHumans() }}
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        {{ $reply->body }}
                                    </div>
                                </div>
                            @empty
                            @endforelse
                        </div>

                        {{-- reply box --}}
                        {{-- <div class="row collapse p-2" id="reply"> --}}
                        <div class="card-footer collapse" id="reply_{{ $comment->id }}">
                            @if (!Auth::guest())
                                <form action="{{ route('posts.comment.store', $post->id) }}" method="POST">
                                    @csrf
                                    <label for="commentBody" class="form-label">Reply to this comment</label>
                                    <input type="number" id="parentId" name="parentId" class="form-control"
                                        value="{{ $comment->id }}" hidden>
                                    <input type="text" id="commentBody" name="commentBody"
                                        class="form-control @error('body') is-invalid @enderror"
                                        placeholder="Enter reply body here" />
                                    <input type="submit" value="Reply" class="btn btn-primary mt-2"><br>
                                </form>
                            @else
                                <a class="link" href="{{ route('login') }}">{{ __('Login') }}</a> to reply
                            @endif
                        </div>
                    </div>
                @empty

                    {{-- if no comment exist --}}

                    There are no comments on this post
                @endforelse
            </div>
        </div>
    </div>
</div>
<hr>



{{-- <div class="col">
            <div class="title">
                {{ $comment->user->name }}
                <div class="small float-end">
                    {{ $comment->created_at }}
                </div>
            </div>
            <div class="body">
                {{ $comment->body }}
            </div>
            <div class="subComments">
                @forelse($comment->childComment as $reply)
                    <div class="row p-3 border  ">
                        <div class="col">
                            <div class="title">
                                {{ __('Reply') }}
                                <div class="body">
                                    {{ $reply->body }}
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                @endforelse --}}
{{-- </div>
                        <form action="{{ route('posts.comment.store', $post->id) }}" method="POST">
                            @csrf
                            <label for="commentBody" class="form-label">Reply on the post</label>
                            <input type="number" id="parentId" name="parentId" class="form-control"
                                value="{{ $comment->id }}" hidden>
                            <input type="text" id="commentBody" name="commentBody"
                                class="form-control @error('body') is-invalid @enderror"
                                placeholder="Enter reply body here" />
                            <input type="submit" value="Reply" class="btn btn-primary mt-2"><br>
                        </form> --}}

{{-- </div> --}}
