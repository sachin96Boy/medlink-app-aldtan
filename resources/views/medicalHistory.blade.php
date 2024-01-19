<!DOCTYPE html>
<html lang="en">

<head> @include('header') <title></title>
</head>

<body class="g-sidenav-show  bg-gray-100">
    @extends('layouts.app')
    @section('content')
        <div class="container">
            <div class="row">
                <div class="col-1">
                </div>
        <a href="{{ url()->previous() }}" <button
                            style="margin-left: 2px; margin-bottom: 7px;border-radius: 30px; background-image: linear-gradient(to bottom, #7900ff, #2b8ffc); width:150px;"
                            type="button" class="btn  btn-info btn-sm"><b> Back </b></button></a>           
                <center>
                    <h5>Medical History</h5>
                </center>

                <div class="col-12 overflow-scroll" style="background-color:#d1dfec;">
                    <div class="card-body">
                        @include('medicalHistoryTable')
                    </div>

                </div>
            </div>
        </div>
    @endsection
    @include('footer')
</body>

</html>
