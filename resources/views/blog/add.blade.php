@extends('layout.app')
@section('content')
    <div class="row mt-4">
        <div class="col-md-6">
            <h1 class="text-center">Add New Blog</h1>
        </div>
        <div class="col-md-6">
            <a href="{{ route('blogs.index') }}" class="btn btn-primary" style="float:right;">Back to Blog List</a>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-md-12">
            <form action="{{ route('blogs.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="form-group mb-4">
                    <label for="title">Title</label>
                    <input type="text" class="form-control" id="title" name="title" placeholder="Enter title" required>
                    @error('title')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group mb-4">
                    <label for="description">Description</label>
                    <textarea class="form-control" id="description" name="description" placeholder="Enter description" required></textarea>
                    @error('description')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group mb-4">
                    <label for="image">Image</label>
                    <input type="file" class="form-control" id="image" name="image" accept="image/*" onchange="loadFile(event)"
                    id="image">
                    @error('image')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                    <img id="output" class="img-fluid" width="250">
                </div>
                <button type="submit" class="btn btn-primary">Add Blog</button>
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