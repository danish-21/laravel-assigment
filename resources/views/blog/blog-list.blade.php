<!DOCTYPE html>
<html>
<head>
    <title>Blog List</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Blog List</h1>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('blogs.show') }}">Add Blog</a>
                    <a href="{{ route('dashboard') }}">Back</a>
                </li>
            </ul>
            <table id="blogs-table" class="table table-bordered">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>User Name</th>
                    <th>Tags</th>
                    <th>Action</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<!-- Create a hidden modal template for tags -->
<div id="tagsModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="tagsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tagsModalLabel">Tags for Specific Blog</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class= "modal-body">
                <ul id="tags-list">
                    <!-- Tags will be displayed here -->
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Create a hidden modal template for links -->
<div id="linksModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="linksModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="linksModalLabel">Links for Specific Blog</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <ul id="links-list">
                    <!-- Links will be displayed here -->
                </ul>
            </div>
        </div>
    </div>
</div>

<div id="deleteModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this blog?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirm-delete">Delete</button>
            </div>
        </div>
    </div>
</div>

<!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Include Bootstrap JS -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
{{--<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>--}}
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

{{--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>--}}
<script>
    $(document).ready(function() {
        console.log('Before DataTables initialization');
        $('#blogs-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('blogs.index') }}',
            columns: [
                { data: 'id', name: 'id' },
                { data: 'title', name: 'title' },
                { data: 'description', name: 'description' },
                { data: 'user.name', name: 'user.name' },
                {
                    data: 'id',
                    name: 'id',
                    render: function(data) {
                        return '<button class="view-tags-button btn btn-success" data-blog-id="' + data + '">View Tags</button>' +
                            '<button class="view-links-button btn btn-primary" data-blog-id="' + data + '">View Links</button>' ;
                    }
                },
                { data: 'id', name: 'id',

                    render: function (data) {
                        return '' +
                            '<a href="' + '{{ route('blogs.edit', ':id') }}'.replace(':id', data) + '" class="btn btn-primary">Edit</a>' +
                            '<button class="delete-blog-button btn btn-danger" data-blog-id="' + data + '">Delete</button>';
                    }
                },
            ]
        });

        console.log('After DataTables initialization');

        // Handle the click event for the "View Tags" button
        $('#blogs-table').on('click', '.view-tags-button', function() {
            var blogId = $(this).data('blog-id');
            loadTagsView(blogId);
        });

        // Handle the click event for the "View Links" button
        $('#blogs-table').on('click', '.view-links-button', function() {
            var blogId = $(this).data('blog-id');
            loadLinksView(blogId);
        });

        // Handle the click event for the "Delete" button
        $('#blogs-table').on('click', '.delete-blog-button', function() {
            var blogId = $(this).data('blog-id');
            // Open the delete confirmation modal
            $('#deleteModal').modal('show');

            // Handle delete confirmation
            $('#confirm-delete').off('click').on('click', function() {
                deleteBlog(blogId);
            });
        });
    });

    function loadTagsView(blogId) {
        $.ajax({
            url: '{{ route('blogs.tags-view', ['id' => ':blogId']) }}'.replace(':blogId', blogId),
            type: 'GET',
            success: function(data) {
                // Replace the modal content with the fetched data
                $('#tagsModal .modal-content').html(data);
                // Show the modal
                $('#tagsModal').modal('show');
            },
            error: function() {
                alert('An error occurred while loading tags.');
            }
        });
    }

    function loadLinksView(blogId) {
        $.ajax({
            url: '{{ route('blogs.links-view', ['id' => ':blogId']) }}'.replace(':blogId', blogId),
            type: 'GET',
            success: function(data) {
                // Replace the modal content with the fetched data
                $('#linksModal .modal-content').html(data);
                // Show the modal
                $('#linksModal').modal('show');
            },
            error: function() {
                alert('An error occurred while loading links.');
            }
        });
    }

    function deleteBlog(blogId) {
        // Send an AJAX request to delete the blog
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: '{{ route('blogs.destroy', ':id') }}'.replace(':id', blogId),
            type: 'POST',
            data: {
                _method: 'DELETE'
            },
            success: function() {
                // Close the delete confirmation modal
                $('#deleteModal').modal('hide');
                // Reload the DataTable to reflect the changes
                $('#blogs-table').DataTable().ajax.reload();
            },
            error: function() {
                alert('An error occurred while deleting the blog.');
            }
        });
    }

</script>
</body>
</html>
