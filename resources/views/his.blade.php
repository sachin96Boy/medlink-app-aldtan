<!DOCTYPE html>
<html lang="en">
<head>
@include('header')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient History</title>
</head>
<body>
@extends('layouts.app')
    @section('content')
        <div class="container">

            <a href="{{ route('patient_list.view') }}" <button
                            style="margin-left: 2px; margin-bottom: 7px;border-radius: 30px; background-image: linear-gradient(to bottom, #7900ff, #2b8ffc);"
                            type="button" class="btn  btn-info btn-sm"><b> Back </b></button></a>
            <div class="row" style="margin-left: 50px;">
                <div class="col-sm-9 col-lg-6 p-4">
                    <a class="nav-link active" href="{{ route('investigationhistory', ['id' => $id]) }}">
                        <div class="card text-white bg-flat-color-1 h-30 p-3"
                            style="background-image: inner-;background-image: linear-gradient(#044b16, #d7d7ca);">
                            <div class="card-body pb-5">
                                <h4 class="mb-0" style="color: white;">
                                    <span class="count">Investigation History</span>
                                </h4>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-sm-9 col-lg-6 p-4">
                    <a class="nav-link active" href="{{ route('medicalhistory', ['id' => $id]) }}">
                        <div class="card text-white bg-flat-color-1 h-30 p-3"
                            style="background-image: inner-;background-image: linear-gradient(#4b0443, #d7d7ca);">
                            <div class="card-body pb-5">
                                <h4 class="mb-0" style="color: white;">
                                    <span class="count">Medical History</span>
                                </h4>
                              
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-sm-9 col-lg-6 p-4" >
                    <a class="nav-link active" href="{{ route('drughistory', ['id' => $id]) }}">
                        <div class="card text-white bg-flat-color-1 h-30 p-3"
                            style="background-image: inner-;background-image: linear-gradient(#18044b, #d7d7ca);">
                            <div class="card-body pb-5">
                                <h4 class="mb-0 my-0" style="color: white;">
                                    <span class="count">Drug History</span>
                                </h4>

                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-sm-9 col-lg-6 p-4">
                    <a class="nav-link active" href="{{ route('investigation_history', ['id' => $id]) }}">
                        <div class="card text-white bg-flat-color-1 h-30 p-3"
                            style="background-image: inner-;background-image: linear-gradient(#b6121d, #d7d7ca);">
                            <div class="card-body pb-5">
                                <h4 class="mb-0" style="color: white;">
                                    <span class="count">Patient Profile</span>
                                </h4>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    @endsection
    @include('footer')
</body>
</html>