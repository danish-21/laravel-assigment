<!DOCTYPE html>
<html>
<head>
    <title>Blog Tag List</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Blog Tag</h1>
            <table id="tags-table" class="table table-bordered">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Tag Name</th>
                </tr>
                </thead>
                <tbody>
                @foreach($tags as $tag)
                    <tr>
                        <td>{{ $tag->id }}</td>
                        <td>{{ $tag->name }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<div id="tags-container"> <!-- Add a container to display tags -->
    <ul id="tags-list">
        <!-- Tags will be displayed here -->
    </ul>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        $('#tags-table').DataTable();
    });
</script>
</body>
</html>
