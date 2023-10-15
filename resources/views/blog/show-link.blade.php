<!DOCTYPE html>
<html>
<head>
    <title>Blog Link List</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Title/Link for Blog</h1>
            <table id="links-table" class="table table-bordered">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>URL</th>
                </tr>
                </thead>
                <tbody>
                @foreach($links as $link)
                    <tr>
                        <td>{{ $link->id }}</td>
                        <td>{{ $link->title }}</td>
                        <td>{{ $link->url }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<div id="links-container"> <!-- Add a container to display links -->
    <ul id="links-list">
        <!-- Links will be displayed here -->
    </ul>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        $('#links-table').DataTable();
    });
</script>
</body>
</html>
