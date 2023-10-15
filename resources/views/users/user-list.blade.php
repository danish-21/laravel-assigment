<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users List</title>

    <!-- Include DataTables CSS and JS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</head>
<body>

<div class="container mt-4">
    <h1>Users List</h1>
    <a href="{{ route('dashboard') }}">Back</a>

    <table id="users-table" class="table table-bordered">
        <thead>
        <tr>
            <th scope="col">Id</th>
            <th scope="col">Name</th>
            <th scope="col">Email</th>
            <th scope="col">Mobile</th>
            <th scope="col">DOB</th>
            <th scope="col">Gender</th>
            <th scope="col">Profile Image</th>
            <th scope="col">Blog Count</th>
            <th scope="col">Status</th>
            <th scope="col">Action</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
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
                Are you sure you want to delete this user?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirm-delete">Delete</button>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>

<!-- ... Your HTML code ... -->

<script>
    function deleteBlog(userId) {
        // Send an AJAX request to delete the user
        $.ajax({
            url: `/users/${userId}`,
            type: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function () {
                // Close the delete confirmation modal
                $('#deleteModal').modal('hide');
                // Reload the DataTable to reflect the changes
                $('#users-table').DataTable().ajax.reload();
            },
            error: function() {
                alert('An error occurred while deleting the blog.');
            }
        });
    }

    $(document).ready(function () {
        $('#users-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('users.index') }}',
            columns: [
                { data: 'id', name: 'id' },
                { data: 'name', name: 'name' },
                { data: 'email', name: 'email' },
                { data: 'mobile', name: 'mobile' },
                { data: 'dob', name: 'dob' },
                { data: 'gender', name: 'gender' },
                { data: 'profile_image', name: 'profile_image' },
                { data: 'blogs_count', name: 'blogs_count' },
                { data: 'status', name: 'status' },
                {
                    data: 'id',
                    name: 'id',
                    render: function (data) {
                        return '' +
                            '<a href="' + '{{ route('users.edit', ':id') }}'.replace(':id', data) + '" class="btn btn-primary">Edit</a>' +
                            '<button class="delete-user-button btn btn-danger" data-user-id="' + data + '">Delete</button>';
                    }
                },
            ],
        });

        $('#users-table').on('click', '.delete-user-button', function () {
            var userId = $(this).data('user-id');
            // Open the delete confirmation modal
            $('#deleteModal').modal('show');

            // Handle delete confirmation
            $('#confirm-delete').off('click').on('click', function () {
                deleteBlog(userId);
            });
        });
    });

</script>



</body>
</html>
