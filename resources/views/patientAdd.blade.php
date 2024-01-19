<!DOCTYPE html>
<html lang="en">

<head> @include('header') <title></title>
    <style>
        .lsize{
            font-size: 14px;
        }

       
        </style>
</head>

<body class="g-sidenav-show  bg-gray-100">
    @extends('layouts.app')
    @section('content')
        <div class="container" >
            <div class="row">
               

                <a href="{{ route('patient_list.view') }}"> <button style="margin-left: 45px; border-radius: 30px; background-image: linear-gradient(to bottom, #7900ff, #2b8ffc);box-shadow: 1px 5px 1px rgba(0, 0, 0, 0.1);" type="button"
                        class="btn  btn-info btn-sm"><b> View Patient List</b></button></a>
                        
                        
                            
                    <div class="col-11" style="height: 350px;margin: 10px;background-color: #c6d9e6; max-width:100%;height:auto;">
                            <form action="{{ route('patient.add') }}" method="POST" class="row g-3 needs-validation">

                            @csrf
                            <div class="col-md-2">
                                <label for="validationCustom01" class="form-label lsize">Title</label>
                                <select style="font-size: 12px;" class="form-control" id="title" name="title">
                                    @foreach ($titles as $title)
                                        <option 
                                            value="{{ $title->id }}">{{ $title->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="validationCustom02" class="form-label lsize">Existing Family Name</label>
                                <select style=" font-size: 12px; background-color: #dbe9ee;" onchange="familyName()"
                                    style=" font-size: 12px;" class="form-control" id="family_names" name="family_names"
                                    rows="4">

                                                                      @foreach ($familyNames as $familyNames)
                                        <option 
                                            value="{{ $familyNames->family_name }}">{{ $familyNames->family_name }}</option>
                                    @endforeach

                                </select>

                            </div>
                            <div class="col-md-3">
                                <label for="validationCustom02" class="form-label lsize">New Family Name</label>
                                <input style=" font-size: 12px;" type="text" class="form-control" id="family_name" name="family_name"
                                    >
                            </div>
                            <div class="col-md-3">
                                <label for="validationCustom02" class="form-label lsize"> Name</label>
                                <input type="text" style=" font-size: 12px;"class="form-control" id="name"
                                    name="name" placeholder="Name of the Patient" >
                            </div>
                            <div class="col-md-2">
                                <label for="validationCustom02" class="form-label lsize">NIC</label>
                                <input style=" font-size: 12px;" type="text"
                                    class="form-control" id="nic" name="nic"
                                    placeholder="National Identity Card No" >
                            </div>

                            <div class="col-md-2">
                                <label for="validationCustom02" class="form-label lsize">Birthday</label>
                                <input style=" font-size: 12px;" type="date" class="form-control" id="birthday"
                                    name="birthday">
                            </div>
                            <div class="col-md-1">
                                <label for="validationCustom02" class="form-label lsize">Age</label>
                                <div class="row mb-1">
                                    <div class="col-sm-10">
                                        <input style=" font-size: 12px;" type="text" class="form-control" id="age"
                                            name="age" placeholder="Age in years" >
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label for="validationCustom02" class="form-label lsize">Gender</label>
                                <div class="row mb-1">
                                    <div class="col-sm-10">

                                        <div class="form-check form-check-inline">


                                            <input style=" font-size: 12px;" class="form-check-input" type="radio"
                                                id="male" name="gender" value="Male">

                                            <label style="font-size: 12px;"class="form-check-label"
                                                for="male">Male</label>


                                        </div>
                                        <div class="form-check form-check-inline">
                                            

                                         
                                            <input style=" font-size: 12px;" class="form-check-input" type="radio"
                                                id="female" name="gender" value="Female">
                                        
                                            <label style="font-size: 12px;"class="form-check-label"
                                                for="female">Female</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="validationCustom02" class="form-label lsize">Address</label>
                                <div class="row mb-1">
                                    <div class="col-sm-10">
                                        <input style=" font-size: 12px;" type="text" class="form-control"
                                            id="address" name="address" placeholder=" Address of the Patients"
                                            >
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label for="validationCustom02" class="form-label lsize">Mobile Number</label>
                                <div class="row mb-1">
                                    <div class="col-sm-10">
                                        <input style=" font-size: 12px;" type="text" class="form-control"
                                            id="mobile" name="mobile" placeholder="Mobile"
                                             >
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label for="validationCustom02" class="form-label lsize">E-mail </label>
                                <div class="row mb-1">
                                    <div class="col-sm-10">
                                        <input style=" font-size: 12px;" type="email" class="form-control"
                                            id="email" name="email" placeholder="Valid Email Address"
                                            >
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="validationCustom02" class="form-label lsize">Height</label>
                                <div class="row mb-1">

                                    <div class="col-sm-10">
                                        <label style="font-size: 12px;">Feets</label> <input style=" font-size: 12px; width: 50px;"
                                            type="number" style= "margin-left: 0px; " id="height_feets"
                                            name="height_feets" placeholder="Height in Feets"
                                            step="0.1" min="0"
                                            max="100">
                                        <label style="font-size: 12px;">Inches</label><input style=" font-size: 12px; width: 50px;"
                                            type="number" style= "margin-left: 50px;" id="height_inches"
                                            name="height_inches" placeholder="Inches"
                                            step="0.1" min="0"
                                            max="100">
                                        <label style="font-size: 12px;">Centimeters</label> <input
                                            style=" font-size: 12px; width: 50px;" type="number" style= "margin-left: 50px;"
                                            id="height_cen" name="height_cen" placeholder="Height in Centimeters"
                                            step="0.1" min="0"
                                            max="500">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label for="validationCustom02" class="form-label lsize">Weight</label>
                                <div class="row mb-1">
                                    <div class="col-sm-10">
                                        <input style=" font-size: 12px;" type="number" class="form-control"
                                            id="weight" name="weight" placeholder="Weight in KGs"
                                            >
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label for="validationCustom02" class="form-label lsize">Occupation</label>
                                <div class="row mb-1">
                                    <div class="col-sm-10">
                                        <input style=" font-size: 12px;" type="text" class="form-control"
                                            value="-" id="occupation" name="occupation"
                                            placeholder="Job Profession">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <!-- <div class="row mb-1 mt-4"> -->
                                    <button type="submit"
                                        style="margin-left: 45px; border-radius: 30px; background-image: linear-gradient(to bottom, #7900ff, #2b8ffc);box-shadow: 1px 5px 1px rgba(0, 0, 0, 0.1);"
                                        class="btn  btn-info btn-sm"><b> Add Patient</b></button>
                                <!-- </div> -->
                            </div>

                        </form>


            </div>
        </div>
        </div>
    @endsection
    @include('footer')
</body>
<script>
    function familyName() {
        let x = document.getElementById("family_names").value;
        document.getElementById('family_name').value = x;
    }
</script>

</html>
