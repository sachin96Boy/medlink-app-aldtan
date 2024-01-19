<!DOCTYPE html>
<html lang="en">

<head> 
    <title>Home</title>
    @include('header') 

</head>

<body class="g-sidenav-show bg-gray-100">
    @extends('layouts.app')
    @section('content')
        <div class="container-fuid">
            <div class="d-flex flex-column flex-md-row">
                <div class="col-12 col-md-6 mb-4 p-4">
                    <!-- First Tile -->
                    <a class="nav-link active" href="{{ route('waiting.list') }}">
                        <div class="card bg-flat-color-1 py-4"
                            style=" color:white; background-image: inner-;background-image: linear-gradient(#044b16, #d7d7ca);">
                            <div class="card-body pb-0">
                                <h4 class="mb-0" style="color:white;">
                                    <span class="count">{{ $waiting_list }}</span>
                                </h4>
                                <p class="text-white">Waiting List</p>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-12 col-md-6 mb-4 p-4">
                    <!-- Second Tile -->
                    <a class="nav-link active" href="{{ route('finished.list') }}">
                        <div class="card text-white bg-flat-color-1 py-4"
                            style="background-image: inner-;background-image: linear-gradient(#4b0443, #d7d7ca);">
                            <div class="card-body pb-0">
                                <h4 class="mb-0" style="color:white;">
                                    <span class="count">{{ $finished_list }}</span>
                                </h4>
                                <p class="text-white">Finished List</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <div class="d-flex flex-column flex-md-row">
                <div class="col-12 col-md-6 mb-4 p-4">
                    <!-- Third Tile -->
                    <a class="nav-link active" href="{{ route('patient_list.view') }}">
                        <div class="card text-white bg-flat-color-1 py-4"
                            style="background-image: inner-;background-image: linear-gradient(#18044b, #d7d7ca);">
                            <div class="card-body pb-0">
                                <h4 class="mb-0" style="color:white;">
                                    <span class="count">{{ $patient_list }}</span>
                                </h4>
                                <p class="text-white">Patients</p>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-12 col-md-6 mb-4 p-4">
                    <a class="nav-link active" href="{{ route('drugs_view') }}">
                        <div class="card text-white bg-flat-color-1 py-4"
                            style="background-image: inner-;background-image: linear-gradient(#b6121d, #d7d7ca);">
                            <div class="card-body pb-0 ">
                                <h4 class="mb-0" style="color:white;">
                                    <span class="count">{{ $drugs_list }}</span>
                                </h4>
                                <p class="text-white">Drugs</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

        </div>
    @endsection
    @include('footer')
</body>
<script></script>

</html>
