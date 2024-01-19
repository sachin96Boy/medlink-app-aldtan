<!DOCTYPE html>
<html lang="en">

<head>
    @include('header')
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Page</title>
    <!-- Add Bootstrap CSS link -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="path/to/bootstrap.css" rel="stylesheet">
</head>

<body class="g-sidenav-show  bg-gray-100">
    @extends('layouts.app')
    @section('content')
    <div class="container">
        <div class="row">
            
            <div class="container">
                <div class="row mt-2">
                    <div class="col-md-4 text-left">
                        <a href="{{ route('waiting.list') }}"><button class="btn btn-primary" style="border-radius: 10px; background-image: linear-gradient(to bottom, #7900ff, #2b8ffc);box-shadow: 1px 5px 1px rgba(0, 0, 0, 0.1);margin-left: 100px;">Waiting
                                List</button></a>
                    </div>

                    <div class="col-md-4 text-center">
                        <form action="{{ route('appointment_search') }}" method="POST">
                            @csrf
                            <div class="col-12 text-center p-0 align-self-start">
                                <div class="input-group">
                                    <input style="font-size: 12px;" type="search" name="keyword" id="keyword" class="form-control" placeholder="Type Name or Phone Number" />
                                    <button style="height: 32px;" id="search-button" type="submit" class="btn btn-primary">
                                        <i class="fas fa-search"></i>
                                    </button>
                                    <a href="{{ route('home') }}">
                                        <button style="height: 32px;" id="search-button" type="button" class="btn btn-primary">
                                            <i class="fas fa-repeat"></i>
                                        </button>
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="col-md-4 text-right">
                        <a href="{{ route('finished.list') }}"><button class="btn btn-success" style="border-radius: 10px; background-image: linear-gradient(to bottom, #7900ff, #2b8ffc);box-shadow: 1px 5px 1px rgba(0, 0, 0, 0.1);margin-left: 50px;">Completed</button></a>
                    </div>
                </div>

            </div>
            <div id="myCarousel" class="carousel slide" data-ride="carousel" data-interval="false">
                <div class="carousel-inner">
                    <form style="background-color: #ecf1f5;border-radius: 40px;">
                        <div class="text-center" style="padding-top: 40px;margin-bottom:40px;">
                            <?php echo '<button class="btn btn-info" style="border-radius: 30px; background-image: linear-gradient(to bottom, #4faafd, #34cfff);border:none;box-shadow: 1px 5px 1px rgba(0, 0, 0, 0.1);">NOW</button>'; ?>
                        </div>
                        <!-- White background div tag -->
                        <div class="row">
                            <div class="col-md-2 d-flex justify-content-center align-items-center">
                                <div class="row" href="#myCarousel" data-slide="prev">
                                    <?php echo '<button class="btn" style="border-radius: 50%; width: 50px; height: 50px; background-color:#ffffff;box-shadow: 5px 5px 5px rgba(0, 0, 0, 0.3);">&larr;</button>'; ?>
                                </div>
                                <div class="row" href="#myCarousel" data-slide="prev" style="padding-top:85px; ">
                                    <label for="previous">PREVIOUS</label>
                                </div>
                            </div>


                            <div class="col-md-8" style="background-color:#ffffff;border-radius: 40px;margin-bottom: 50px;">
                                <?php $no = 0; ?>
                                @if ($appoinments == null)
                                <div class="carousel-item">
                                    <div class="form-group" style="padding-top:50px;">
                                        <div class="row" style="background-color:#e6e9ec;border-radius: 40px;margin-left:30px;margin-right:30px;">
                                            <div class="col-md-4" style="background-color:#ecf1f5;border-radius: 50px; font-size: 18px;">
                                                <label for="appointmentNumber">Appointment Number</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" style="background:transparent; outline: none;  border: none !important;" id="appointmentNumber" placeholder="Type your appointment number">
                                            </div>
                                        </div>
                                        <div class="row" style="background-color:#e6e9ec;border-radius: 40px; margin-bottom:20px;margin-top:35px;margin-left:30px;margin-right:30px;">
                                            <div class="col-md-4" style="background-color:#ecf1f5;border-radius: 40px; font-size: 18px;">
                                                <label for="patientName">Patient Name</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" style="background:transparent; outline: none;  border: none !important;" id="patientName" placeholder="Type your patient name">
                                            </div>
                                        </div>
                                        <div class="text-center" style=" font-size: 30px;">
                                            <a href="">
                                                <button type="button" class="btn btn-secondary" style="border-radius: 10px; background-image: linear-gradient(to bottom, #4fdcd7, #52f3bc);border:none;box-shadow: 1px 5px 1px rgba(0, 0, 0, 0.1);">Enter</button>
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                @else
                                @foreach ($appoinments as $p)
                                <?php $no++;
                                if ($no == 1) { ?>
                                    <div class="carousel-item active">
                                    <?php } else { ?>
                                        <div class="carousel-item">
                                        <?php } ?>
                                        <div class="form-group" style="padding-top:50px;">
                                            <div class="row" style="background-color:#e6e9ec;border-radius: 40px;margin-left:30px;margin-right:30px;">
                                                <div class="col-md-4" style="background-color:#ecf1f5;border-radius: 50px; font-size: 18px;">
                                                    <label for="appointmentNumber">Appointment Number</label>
                                                </div>
                                                <div class="col-md-8">
                                                    <input type="text" value="{{ $p->appointment_no }}" class="form-control" style="background:transparent; outline: none;  border: none !important;" id="appointmentNumber" placeholder="Type your appointment number">
                                                </div>
                                            </div>
                                            <div class="row" style="background-color:#e6e9ec;border-radius: 40px; margin-bottom:20px;margin-top:35px;margin-left:30px;margin-right:30px;">
                                                <div class="col-md-4" style="background-color:#ecf1f5;border-radius: 40px; font-size: 18px;">
                                                    <label for="patientName">Patient Name</label>
                                                </div>
                                                <div class="col-md-8">
                                                    <input type="text" value="{{ $p->patientname }}" class="form-control" style="background:transparent; outline: none;  border: none !important;" id="patientName" placeholder="Type your patient name">
                                                </div>
                                            </div>
                                            <div class="text-center" style=" font-size: 30px;">
                                                <a href="{{ route('view_patient_details', $p->patientid) }}">
                                                    <button type="button" class="btn btn-secondary" style="border-radius: 10px; background-image: linear-gradient(to bottom, #4fdcd7, #52f3bc);border:none;box-shadow: 1px 5px 1px rgba(0, 0, 0, 0.1);">Enter</button>
                                                </a>
                                            </div>
                                        </div>
                                        </div>
                                        @endforeach
                                        @endif
                                        <!--Add new carousel-item-->
                                    </div>
                                    <div class="col-md-2 d-flex justify-content-center align-items-center">
                                        <div class="row" href="#myCarousel" data-slide="next">
                                            <?php echo '<button class="btn" style="border-radius: 50%; width: 50px; height: 50px; background-color:#ffffff;box-shadow: 5px 5px 5px rgba(0, 0, 0, 0.2);">&rarr;</button>'; ?>
                                        </div>
                                        <div class="row" href="#myCarousel" data-slide="next" style="padding-top:85px;">
                                            <label for="next">NEXT</label>
                                        </div>
                                    </div>

                            </div>


                    </form>
                </div>
            </div>
            @endsection
            @include('footer')
            <script>
                var myCarousel = ('#myCarousel');
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
            <!-- Add Bootstrap JS and jQuery -->
            <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>