@extends('layout.app')
@section('content')
    <div class="row mt-4">
        <div class="col-md-12">
            <h1 class="text-center">{{ $blog->title }}</h1>
        </div>
        <div class="col-md-12">
            <a href="{{ route('blogs.index') }}" class="btn btn-primary">Back</a>
        </div>
    </div>
    <div class="row mt-4">

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
                                {{-- <li><a class="dropdown-item delete-blod"  data-id="{{ $blog->id }}" href="javascript:">Delete</a></li> --}}
                            </ul>
                        </div>
                        @endif
                        <h5 class="card-title">{{ $blog->title }}</h5>
                        <p class="card-text">{{ $blog->description }}</p>
                    </div>
                    <div class="card-footer text-body-secondary">
                        {!! Share::page(url('/blogs/'. $blog->title))->facebook()->twitter()->whatsapp() !!}
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h4>Display Comments</h4>



                        @include('blog.commentDisplay', [
                            'comments' => $blog->comments,
                            'blog_id' => $blog->id,
                        ])



                        <hr />

                        <h4>Add comment</h4>

                        <form method="post" action="{{ route('comments.store') }}">

                            @csrf

                            <div class="form-group">

                                <textarea class="form-control" name="message"></textarea>

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
    </div>
@endsection

@section('extra-style')
    <style>
        .dot:after {
            content: '\2807';
            font-size: 30px;
        }
    </style>
@endsection

@section('extra-script')
    <script>

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
                    url: "{{ route('blogs.destroy'," +$(this).data('id')+") }}",
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
    </script>
@endsection

