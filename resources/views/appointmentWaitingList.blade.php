<!DOCTYPE html>
<html lang="en">

<head> @include('header') <title></title>

</head>

<body class="g-sidenav-show  bg-gray-100">
    @extends('layouts.app')
    @section('content')
        <div class="container">
            <div class="row">
                <a href="{{ route('home') }}"><button
                        style="margin-left: 45px; border-radius: 30px; background-image: linear-gradient(to bottom, #7900ff, #2b8ffc);box-shadow: 1px 5px 1px rgba(0, 0, 0, 0.1);"
                        type="button" class="btn  btn-info btn-sm"><b>Home</b></button></a>
                        

                <div class="col-12 overflow-y-scroll" style="height: 50vh;">
                    <div class="card-body">
                        <table id="example1" class="table table-bordered">
                            <thead>
                                <tr style="font-size: 14px; background-color: #B4CAEB;">
                                    <th scope="col">Appointment No</th>
                                    <th scope="col">Name</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($waiting_list as $waiting)
                                    <tr style="font-size: 13px;">
                                        <td>{{ $waiting->appointment_no }}</td>
                                        <td>{{ $waiting->patientname }}</td>
                                        <td><a href="{{ route('view_patient_details', $waiting->patient_id) }}">
                                                <button type="button" class="btn btn-secondary"
                                                    style="border-radius: 10px; background-image: linear-gradient(to bottom, #4fdcd7, #52f3bc);border:none;box-shadow: 1px 5px 1px rgba(0, 0, 0, 0.1);">Enter</button>
                                            </a>
                                            <a href="{{ route('view_patient_cancel', $waiting->appointment_no) }}">
                                                <button type="button" class="btn btn-secondary"
                                                    style="border-radius: 10px; background-image: linear-gradient(to bottom, #4fdcd7, #52f3bc);border:none;box-shadow: 1px 5px 1px rgba(0, 0, 0, 0.1);">Cancel</button>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    @endsection
    @include('footer')
</body>

</html>
