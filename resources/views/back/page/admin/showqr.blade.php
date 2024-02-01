@extends('back.layout.page-layout')


<div class="table-responsive card p-3">
    <table class="table table-bordered">
        <thead class="thead-dark"> <!-- Use thead-light for a light background -->
            <tr>
                <th>Ward</th>
                <th>Assessment</th>
                <th>Street Name</th>
                <!-- Other table headers -->
            </tr>
        </thead>
        <tbody>
            @foreach($surveys as $item)
                <tr>
                    <td>{{ $item->ward }}</td>
                    <td>{{ $item->assessment }}</td>
                    <td>{{ $item->road_name }}</td>
                    <!-- Display other columns accordingly -->
                </tr>
            @endforeach
        </tbody>
    </table>
</div>


