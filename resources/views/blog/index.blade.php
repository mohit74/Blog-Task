@extends('layout.app')
@section('content')
    <div class="row mt-4">
        <div class="col-md-12">
            <h1 class="text-center">All Blog</h1>
        </div>
        <div class="col-md-12">
            <a href="{{ route('blogs.create') }}" class="btn btn-primary">Add New Blog</a>
        </div>
    </div>
    <div class="row mt-4">
        @forelse($blogs as $blog)
            <div class="col-md-10">
                <div class="card text-center">
                    <div class="card-body">
                        @if (!empty($blog->image))
                            <img src="{{ asset('blog_images/' . $blog->image) }}" alt="Blog Image" class="img-fluid"
                                width="250">
                        @endif
                        @if(Auth::check() && Auth::user()->id == $blog->user_id)
                        <div class="dropdown" style="float: right;">
                            <div class="dot dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"></div>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('blogs.edit', $blog->id) }}">Edit</a></li>
                                {{-- <li><a class="dropdown-item delete-blod" data-id="{{ $blog->id }}"
                                        href="javascript:">Delete</a></li> --}}
                            </ul>
                        </div>
                        @endif
                        <h5 class="card-title">{{ $blog->title }}</h5>
                        <p class="card-text">{{ $blog->description }}</p>
                    </div>
                    <div class="card-footer text-body-secondary">
                        <div class="row">
                            <div class="col-md-4">
                                <a href="javascript;" class="like-btn" data-blog-id="{{ $blog->id }}"><i
                                        class="fa-regular fa-thumbs-up {{ $blog->auth_like_count == 1 ? 'text-success' : '' }}"
                                        style="font-size: 30px;"></i></a>
                                <span id="like-count-{{ $blog->id }}">{{ $blog->like_count }}</span> Likes
                            </div>
                            <div class="col-md-4">
                               <a href="#collapse1" class="nav-toggle"><i class="fa-regular fa-message" style="font-size: 30px;"></i></a>
                                <span>{{ $blog->comment_count->total_comments ?? 0 }}</span>
                            </div>
                            <div class="col-md-4">
                                {!! Share::page(url('/blogs/' . $blog->title))->facebook()->twitter()->whatsapp() !!}
                            </div>
                        </div>

                    </div>
                </div>

                <div class="card" id="collapse1">
                    <div class="card-body comments">
                        {{-- <h4>Display Comments</h4> --}}



                        @include('blog.commentDisplay', [
                            'comments' => $blog->comments,
                            'blog_id' => $blog->id,
                        ])



                        <hr />

                        <h4>Add comment</h4>

                        <form method="POST" action="{{ route('comments.store') }}">

                            @csrf

                            <div class="form-group">

                                <textarea class="form-control message" name="message"></textarea>

                                <input type="hidden" name="blog_id" value="{{ $blog->id }}" />

                            </div>

                            <div class="form-group">

                                <input type="submit" class="btn btn-success" value="Add Comment" />

                            </div>

                        </form>
                    </div>
                </div>


            </div>
        @empty
            <div class="col-md-12">
                <h2 class="text-center">No Blog Found</h2>
            </div>
        @endforelse

        {!! $blogs->withQueryString()->links('pagination::bootstrap-5') !!}
    </div>
@endsection

@section('extra-style')
    <style>
        .dot:after {
            content: '\2807';
            font-size: 30px;
        }

        #social-links {

            margin: 0 auto;

            max-width: 500px;

        }

        #social-links ul li {

            display: inline-block;

        }

        #social-links ul li a {

            padding: 15px;

            border: 1px solid #ccc;

            margin: 1px;

            font-size: 30px;

        }

        table #social-links {

            display: inline-table;

        }

        table #social-links ul li {

            display: inline;

        }

        table #social-links ul li a {

            padding: 5px;

            border: 1px solid #ccc;

            margin: 1px;

            font-size: 15px;

            background: #e3e3ea;

        }

        .liked {
            color: green;
            /* or any other color you desire */
            /* You can also change background color or any other style property */
        }
    </style>
@endsection


@section('extra-script')
    <script>
        $(document).ready(function() {
		  $('.nav-toggle').click(function(){
			//get collapse content selector
			var collapse_content_selector = $(this).attr('href');

			//make the collapse content to be shown or hide
			var toggle_switch = $(this);
			$(collapse_content_selector).toggle(function(){
			  if($(this).css('display')=='none'){
                                //change the button label to be 'Show'
				toggle_switch.html('<i class="fa-regular fa-message" style="font-size: 30px;"></i>');
			  }else{
                                //change the button label to be 'Hide'
				toggle_switch.html('<i class="fa-regular fa-message" style="font-size: 30px;"></i>');
			  }
			});
		  });

		});
        
        $('.delete-blog').click(function() {
            let id = $(this).data('id');
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('blogs.destroy', " +$(this).data('id')+") }}",
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            Swal.fire(
                                'Deleted!',
                                'Your blog has been deleted.',
                                'success'
                            )
                        },
                        error: function(error) {
                            Swal.fire(
                                'Error!',
                                'There was an error deleting your blog.',
                                'error'
                            )
                        }
                    });
                }
            })
        });

        $('.like-btn').click(function(e) {
            e.preventDefault();
            var blogId = $(this).data('blog-id');
            var likeBtn = $(this);
            $.ajax({
                type: 'POST',
                url: '/blogs/' + blogId + '/like',
                data: {
                    '_token': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    // Update UI to reflect the change in like count
                    var like = $('#like-count-' + blogId).text();
                    console.log(like);
                    // Change color of like button based on like/unlike status
                    if (data.message === 'liked') {
                        likeBtn.addClass('liked');
                        like++;
                        $('#like-count-' + blogId).text(like);

                    } else {
                        likeBtn.removeClass('liked');
                        // like--;
                        $('#like-count-' + blogId).text(like - 1);
                    }
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        });

        $('.comment-form').on('submit', function(e) {
    e.preventDefault();
    var form = $(this);
    var blogId = form.find('input[name="blog_id"]').val();
    var message = form.find('textarea[name="message"]').val();
    $.ajax({
        type: 'POST',
        url: "{{ route('comments.store') }}",
        data: {
            '_token': $('meta[name="csrf-token"]').attr('content'),
            'blog_id': blogId,
            'message': message
        },
        success: function(data) {
            // Update UI to reflect the new comment
            data.cmt.id++;
            form.closest('.comments').prepend('<strong>' + data.user.name + '</strong><p>' + data.message + '</p><form class="comment-form"><div class="form-group"><textarea type="text" name="message" class="form-control"></textarea><input type="hidden" name="blog_id" value="' + data.cmt.blog_id + '" /><input type="hidden" name="parent_id" value="' + data.cmt.id + '" /></div><div class="form-group"><input type="submit" class="btn btn-warning" value="Reply" /></div></form>');
            // Clear the form
            form.find('input[name="message"]').val('');
            form[0].reset();

        },
        error: function(xhr, status, error) {
            console.error(error);
        }
    });
});


    </script>
@endsection
