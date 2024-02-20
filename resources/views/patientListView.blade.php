<!DOCTYPE html>
<html lang="en">

<head>
    <title>Patients</title>
    @include('header')
</head>

<body class="g-sidenav-show  bg-gray-100">
    @extends('layouts.app')
    @section('content')
        <div class="container">
            <div class="row">

                <center>
                    <h4>PATIENT LIST</h4>
                </center>
                <form action="{{route('patient_list.search')}}" method="post">
                    @csrf
                    <div class="container text-center">
                        @error('keyword')
                            <div role="alert" id="alert-dialog"
                                class="alert m-2 rounded alert-danger alert-dismissible fade show flex-end">
                                {{ $message }}<button id='close-alert' type="button" class="close" data-dismiss="alert"
                                    aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button></div>
                        @enderror
                        <div class="d-flex flex-column flex-md-row align-items-center justify-content-start">
                            <div class="d-flex  col-md-6 text-start" style="margin-left:-30px;" >
                                <input style=" font-size: 12px;" type="text" class="form-control" id="keyword"
                                    name="keyword" placeholder="Keyword for Search" value="">

                            </div>
                            <div class="col-3 d-flex gap-2 mt-2 align-items-center">
                                <button type="submit"
                                    style=" border-radius: 30px; background-image: linear-gradient(to bottom, #7900ff, #2b8ffc);box-shadow: 1px 5px 1px rgba(0, 0, 0, 0.1);"
                                    class="btn  btn-info btn-sm"><b>Search</b></button>
                                <a href="{{ route('patient_list.view') }}"><button onclick="add();" type="button"
                                        name="clear"
                                        style=" border-radius: 30px; background-image: linear-gradient(to bottom, #7900ff, #2b8ffc);box-shadow: 1px 5px 1px rgba(0, 0, 0, 0.1);"
                                        class="btn  btn-info btn-sm"><b>Clear</b></button></a>
                            </div>
                            <div class="col-3 d-flex gap-2 mt-2 justify-content-end">
                                <a href="{{route('patientaddview')}}"><button style="margin-left: 45px; border-radius: 30px; background-image: linear-gradient(to bottom, #7900ff, #2b8ffc);box-shadow: 1px 5px 1px rgba(0, 0, 0, 0.1);"  type="button" class="btn  btn-info btn-sm"><b> Add Patient</b></button></a>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="col-12 overflow-scroll my-2" style="height: 65vh; background-color:#d1dfec;">
                    <div class="card-body">
                        @include('patientList')
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
