<!DOCTYPE html>
<html lang="en">

<head>
    <title>Bootstrap 5 Example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>

    <div class="table-responsive card p-3">
        <table class="table table-bordered">
            <thead class="thead-dark"> <!-- Use thead-light for a light background -->
                <tr>
                    <th>Ward</th>
                    <th>Assessment</th>
                    <th>Street Name</th>
                    <th>Image</th>
                    <!-- Other table headers -->
                </tr>
            </thead>
            <tbody>
                @foreach ($surveys as $item)
                    <tr>
                        <td>{{ $item->ward }}</td>
                        <td>{{ $item->assessment }}</td>
                        <td>{{ $item->road_name }}</td>
                        <td>
                            <!-- Display images related to the survey -->

                                <img src="{{ public_path($item->images) }}" alt="" style="width: 150px; height: 150px;">

                        </td>
                        <!-- Display other columns accordingly -->
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>

</html>
