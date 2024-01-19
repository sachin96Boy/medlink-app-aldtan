
<!--///////////////////not using this code.this is a copy///////////////////////////////-->

<!DOCTYPE html>
<html lang="en">

<head>
    @include('header')
</head>

<body class="g-sidenav-show  bg-gray-100">
    @extends('layouts.app')
    @section('content')
        <div class="container">
            <div class="row">
                <div class=" mt3">
                    @include('sidebar')
                </div>
                <div class="col-12">
                    <div class="row mt-7">
                        <div class="col-md-4 text-left">
                            <a href="{{ route('waiting.list') }}"><button class="btn btn-primary" style="border-radius: 10px; background-image: linear-gradient(to bottom, #7900ff, #2b8ffc);box-shadow: 1px 5px 1px rgba(0, 0, 0, 0.1);">Waiting List</button></a>
                        </div>
                        <div class="col-md-4 text-center">
                            <h4>Search</h4>
                        </div>
                        <div class="col-md-4 text-right">
                            <a href="{{ route('finished.list') }}"><button class="btn btn-success" style="border-radius: 10px; background-image: linear-gradient(to bottom, #7900ff, #2b8ffc);box-shadow: 1px 5px 1px rgba(0, 0, 0, 0.1);margin-left: 250px;">Completed</button></a>
                        </div>
                    </div>

                    <form style="background-color: #ecf1f5;border-radius: 20px;">
                        <div class="text-center" style="padding-top: 20px;margin-bottom:20px;">
                            <?php echo '<button class="btn btn-info" style="border-radius: 10px; background-image: linear-gradient(to bottom, #4faafd, #34cfff);border:none;box-shadow: 1px 5px 1px rgba(0, 0, 0, 0.1);">NOW</button>'; ?>
                        </div>
                        <!-- White background div tag -->
                        <div class="row">
                            <div class="col-md-2 d-flex justify-content-center align-items-center">
                                <div class="row">
                                    <button class="btn"
                                        style="border-radius: 50%; width: 50px; height: 50px; background-color:#ffffff;box-shadow: 5px 5px 5px rgba(0, 0, 0, 0.3);">&larr;</button>
                                </div>
                                <div class="row" style="padding-top:85px; ">
                                    <label for="previous">PREVIOUS</label>
                                </div>
                            </div>
                            <div class="col-md-8" style="background-color:#ffffff;border-radius: 20px;">
                                <div class="carousel-item active">
                                    <div class="form-group" style="margin-top:15px;">
                                        <div class="row"
                                            style="background-color:#e6e9ec;border-radius: 20px;margin-left:12px;margin-right:12px;">
                                            <div class="col-md-4" style="background-color:#ecf1f5;border-radius: 20px;">
                                                <label for="appointmentNumber">Appointment Number</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" value=""class="form-control"
                                                    style="background:transparent; outline: none;  border: none !important;"
                                                    id="appointmentNumber" placeholder="Type your appointment number">
                                            </div>
                                        </div>
                                        <div class="row"
                                            style="background-color:#e6e9ec;border-radius: 20px; margin-bottom:15px;margin-top:8px;margin-left:12px;margin-right:12px;">
                                            <div class="col-md-4" style="background-color:#ecf1f5;border-radius: 20px;">
                                                <label for="patientName">Patient Name</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" value="" class="form-control"
                                                    style="background:transparent; outline: none;  border: none !important;"
                                                    id="patientName" placeholder="Type your patient name">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 d-flex justify-content-center align-items-center">
                                <div class="row">
                                    <a href=""> <button class="btn"
                                            style="border-radius: 50%; width: 50px; height: 50px; background-color:#ffffff;box-shadow: 5px 5px 5px rgba(0, 0, 0, 0.2);">&rarr;</button></a>
                                </div>
                                <div class="row" style="padding-top:85px;">
                                    <label for="next">NEXT</label>
                                </div>
                            </div>
                            <div class="text-center" style="padding-top: 20px;padding-bottom:20px;">
                                <a href="{{ route("view_patient_details", 2) }}">
                                    <button type="button" class="btn btn-secondary"
                                        style="border-radius: 10px; background-image: linear-gradient(to bottom, #4fdcd7, #52f3bc);border:none;box-shadow: 1px 5px 1px rgba(0, 0, 0, 0.1);">Enter</button>
                                </a>
                            </div>
                        </div>

                    </form>

                </div>
            </div>
        @endsection
        @include('footer')
</body>

</html>
