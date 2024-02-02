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
            <thead class="thead-dark">
                <tr>
                    <th>Ward</th>
                    <th>Assessment</th>
                    <th>Street Name</th>
                    <th>Image</th>
                    <!-- Other table headers -->
                </tr>
            </thead>
            <tbody>
                @foreach ($surveys as $survey)
                    <tr>
                        <td>{{ $survey->ward }}</td>
                        <td>{{ $survey->assessment }}</td>
                        <td>{{ $survey->road_name }}</td>
                        <td>
                            <!-- Display images related to the survey -->
                            @foreach ($survey->images as $image)
                                <img src="{{ public_path($image->image) }}" alt="" style="width: 150px; height: 150px;">
                            @endforeach
                        </td>
                        <!-- Display other columns accordingly -->
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>

</html>
