@extends('layout.app')
@section('content')
    <div class="row mt-4">
        <div class="col-md-6">
            <h1 class="text-center">Edit Blog</h1>
        </div>
        <div class="col-md-6">
            <a href="{{ route('blogs.index') }}" class="btn btn-primary" style="float:right;">Back to Blog List</a>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-md-12">
            <form action="{{ route('blogs.update', $blog->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" class="form-control" id="title" name="title" value="{{ $blog->title }}" required>
                    @error('title')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control" id="description" name="description" required>{{ $blog->description }}</textarea>
                    @error('description')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="image">Image</label>
                    <input type="file" class="form-control" id="image" name="image" accept="image/*" onchange="loadFile(event)"
                    id="image">
                    <img src="{{ asset('blog_image/' . $blog->image) }}" alt="" width="100">
                    @error('image')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                    <img id="output" class="img-fluid" width="250">
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
@endsection

@section('extra-script')
    <script>
        var loadFile = function(event) {
            var reader = new FileReader();
            reader.onload = function() {
                var output = document.getElementById('output');
                output.src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        };
    </script>
@endsection