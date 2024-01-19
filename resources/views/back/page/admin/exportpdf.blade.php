<!DOCTYPE html>
<html>
<head>
    <title>Survey Report</title>
    <style>
        /* Define your styles for the PDF here */
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
        /* Define styles for images */
        .survey-image {
            max-width: 100px; /* Set a maximum width for the displayed images */
            height: auto;
        }
    </style>
</head>
<body>
    <h1>Survey Report</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Assessment</th>
                <th>Usage</th>
                <th>Owner name</th>
                <th>Mobile</th>
                <th>Floor</th>
                <th>Images</th>                
            </tr>
        </thead>
        <tbody>
            @foreach($surveys as $survey)
            <tr>
                <td>{{ $survey->id }}</td>
                <td>{{ $survey->assessment }}</td>
                <td>{{ $survey->building_usage }}</td>
                <td>{{ $survey->owner_name }}</td>
                <td>{{ $survey->mobile }}</td>
                <td>{{ $survey->number_of_floor }}</td>
                <td>
                    <!-- Display images related to the survey -->
                    @foreach($survey->images as $image)
                        <img src="{{ public_path($image->image) }}" alt="" style="width: 150px; height: 150px;">
                    @endforeach
                </td>
            </tr>
            @endforeach
            </tr>
        </tbody>
    </table>
</body>
</html>
