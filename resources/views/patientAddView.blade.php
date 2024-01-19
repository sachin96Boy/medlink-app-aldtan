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
        <div class="container" style="margin-left: 180px;>
            <div class="row">
            
                
                @include('flash_message')
                <a href="{{ route('patient.list') }}"> <button style="margin-left: 45px; border-radius: 30px; background-image: linear-gradient(to bottom, #7900ff, #2b8ffc);box-shadow: 1px 5px 1px rgba(0, 0, 0, 0.1);" type="button"
                        class="btn  btn-info btn-sm"><b> View Patient List</b></button></a>

                <div class="col-12 overflow-scroll" style="height: 550px;">

                    <form action="{{ route('patient.add') }}" method="POST">
                        @csrf
                        <div class="row mb-3" style="margin-top: 10px;">
                            <label style="font-size: 12px;" for="title" class="col-sm-2 col-form-label">Title</label>
                            <div class="col-sm-10">
                                <select style=" font-size: 12px;" class="form-control" id="title" name="title" rows="4">
                                    @foreach ($titles as $title)
                                        <option value="{{ $title->id }}">{{ $title->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3" style="margin-top: 10px;">
                            <label style="font-size: 12px;"for="family_name" class="col-sm-2 col-form-label">Family
                                Name</label>
                            <div class="col-sm-10">
                                <select class="form-control" id="family_name" name="family_name" rows="4">
                                    <option value="" selected>-</option>
                                    @foreach ($familyNames as $familyName)
                                        <option value="{{ $familyName->family_name }}">{{ $familyName->family_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3 d-none">
                            <label style="font-size: 12px;"for="family_name_new" class="col-sm-2 col-form-label">Family Name
                                <span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <input  style=" font-size: 12px;" type="text" class="form-control" id="family_name_new" name="family_name_new"
                                    placeholder="Name of the Patient">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label style="font-size: 12px;"for="name" class="col-sm-2 col-form-label">Name <span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-10">

                                <input  style=" font-size: 12px;" type="text" class="form-control" id="name" name="name"
                                    placeholder="Name of the Patient" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label style="font-size: 12px;"for="birthday" class="col-sm-2 col-form-label">Date of Birth
                                <span class="text-danger">*</span></label>
                            <div class="col-sm-10">

                                <input  style=" font-size: 12px;" type="date" class="form-control" id="birthday" name="birthday" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label style="font-size: 12px;"for="age" class="col-sm-2 col-form-label">Age</label>
                            <div class="col-sm-10">

                                <input  style=" font-size: 12px;" type="text" class="form-control" id="age" name="age"
                                    placeholder="Age in years" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label style="font-size: 12px;"class="col-sm-2 col-form-label">Gender <span
                                    class="text-danger">*</span></label><br>
                            <div class="col-sm-10">

                                <div class="form-check form-check-inline">
                                    <input  style=" font-size: 12px;" class="form-check-input" type="radio" id="male" name="gender"
                                        value="Male">
                                    <label style="font-size: 12px;"class="form-check-label" for="male">Male</label>


                                </div>
                                <div class="form-check form-check-inline">
                                    <input  style=" font-size: 12px;" class="form-check-input" type="radio" id="female" name="gender"
                                        value="Female">
                                    <label style="font-size: 12px;"class="form-check-label" for="female">Female</label>
                                </div>
                            </div>

                        </div>

                        <div class="row mb-3">
                            <label style="font-size: 12px;"for="address" class="col-sm-2 col-form-label">Address</label>
                            <div class="col-sm-10">
                                <input  style=" font-size: 12px;" type="text" class="form-control" id="address" name="address"
                                    placeholder=" Address of the Patients" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label style="font-size: 12px;"for="mobile" class="col-sm-2 col-form-label">Mobile /
                                Whatsapp</label>
                            <div class="col-sm-10">

                                <input  style=" font-size: 12px;" type="text" class="form-control" id="mobile" name="mobile"
                                    placeholder="Mobile" required>
                            </div>
                        </div>


                        <div class="row mb-3">
                            <label style="font-size: 12px;"for="telephone"
                                class="col-sm-2 col-form-label">Telephone</label>
                            <div class="col-sm-10">

                                <input  style=" font-size: 12px;" type="text" class="form-control" id="telephone" name="telephone"
                                    placeholder="Telephone">
                            </div>
                        </div>



                        <div class="row mb-3">
                            <label style="font-size: 12px;"for="email" class="col-sm-2 col-form-label">Email</label>
                            <div class="col-sm-10">

                                <input  style=" font-size: 12px;" type="email" class="form-control" id="email" name="email"
                                    placeholder="Valid Email Address">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label style="font-size: 12px;"for="inputHeight" class="col-sm-2 col-form-label">
                                Height
                            </label>


                            <div class="col-sm-10">
                                <label style="font-size: 12px;">Feets</label> <input  style=" font-size: 12px;" type="number" style= "margin-left: 0px;" id="height_feets"
                                    name="height_feets" placeholder="Height in Feets" value="0" step="0.1"
                                    min="0" max="100">
                                    <label style="font-size: 12px;">Inches</label><input  style=" font-size: 12px;" type="number" style= "margin-left: 50px;" id="height_inches"
                                    name="height_inches" placeholder="Inches" value="0" step="0.1"
                                    min="0" max="100">
                                    <label style="font-size: 12px;">Centimeters</label> <input  style=" font-size: 12px;" type="number" style= "margin-left: 50px;" id="height_cen"
                                    name="height_cen" placeholder="Height in Centimeters" value="0" step="0.1"
                                    min="0" max="500">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label style="font-size: 12px;"for="weight" class="col-sm-2 col-form-label">Weight</label>
                            <div class="col-sm-10">

                                <input  style=" font-size: 12px;" type="number" class="form-control" id="weight" name="weight"
                                    placeholder="Weight in KGs" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label style="font-size: 12px;"for="nic" class="col-sm-2 col-form-label">NIC</label>
                            <div class="col-sm-10">

                                <input  style=" font-size: 12px;" type="text" class="form-control" id="nic" name="nic"
                                    placeholder="National Identity Card No">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label style="font-size: 12px;"for="occupation"
                                class="col-sm-2 col-form-label">Occupation</label>
                            <div class="col-sm-10">

                                <input  style=" font-size: 12px;" type="text" class="form-control" value="-" id="occupation" name="occupation"
                                    placeholder="Job Profession">
                            </div>
                        </div>


                        <button type="submit" style="margin-left: 45px; border-radius: 30px; background-image: linear-gradient(to bottom, #7900ff, #2b8ffc);box-shadow: 1px 5px 1px rgba(0, 0, 0, 0.1);" class="btn  btn-info btn-sm"><b> Add Patient</b></button>

                    </form>
                </div>
            </div>
        </div>
    @endsection
    @include('footer')
</body>

</html>
