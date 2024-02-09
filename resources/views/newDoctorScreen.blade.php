<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Add Bootstrap CSS link -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Doctor Page</title>
    @include('header')
</head>

<style>
    body {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100vh;
        /* Ensure the page takes up the full viewport height */
        margin: 0;
        /* Remove default body margin */
    }

    .center-container {
        text-align: center;
    }
</style>


<body class="bg-gray-100">
    @extends('layouts.app')
    @section('content')
        <div class="p-3 container">
            @error('keyword')
                <div role="alert" id="alert-dialog" class="alert alert-danger alert-dismissible fade show flex-end">
                    Name or phone required<button id='close-alert' type="button" class="close" data-dismiss="alert"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button></div>
            @enderror
            <!--Waiting list , Completed Buttons and Search bar-->
            <div class="d-flex flex-column flex-md-row align-items-center justify-content-between">
                <!-- waiting List Button -->
                <div class="col-md-2 text-center">
                    <a href="{{ route('waiting.list') }}"><button class="btn btn-primary"
                            style="border-radius: 10px; background-image: linear-gradient(to bottom, #7900ff, #2b8ffc);box-shadow: 1px 5px 1px rgba(0, 0, 0, 0.1);">Waiting
                            List</button></a>
                </div>
                <!-- search Bar -->
                <div class="search-container text-center d-flex justify-content-md-center align-items-md-center">
                    <form action="{{ route('appointment_search') }}" method="POST" class="container">
                        @csrf
                        <div class="row">
                            <div class="col-md-8">
                                <input style="font-size: 12px;width:40dvh;" type="search" name="keyword" id="keyword" class="form-control" placeholder="Type Name or Phone Number" />
                            </div>
                            <div class="col-md-2">
                                <button style="height: 32px;" id="search-button" type="submit" class="btn btn-primary" title="search"> 
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                            <div class="col-md-2">
                                <a href="{{ route('home') }}">
                                    <button style="height: 32px;" id="search-button" type="button" class="btn btn-primary" title="reset">
                                        <i class="fas fa-repeat" ></i>
                                    </button>
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- Completed Button -->
                <div class="col-md-3 text-center">
                    <a href="{{ route('finished.list') }}"><button class="btn btn-success"
                            style="border-radius: 10px; background-image: linear-gradient(to bottom, #7900ff, #2b8ffc);box-shadow: 1px 5px 1px rgba(0, 0, 0, 0.1);">Completed</button></a>
                </div>
            </div>
            <!-- Appoitment management Box Area -->
            <div class="row h-auto">
                <div class="container">
                    <div class="row" style="background-color: #ecf1f5;border-radius: 40px;  max-width:100%;height:auto;">
                        <div id="myCarousel" class="carousel slide" data-ride="carousel" data-interval="false">
                            <div class="carousel-inner" style=" max-width:100%;height:auto;">
                                <form>
                                    <!-- NOW button  (this button only refresh the page)-->
                                    <div class="row my-3 mr-5">
                                        <div class="text-center">
                                            <button class="btn btn-info"
                                                style="border-radius: 30px; background-image: linear-gradient(to bottom, #4faafd, #34cfff);border:none;box-shadow: 1px 5px 1px rgba(0, 0, 0, 0.1);">NOW</button>
                                        </div>
                                    </div>
                                    <!-- next button, previous button and white background -->
                                    <div class="row justify-content-center align-items-center text-center"
                                        style=" max-width:100%;height:auto;">
                                        <!--  Previous Button -->
                                        <div class="col-md-2 text-center">
                                            <div class="row justify-content-center align-items-center text-center "
                                                href="#myCarousel" data-slide="prev">
                                                <button class="btn"
                                                    style="border-radius: 50%; width: 50px; height: 50px; background-color:#ffffff;box-shadow: 5px 5px 5px rgba(0, 0, 0, 0.3);">&larr;</button>
                                                <label for="previous">PREVIOUS</label>
                                            </div>
                                        </div>
                                        <!-- white Box -->
                                        <div class="col-md-8"
                                            style="background-color:#ffffff;border-radius: 40px;margin-bottom: 50px; max-width:100%;height:auto;">
                                            <?php $no = 0; ?>
                                            <!--Not avalilable appoiments-->
                                            @if (count($appoinments) === 0)
                                                <div class="row justify-content-center align-items-center text-center">
                                                    <div class="col">
                                                        <h3>No appointments available Today..</h3>
                                                    </div>
                                                </div>
                                                <!--Show available appoiments in that day-->
                                            @else
                                                @foreach ($appoinments as $p)
                                                    <?php $no++;
                                                    if ($no == 1) { ?>
                                                    <div class="carousel-item active">
                                                        <?php } else { ?>
                                                        <div class="carousel-item">
                                                            <?php } ?>
                                                            <div class="form-group" style="padding-top:50px;">
                                                                <!-- Appoiment Number show-->
                                                                <div class="row"
                                                                    style="background-color:#e6e9ec;border-radius: 40px;margin-left:30px;margin-right:30px;">
                                                                    <div class="col-md-4"
                                                                        style="background-color:#ecf1f5;border-radius: 50px; font-size: 18px;">
                                                                        <label for="appointmentNumber">Appointment
                                                                            Number</label>
                                                                    </div>
                                                                    <div class="col-md-8">
                                                                        <input type="text"
                                                                            value="{{ $p->appointment_no }}"
                                                                            class="form-control"
                                                                            style="background:transparent; outline: none;  border: none !important;"
                                                                            id="appointmentNumber"
                                                                            placeholder="Type your appointment number">
                                                                    </div>
                                                                </div>
                                                                <!-- Patient Name show-->
                                                                <div class="row"
                                                                    style="background-color:#e6e9ec;border-radius: 40px; margin-bottom:20px;margin-top:35px;margin-left:30px;margin-right:30px;">
                                                                    <div class="col-md-4"
                                                                        style="background-color:#ecf1f5;border-radius: 40px; font-size: 18px;">
                                                                        <label for="patientName">Patient
                                                                            Name</label>
                                                                    </div>
                                                                    <div class="col-md-8">
                                                                        <input type="text" value="{{ $p->patientname }}"
                                                                            class="form-control"
                                                                            style="background:transparent; outline: none;  border: none !important;"
                                                                            id="patientName"
                                                                            placeholder="Type your patient name">
                                                                    </div>
                                                                </div>
                                                                <!-- Data sent button (Enter button)-->
                                                                <div class="text-center" style=" font-size: 30px;">
                                                                    <a
                                                                        href="{{ route('view_patient_details', $p->patientid) }}">
                                                                        <button type="button" class="btn btn-secondary"
                                                                            style="border-radius: 10px; background-image: linear-gradient(to bottom, #4fdcd7, #52f3bc);border:none;box-shadow: 1px 5px 1px rgba(0, 0, 0, 0.1);">Enter</button>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                            <!--This div tag start in if condion active or not carousel-item-->
                                                        </div>
                                                @endforeach
                                            @endif
                                        </div>
                                        <!-- next Button -->
                                        <div class="col-md-2" style =" max-width:100%;height:auto;">
                                            <div class="row justify-content-center align-items-center text-center "
                                                href="#myCarousel" data-slide="next">
                                                <button class="btn"
                                                    style="border-radius: 50%; width: 50px; height: 50px; background-color:#ffffff;box-shadow: 5px 5px 5px rgba(0, 0, 0, 0.2);">&rarr;</button>
                                                <label for="next">NEXT</label>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @endsection
    @include('footer')
</body>

<!-- Carousel Function JavaScript code -->
<script>
    var myCarousel = $('#myCarousel');
    var itemFirst = myCarousel.find('.carousel-inner > .item:first-child');
    var itemLast = myCarousel.find('.carousel-inner > .item:last-child');
    var controlLeft = myCarousel.find('a.left.carousel-control');
    var controlRight = myCarousel.find('a.right.carousel-control');

    hideControl();

    myCarousel.on('slid.bs.carousel', function() {
        hideControl();
    });
    myCarousel.on('slide.bs.carousel', function() {
        showControl();
    });

    function hideControl() {
        if (itemFirst.hasClass('active')) {
            controlLeft.css('display', 'none');
        }
        if (itemLast.hasClass('active')) {
            controlRight.css('display', 'none');
            myCarousel.carousel('pause'); // stop from cycling through items
        }
    }

    function showControl() {
        if (itemFirst.hasClass('active')) {
            controlLeft.css('display', 'block');
        }
        if (itemLast.hasClass('active')) {
            controlRight.css('display', 'block');
        }
    }
</script>


</html>
