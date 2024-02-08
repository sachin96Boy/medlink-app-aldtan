<!DOCTYPE html>
<html lang="en">

<head> @include('header') <title></title>

</head>

<body class="g-sidenav-show  bg-gray-100">
    @extends('layouts.app')
    @section('content')
        <div class="container">
            <div class="row">
                <a href="{{ url()->previous() }}" <button
                    style="margin-left: 2px; margin-bottom: 7px;border-radius: 30px; background-image: linear-gradient(to bottom, #7900ff, #2b8ffc);width:150px;"
                    type="button" class="btn  btn-info btn-sm"><b> Back </b></button></a>
                <center>
                    <h5>Patient List by Family Name</h5>
                </center>
                <div class="col-12 overflow-scroll" style="height: 550px;">
                    <div class="card-body">
                        <div class="card-body">
                            <table id="example1" class="table table-bordered">
                                <thead>
                                    <tr style="font-size: 14px; background-color: #B4CAEB;">
                                        <th>ID</th>
                                        <th>Title</th>
                                        <th>Family Name</th>
                                        <th>Name</th>
                                        <th>Age</th>
                                        <th>Gender</th>
                                        <th>Address</th>
                                        <th>Mobile</th>
                                        <th>Action</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($patient_list as $patient)
                                        <tr style="font-size: 13px;">
                                            <td>{{ $patient->id }}</td>
                                            <td>{{ $patient->title }}</td>
                                            <td>{{ $patient->family_name }}</td>
                                            <td>{{ $patient->name }}</td>
                                            <td>{{ $patient->age }}</td>
                                            <td>{{ $patient->gender }}</td>
                                            <td>{{ $patient->address }}</td>
                                            <td>{{ $patient->mobile }}</td>
                                            <td class="project-actions">
                                                <center>
                                                    <a href="{{ route('view_patient_details', $patient->id) }}">
                                                        <button type="button" class="btn btn-secondary"
                                                            style="border-radius: 10px; background-image: linear-gradient(to bottom, #4fdcd7, #52f3bc);border:none;box-shadow: 1px 5px 1px rgba(0, 0, 0, 0.1);">Enter</button>
                                                    </a>
                                                </center>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    @endsection
    @include('footer')
</body>
<script>
    function add() {
        document.getElementById('name').value = "";
        var family_name = document.getElementById("family_name");
        family_name.selectedIndex = 0;
        var gender = document.getElementById("gender");
        gender.selectedIndex = 0;
    }
</script>

</html>
