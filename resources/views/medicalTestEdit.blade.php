<!DOCTYPE html>
<html lang="en">

<head> @include('header') <title></title>
    <style>
        * {
            box-sizing: border-box;
        }

        .column {
            float: left;
            width: 50%;
            height: 90px;
            border-radius: 8px;
            border: 2px solid white;
            padding: 5px;
            margin-top: 10px;
            margin-bottom: 20px;
            color: #000102;
        }

        .row:after {
            content: "";
            display: table;
        }

        .flex-container-extend {
            display: flex;
            background-color: white;
            width: 100%;
            border-radius: 12px;
        }

        .flex-container-extend>div {
            color: black;
            margin: 5px;
            text-align: center;
            line-height: 45px;
            font-size: 18px;
            border-radius: 12px;
            border-style: none;
            /* border: 2px solid #d8dfe9; */
            height: 800px;
        }

        .flex-container-extend>div>div {
            color: black;
            text-align: center;
            height: 410px;
            font-size: 18px;
            border-radius: 12px;
            margin: 10px;

        }

        .container-fluid-extend {
            width: 100%;
            margin-left: auto;
            margin-right: auto;

        }

        .right {
            display: flex;
            justify-content: right;
            align-items: center;
            height: 50px;
        }
    </style>
</head>

<body class="g-sidenav-show  bg-gray-100">
    @extends('layouts.app')
    @section('content')
        <div class="container">
            <div class="row">
                <a href="{{ route('medical_test_view') }}"> <button style="margin-left: 45px; border-radius: 30px; background-image: linear-gradient(to bottom, #7900ff, #2b8ffc);box-shadow: 1px 5px 1px rgba(0, 0, 0, 0.1);" type="button"
                        class="btn  btn-info btn-sm"><b> View Medical Test List</b></button></a>
                        
                         

                <div class="col-12 overflow-y-scroll" style="height: 550px;">
                    @foreach ($medical_tests as $medical_test)
                    <form action="{{ route('medicalTestUpdate' ,$medical_test->id ) }}" method="POST">
                        @csrf
                        <div class="row mb-3">
                            <label style="font-size: 12px;"for="test_name" class="col-sm-2 col-form-label">Drugs
                                <span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <input  style=" font-size: 12px;" type="text" class="form-control" id="test_name" name="test_name" value="{{ $medical_test->test_name }}"  required>
                            </div>
                        </div>
                        <button type="submit" style="margin-left: 45px; border-radius: 30px; background-image: linear-gradient(to bottom, #7900ff, #2b8ffc);box-shadow: 1px 5px 1px rgba(0, 0, 0, 0.1);" class="btn  btn-info btn-sm"><b>Update</b></button>
                    </form>
                    @endforeach
                </div>
            </div>
        </div>
    @endsection
    @include('footer')
</body>

</html>
