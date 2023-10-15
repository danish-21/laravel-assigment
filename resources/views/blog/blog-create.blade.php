<!DOCTYPE html>
<html>
<head>
    <title>Create Blog</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h1>Create a New Blog</h1>           <a href="{{route('blogs.index')}}"> previous</a>

    <form method="post" action="{{ route('blogs.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label for="title">Title* (Unique):</label>
            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title"
                   value="{{ old('title') }}" required>
            @error('title')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="description">Description* (Min 10 words):</label>
            <textarea class="form-control @error('description') is-invalid @enderror" id="description"
                      name="description" required>{{ old('description') }}</textarea>
            @error('description')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="blog_images">Blog Images :</label>
            <input type="file" class="form-control-file" id="blog_images" name="blog_images[]" multiple>
        </div>

        <div class="form-group">
            <label for="tags">Tags / Category (Multiple):</label>
            <input type="text" class="form-control" id="tags" name="tags" value="{{ old('tags') }}">
        </div>

        <div class="form-group">
            <label for="links">Multiple Links and Title</label>
            <button type="button" class="btn btn-primary" id="add-link">+ Add Link</button>
            <div id="link-container"></div>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Create Blog</button>
        </div>
    </form>
</div>

<!-- Include Bootstrap JS and jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    $(document).ready(function () {
        var linkCount = 0;
        var linkContainer = $('#link-container');

        $('#add-link').click(function () {
            linkCount++;
            var linkField = `
                <div class="input-group mt-2" id="link-${linkCount}">
                    <input type="text" class="form-control" name="links[${linkCount}][title]" placeholder="Link Title">
                    <input type="text" class="form-control" name="links[${linkCount}][url]" placeholder="Link URL">
                    <div class="input-group-append">
                        <button type="button" class="btn btn-danger" id="remove-link-${linkCount}">Remove</button>
                    </div>
                </div>
                `;
            linkContainer.append(linkField);

            $(`#remove-link-${linkCount}`).click(function () {
                $(`#link-${linkCount}`).remove();
            });
        });
    });
</script>
</body>
</html>
