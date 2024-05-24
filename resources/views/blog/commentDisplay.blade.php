@foreach($comments as $comment)

    <div class="display-comment" @if($comment->parent_id != null) style="margin-left:40px;" @endif>

        <strong>{{ $comment->user->name }}</strong>

        <p>{{ $comment->message }}</p>

        {{-- <a href="" id="reply"></a> --}}

        <form method="POST" action="{{ route('comments.store') }}">
            @csrf
            <div class="form-group">

                <textarea type="text" name="message" class="form-control"></textarea>

                <input type="hidden" name="blog_id" value="{{ $blog_id }}" />

                <input type="hidden" name="parent_id" value="{{ $comment->id }}" />

            </div>

            <div class="form-group">

                <input type="submit" class="btn btn-warning" value="Reply" />

            </div>

        </form>

        @include('blog.commentDisplay', ['comments' => $comment->replies])

    </div>
    @endforeach
