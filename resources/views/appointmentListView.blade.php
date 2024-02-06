<!DOCTYPE html>
<html lang="en">

<head>
    <title>Appointments</title>
    @include('header')

</head>

<body class="g-sidenav-show  bg-gray-100">
    @extends('layouts.app')
    @section('content')
        <div class="container">
            <div class="row text-center">
                {{-- <a href="{{ route('appointment_addview') }}"><button
                        style="margin-left: 45px; border-radius: 30px; background-image: linear-gradient(to bottom, #7900ff, #2b8ffc);box-shadow: 1px 5px 1px rgba(0, 0, 0, 0.1);"
                        type="button" class="btn  btn-info btn-sm"><b> Add Appointment</b></button></a> --}}
                <center>
                    <h5 >Appointment List</h5>
                </center >
                <div class="col-12 overflow-y-scroll" style="height: 50vh;">
                    <div class="card-body">
                        <table id="example1" class="table table-bordered">
                            <thead style="position: sticky; top: 0; z-index: 1;">
                                <tr style="font-size: 14px; background-color: #B4CAEB;">
                                    <th scope="col">Appointment No</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($appointment_list as $appointment => $val)
                                    <tr style="font-size: 13px;">
                                        <td>{{ $appointment->appointment_no }}</td>
                                        <td>{{ $appointment->date }}</td>
                                        <td>{{ $appointment->patientname }}</td>
                                        <td><?php if($appointment->status == 0){ ?>
                                            Active
                                            <?php  }else { ?>
                                            Finished
                                            <?php   } ?>
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
