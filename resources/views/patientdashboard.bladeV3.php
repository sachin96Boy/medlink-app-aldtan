<!DOCTYPE html>
<html lang="en">

<head> @include('header') <title>Doctor Screen</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script>
        $(function() {
            $("#next_visit_date").datepicker({
                dateFormat: 'yy-mm-dd'
            });
        });
    </script>


    <style>
        .dropbtn {
            background-color: #04AA6D;
            color: white;
            padding: 2px;
            font-size: 12px;
            border: none;
            cursor: pointer;
        }

        .dropbtn:hover,
        .dropbtn:focus {
            background-color: #3e518e;
        }

        #myInput {
            box-sizing: border-box;
            background-image: url('searchicon.png');
            background-position: 14px 12px;
            background-repeat: no-repeat;
            font-size: 12px;
            padding: 14px 20px 12px 45px;
            border: none;
            border-bottom: 1px solid #ddd;
        }

        #myInput:focus {
            outline: 3px solid #ddd;
        }

        .dropdown {
            position: relative;
        }

        .dropdown-content {
            position: absolute;
            background-color: #f6f6f6;
            overflow: auto;
            border: 1px solid #ddd;
            z-index: 1;
        }

        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
        }

        .dropdown a:hover {
            background-color: #ddd;
        }

        .show {
            display: block;
        }




        .flex-container-extend {
            display: flex;
            background-color: #b2d8e5;
            width: 100%;
            border-radius: 12px;
        }

        .flex-container-extend>div {
            color: black;
            text-align: center;
            line-height: 9px;
            font-size: 12px;
            border-radius: 12px;
            height: 400px;
        }

        .flex-container-extend>div>div {
            color: black;
            text-align: center;
            height: 400px;
            font-size: 12px;
            border-radius: 12px;
            margin: 1px;

        }

        .container-fluid-extend {
            width: 100%;


        }

        .card {
            box-shadow: none;
            -webkit-box-shadow: none;
            -moz-box-shadow: none;
            -ms-box-shadow: none
        }


        p {
            font-size: 0.875rem;
            margin-bottom: .2rem;
            line-height: 0.8rem
        }


        .table,
        .jsgrid .jsgrid-table {
            width: 100%;
            max-width: 100%;
            margin-bottom: 0rem;
            background-color: transparent
        }




        .container-xxl {
            margin-top: 0px;
        }

        .popup {
            display: none;
            position: fixed;
            height: 20dvh;
            width: 90dvh;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            z-index: 1000;
        }

        /* Styles for the close button */
        .close {
            position: absolute;
            top: 10px;
            right: 10px;
            g cursor: pointer;
        }

        #selectedItems {
            font-size: 12px;
        }




        */
    </style>
</head>
<?php

if(isset($_GET["submit"])){

$servername = "89.117.157.3";
$username = "u991943496_medlink123";
$password = "Aldtan2023@medlink";
$dbname = "u991943496_medlink";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$newUserId= $_GET["newUserId"];
$oldUserId=$_GET["oldUserId"];

$select_finger_query = "SELECT fingerprint_id FROM patients WHERE id = $newUserId";

// Execute the query
$result = $conn->query($select_finger_query);

if ($result) {
    // Fetch the result as an associative array
    $row = $result->fetch_assoc();

    // Check if there is a result
    if ($row) {
        $fingerprint_data = $row['fingerprint_id'];
       //Fingerprint ID captured
    } else {
        echo "No matching record found for user $newUserId";
    }
} else {
    echo "Error: " . $select_finger_query . "<br>" . $conn->error;
}


$select_query = "SELECT finger2, finger3, finger4, finger5 FROM patients WHERE id = $oldUserId";

// Execute the query
$result = $conn->query($select_query);

if ($result) {
    // Fetch the result as an associative array
    $row = $result->fetch_assoc();

    // Check each column for NULL value
    if ($row['finger2'] === null) {
        $insert_query = "UPDATE patients SET finger2='$fingerprint_data' WHERE id = $oldUserId";
    } elseif ($row['finger3'] === null) {
        $insert_query = "UPDATE patients SET finger3='$fingerprint_data' WHERE id = $oldUserId";
    } elseif ($row['finger4'] === null) {
        $insert_query = "UPDATE patients SET finger4='$fingerprint_data' WHERE id = $oldUserId";
    } elseif ($row['finger5'] === null) {
        $insert_query = "UPDATE patients SET finger5='$fingerprint_data' WHERE id = $oldUserId";
    } else {
        // All columns are filled
        echo '<script>alert("User has saved all five fingers.");</script>';
    }

    // Execute the insert query if available
    if (isset($insert_query)) {
        if ($conn->query($insert_query) === TRUE) {
            //Fingerprint data inserted successfully
        } else {
            echo "Error: " . $insert_query . "<br>" . $conn->error;
        }
    }
} else {
    echo "Error: " . $select_query . "<br>" . $conn->error;
}


$update_query = "UPDATE patients SET fingerprint_id='', status='1' WHERE id = $newUserId";

// Execute the update query
if ($conn->query($update_query) === TRUE) {
   // Record updated successfully for user $newUserId
} else {
    echo "Error updating record: " . $conn->error;
}


// Update user ID in the appointment table
$appointmentUpdateQuery = "UPDATE appoinments SET patient_id = $oldUserId WHERE patient_id = $newUserId";
if ($conn->query($appointmentUpdateQuery) === TRUE) {
    ?>
<script>
    alert("User ID updated successfully")
    window.location.href = "https://medlink.aldtan.xyz/home"
</script>
<?php
} else {
   ?>
<script>
    alert("error user update")
</script><?php
}



// Close connection
$conn->close();
}
?>

<body class="g-sidenav-show  bg-gray-100">
    @extends('layouts.app')
    @section('content')
    
        <div class="container-xxl">
            <div class="row">
                <div>
                    @include('sidebar')
                </div>
                @foreach ($patientDtl as $p)

                <div class="container-xxl">
                    <div class="row">
                        <div class="col-9">
                            <form action="{{ route('patient_list_by_family_name.search') }}" method="POST">
                                @csrf
                                <input type="hidden" id="family_name" name="family_name"
                                    value="{{ $p->family_name }}">
                                <input type="hidden" id="currentPatientId" name="currentPatientId"
                                    value="{{ $p->id }}">
                                <button type="submit"
                                    style="margin-left: 170px; border-radius: 15px; margin-bottom: 0px;  background-color:#8ff397; background-image: linear-gradient(to bottom, #ff0055, #fc2ba8); "
                                    class="btn  btn-primary btn-sm "><b> {{ $p->family_name }}</b></button>
                            </form>
                        </div>
                        <div class="col-1">
                        </div>
                        <div class="col-2">
                            <b>{{ date('Y-m-d') }}</b>

                            <b><span id="myDiv"></b> <i class="fa fa-bell-o"
                                style="font-size:24px"></i></span>
                        </div>
                    </div>
                </div>
                <div class="col-12" style="margin-left: 60px;">
                    <div class="col-sm-12"
                        style=" background-color: white;  border-radius: 12px;  padding-top: 12px; color: black;">
                            <div class="popup" id="updatePopup">
                                <!-- Close button -->
                                <span class="close" id="closePopup">&times;</span>

                                <form action="#" method="GET" onsubmit="return validateForm()">
                                    @csrf
                                    <input type="hidden" name="newUserId" value="{{ $p->id }}"><br>
                                    <div class="col">
                                        <label>Please select old name:</label>
                                        <div class="row">
                                            <div class="col-9">
                                                <select style="font-size: 12px;" class="form-control" id="name"
                                                    name="oldUserId">
                                                    <option value="">Select an option</option>
                                                    @foreach ($names as $id => $name)
                                                        <option value="{{ $id }}">{{ $name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-3">
                                                <input type="submit" name="submit" value="Update User"
                                                    style="border-radius: 15px; margin-bottom: 0px; background-image: linear-gradient(to bottom, #7900ff, #2b8ffc);color:#FFFFFF;">
                                            </div>
                                        </div>
                                    </div>
                                </form>

                                <script>
                                    function validateForm() {
                                        var selectedValue = document.getElementById("name").value;

                                        if (selectedValue === "") {
                                            alert("Please select a value");
                                            return false;
                                        }

                                        return true;
                                    }
                                </script>

                            </div>
                            <form action="{{ route('appoinmentfinished', $p->id) }}" method="POST">
                                @csrf
                                <input type="hidden" id="patient_id" name="patient_id" value="{{ $p->id }}">

                                <div class="container h-1">
                                    <div class="d-flex justify-content-around h-1">
                                        <div class="p-1">
                                            <i class="fa fa-user-o" style="font-size:16px;">
                                                <span> patient <b>{{ $p->name }}</b></i>
                                            <span>
                                        </div>
                                        <div class="p-1">
                                            
                                            <a href="{{ route('investigationhistory', ['id' => $p->id]) }}">
                                            <button type="button" class="btn btn-primary btn-sm"
                                                style="border-radius: 15px; margin-bottom: 0px;  background-color:#978FF3; background-image: linear-gradient(to bottom, #7900ff, #2b8ffc); "><b>
                                                    Demogrphic Info</b></button></a>
                                        </div>
                                        <div class="p-1">
                                            <a href="{{ route('medicalhistory', ['id' => $p->id]) }}">
                                            <button type="button" class="btn btn-primary btn-sm "
                                                style="border-radius: 15px; margin-bottom: 0px; background-image: linear-gradient(to bottom, #7900ff, #2b8ffc);"><b>
                                                    Medical History</b></button></a>
                                        </div>

                                        <div class="p-1"> <a href="{{ route('drug_history') }}"
                                            <button class="btn btn-primary btn-sm "
                                                style="border-radius: 15px;margin-bottom: 0px; background-image: linear-gradient(to bottom, #7900ff, #2b8ffc);"><b>
                                                    Drugs history </b></button></a>
                                        </div>
                                        <div class="p-1"><a href="{{ route('investigation_history') }}"
                                            <button disabled class="btn btn-primary btn-sm "
                                                style="border-radius: 15px; margin-bottom: 0px; background-image: linear-gradient(to bottom, #7900ff, #2b8ffc);">
                                                <b>Investigation History</b></button></a>
                                        </div>
                                        <div class="p-1">
                                            <button type="button" class="btn btn-primary btn-sm " id="openPopup"
                                                style="border-radius: 15px; margin-bottom: 0px; background-image: linear-gradient(to bottom, #7900ff, #2b8ffc);">
                                                <b>Assign old user</b></button>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-4"
                                        style=" background-color: #d8ebd5; height:85px; border-radius: 12px; color: black;">
                                        <div class="row">
                                            <div class="col-3" style="margin-top: 10px;">
                                                <p style="font-size: 12px;"><b>Age:</b> {{ $p->age }}</p>
                                                <p style="font-size: 12px;"><b>Weight:</b> {{ $p->weight }}</p>
                                                <p style="font-size: 12px;"><b>Allergies:</b></p>
                                            </div>
                                            <div class="col-7" style="margin-top: 10px;">
                                                <p style="font-size: 12px;"><b>Gender:</b> {{ $p->gender }}</p>
                                                <p style="font-size: 12px;"><b>Address:</b> {{ $p->address }}</p>
                                            </div>
                                            <div class="col-2" style="margin-top: 30px;">
                                                <a href="{{ route('patienteditview', ['id' => $p->id]) }}"> <button
                                                        type="button" class="btn btn-primary btn-sm"
                                                        style="border-radius: 15px; background-image: linear-gradient(to bottom, #7900ff, #2b8ffc); "><b>
                                                            EDIT</b></button></a>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-8"
                                        style=" background-color: #eef1da; height:85px; border-radius: 12px; color: black;">
                                        <p style="margin-top: 10px;"><b>Last Visit Sumary </b></p>
                                        <div class="row">
                                            <div class="col-12" style="font-size: 12px;">
                                                @foreach ($investigationDel as $inv)
                                                    <table>
                                                        <tr>
                                                            <td>medicalTest : {{ $inv->medicalTest }}</td>
                                                            <td>Treatment : {{ $inv->treatment }}</td>
                                                            <td>Investigation Name : {{ $inv->category_name }}</td>

                                                        </tr>
                                                        <tr>
                                                            <td>Last Visit Date : {{ $inv->channel_date }}</td>
                                                            <td>comment : {{ $inv->comment }}</td>

                                                        </tr>
                                                        <tr>
                                                        </tr>
                                                    </table>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>

                                    @if ($investigationDel->count() != '0')
                                        @foreach ($investigationDel as $inv)
                                            <div class="flex-container-extend" style="margin-top: 10px;">
                                                 <div class="p-0"
                                                    style="width: 300px; height:400px; background-color: #EBEFF3;margin-top: 10px;margin-bottom: 10px;">
                                                    <br><b>Investigation</b>
                                                    <div class="dropdown" style="margin-top:10px;">
                                                    <select class="form-control select2" id="investigation"
                                                                    name="investigation" rows="4" style="width: 200px; ">
                                                                    @foreach ($diagnostic_categories as $diagnostic)
                                                                        <option value="{{ $diagnostic->category_name }}"
                                                                            style="size:10px;">
                                                                            {{ $diagnostic->category_name }}
                                                                        </option>
                                                                    @endforeach
                                                    </select>
                                                    <table id="investigationTable" >
                                                                    <tbody>

                                                                    </tbody>

                                                        </table>
                                                    </div>
                                                </div>

                                                <div>
                                                    <div class="p-2  align-self-start"
                                                        style="margin-top: 10px; width: 220px; height:200px; border: 2px solid white; background-color: #EBEFF3;">
                                                        <b>TREATMENTS</b>
                                                        <textarea id="treatment" name="treatment" rows="5" cols="23"
                                                            style="background-color: #EBEFF3; border: none;">{{ $inv->treatment }}</textarea>
                                                    </div>
                                                    <div class="p-2"
                                                        style="height:198px; width: 220px; border: 2px solid white; background-color: #EBEFF3; ">
                                                        <b>MEDICAL TESTS</b>
                                                        <div id="medicalDropdown" class="dropdown-content"
                                                            style="margin-top: 10px;">
                                                            <select class="form-control select2" id="medicalTest"
                                                                    name="medicalTest" rows="4" style="width: 200px;">
                                                                    @foreach ($medical_tests as $medical_test)
                                                                        <option value="{{ $medical_test->test_name }}"
                                                                            style="size:10px;">
                                                                            {{ $medical_test->test_name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>

                                                        </div>
                                                        <table id="listView" style="margin-top:60px;">
                                                                    <tbody>

                                                                    </tbody>

                                                        </table>

                                                        {{-- <textarea id="medicalTest" name="medicalTest" rows="5" cols="23"
                                                            style="background-color: #EBEFF3; border: none;"></textarea> --}}
                                                    </div>
                                                </div>
                                                <div>
                                                    <div class="p-2  align-self-start"
                                                        style="margin-top: 10px; height:197px;  width: 500px; border-style: none; background-color: #EBEFF3;">
                                                        <b>OPD
                                                            DRUGS</b>
                                                        <br>
                                                        <div class="p-0">

                                                            <div class="table-responsive "
                                                                style="font-size:12px; margin-top:10px; width: 490px;  height:179px;">
                                                                <select class="form-control select2" id="opd_drugs"
                                                                    name="opd_drugs" rows="4" style="width: 200px;">
                                                                    @foreach ($drugs as $drug)
                                                                        <option value="{{ $drug->drug_name }}"
                                                                            style="size:10px;">
                                                                            {{ $drug->drug_name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                                <table id="faqs">
                                                                    <thead>
                                                                        <tr>
                                                                            <th style="width: 80%;">Drug name
                                                                            </th>
                                                                            <th style="width: 10%;">Dose</th>
                                                                            <th style="width: 10%;">Period</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>

                                                                    </tbody>

                                                                </table>


                                                            </div>


                                                        </div>
                                                    </div>
                                                    <div class="p-2 align-self-end"
                                                        style="height:200px;  width: 500px; border-style: none; background-color: #EBEFF3;">
                                                        <b>OUTSIDE
                                                            DRUGS</b>

                                                        

                                                        <div class="p-0 ">

                                                            <div class="table-responsive "
                                                                style="font-size:12px; margin-top:10px;  width: 490px;  height:179px;">

                                                                <select class="form-control select2" id="outside_drugs"
                                                                    name="outside_drugs" rows="4" style="width: 200px;">
                                                                    @foreach ($drugs as $drug)
                                                                        <option value="{{ $drug->drug_name }}"
                                                                            style="size:10px;">
                                                                            {{ $drug->drug_name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                                <table id="table2">
                                                                    <thead>
                                                                        <tr>
                                                                            <th style="width: 80%;">Drug name
                                                                            </th>
                                                                            <th style="width: 10%;">Dose</th>
                                                                            <th style="width: 10%;">Period</th>

                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                      

                                                                      

                                                                    </tbody>
                                                                </table>

                                                            </div>
                                                            
                                                        </div>
                                                    </div>
                                                </div>




                                                <div class="p-2" style="margin-left: 25px;">
                                                    <div class="mb-3"
                                                        style=" margin-bottom: 2px; width: 160px; height:50px; font-size:12px;">
                                                        <p><b> NEXT VISIT DATE</b></p>
                                                        <input type="date" class="form-control" id="next_visit_date"
                                                            placeholder="" name="next_visit_date"
                                                            value="{{ $inv->next_visit_date }}" style="width: 150px;">


                                                    </div>

                                                    <div class="p-2"
                                                        style="height:190px;  width: 150px; background-color: #EBEFF3; border: none;">
                                                        <textarea value="{{ $inv->comment }}" id="comment" name="comment" rows="10" cols="3"
                                                            style="height:170px;  width: 100px; background-color: #EBEFF3; border: none;">Remark</textarea>
                                                    </div>

                                                    <label for="tname"
                                                        style="text-align:left ; color:white; background-color:#dbb8b3; height:60px; width: 148px;  margin-top: 20px;">
                                                        <br><label>Total Amount</label>
                                                        <input step="100"  value="{{ $inv->amount }}" id="amount" name="amount"
                                                            type="number" class="form-control"
                                                            style="text-align:left ; background-color:#e3b8b1; border:none;"></label>

                                                    <div>
                                                        <button type="submit"
                                                            style=" background-color:#4DFF98 ; height:40px; width: 160px; font-size:18px;  margin-top: 15px; color:white; border-radius: 15px; text-shadow: 2px 2px 4px #000000; padding-top: 5px; background-image: linear-gradient(to bottom, #4fdcd7, #52f3bc);"
                                                            class="btn  btn-primary "><b> FINISH</b></button>
                                                    </div>
                                                </div>

                                            </div>
                                        @endforeach
                                    @else
                                        <div class="flex-container-extend" style="margin-top: 10px;">
                                            <div class="p-0"
                                                style="width: 300px; height:400px; background-color: #EBEFF3;margin-top: 10px;margin-bottom: 10px;">
                                                <b>INVESTIGATION</b>
                                                <div class="dropdown">
                                                    <div id="myDropdown" class="dropdown-content">
                                                        <input type="text" placeholder="Search.." id="myInput"
                                                            onkeyup="filterFunction()">
                                                        <select class="form-control" id="diagnostic_categories"
                                                            name="diagnostic_categories" rows="4">
                                                            <option value="">--Select--</option>
                                                            @foreach ($diagnostic_categories as $diagnostic)
                                                                <option value="{{ $diagnostic->id }}">
                                                                    {{ $diagnostic->category_name }}</option>
                                                            @endforeach
                                                        </select>
                                                        <textarea id="investigation" name="investigation" cols="28" style="background-color: #EBEFF3; border: none;"
                                                            placeholder="Investigation Details" rows="30"></textarea>
                                                    </div>
                                                </div>
                                            </div>

                                            <div>
                                                <div class="p-2  align-self-start"
                                                    style=" width: 220px; margin-top: 10px; height:150px; border: 2px solid white; background-color: #EBEFF3;  margin-top: 1px;">
                                                    <b>TREATMENTS</b>
                                                    <textarea id="treatment" name="treatment" rows="5" cols="23"
                                                        style="background-color: #EBEFF3; border: none;"></textarea>
                                                </div>
                                                <div class="p-2"
                                                    style="height:150px; width: 220px; border: 2px solid white; background-color: #EBEFF3; ">
                                                    <b>MEDICAL TEST</b>
                                                    <div id="medicalDropdown" class="dropdown-content"
                                                        style="margin-top: 10px;">
                                                        <select multiple="multiple" class="form-control select2" id="medical_categories"
                                                            name="medical_categories" rows="4"  style="width: 200px;">
                                                            <option value="">--Select--</option>
                                                            @foreach ($medical_tests as $medical_test)
                                                                <option value="{{ $medical_test->test_name }}"
                                                                    style="size:10px;">
                                                                    {{ $medical_test->test_name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    {{-- <textarea id="medicalTest" name="medicalTest" rows="5" cols="23"
                                                        style="background-color: #EBEFF3; border: none;"></textarea> --}}
                                                </div>
                                            </div>
                                            <div>
                                                <div class="p-2  align-self-start"
                                                    style="margin-top: 10px; height:150px;  width: 500px; border-style: none; background-color: #EBEFF3;">
                                                    <b>OPD
                                                        DRUGS</b>

                                                    <div class="p-0">

                                                        <div class="table-responsive "
                                                            style="font-size:12px;  width: 490px;  height:50px;">

                                                            <table id="faqs">
                                                                <thead>
                                                                    <tr>
                                                                        <th style="width: 80%;">Drug name</th>
                                                                        <th style="width: 10%;">Dose</th>
                                                                        <th style="width: 10%;">Period</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <!-- Rows with hidden input for unique identifier -->
                                                                    <tr id="faqs-row0">
                                                                        <input type="hidden" name="faqs_row_id[]"
                                                                            value="0">
                                                                        <td>
                                                                            <select class="select2" id="opddrug1"
                                                                            style="width: 400px;">
                                                                            <option value="">--Select--</option>  @foreach ($drugs as $drug)
                                                                                <option
                                                                                    value="{{ $drug->id }}">
                                                                                    {{ $drug->drug_name }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                        </td>
                                                                        <td><input type="text" name="doseopd1"
                                                                                style="width: 40px;"></td>
                                                                        <td><input type="text" name="periodopd1"
                                                                                style="width: 40px;"></td>
                                                                        {{-- <td><button type="button"
                                                                                class="badge badge-danger delete-row"
                                                                                onclick="$('#faqs-row0').remove();"><i
                                                                                    class="fa fa-trash"></i>
                                                                                Delete</button></td> --}}
                                                                    </tr>
                                                                    <tr id="faqs-row0">
                                                                        <input type="hidden" name="faqs_row_id[]"
                                                                            value="0">
                                                                        <td>
                                                                            <select class="select2" id="opddrug2"
                                                                            style="width: 400px;">
                                                                            <option value="">--Select--</option>  @foreach ($drugs as $drug)
                                                                                <option
                                                                                    value="{{ $drug->id }}">
                                                                                    {{ $drug->drug_name }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                        </td>
                                                                        <td><input type="text" name="doseopd1"
                                                                                style="width: 40px;"></td>
                                                                        <td><input type="text" name="periodopd1"
                                                                                style="width: 40px;"></td>
                                                                        {{-- <td><button type="button"
                                                                                class="badge badge-danger delete-row"
                                                                                onclick="$('#faqs-row0').remove();"><i
                                                                                    class="fa fa-trash"></i>
                                                                                Delete</button></td> --}}
                                                                    </tr>
                                                                    <tr id="faqs-row0">
                                                                        <input type="hidden" name="faqs_row_id[]"
                                                                            value="0">
                                                                        <td>
                                                                            <select class="select2" id="opddrug3"
                                                                            style="width: 400px;">
                                                                            <option value="">--Select--</option>  @foreach ($drugs as $drug)
                                                                                <option
                                                                                    value="{{ $drug->id }}">
                                                                                    {{ $drug->drug_name }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                        </td>
                                                                        <td><input type="text" name="doseopd1"
                                                                                style="width: 40px;"></td>
                                                                        <td><input type="text" name="periodopd1"
                                                                                style="width: 40px;"></td>
                                                                        {{-- <td><button type="button"
                                                                                class="badge badge-danger delete-row"
                                                                                onclick="$('#faqs-row0').remove();"><i
                                                                                    class="fa fa-trash"></i>
                                                                                Delete</button></td> --}}
                                                                    </tr>
                                                                    <tr id="faqs-row0">
                                                                        <input type="hidden" name="faqs_row_id[]"
                                                                            value="0">
                                                                        <td>
                                                                            <select class="select2" id="opddrug4"
                                                                            style="width: 400px;">
                                                                            <option value="">--Select--</option>  @foreach ($drugs as $drug)
                                                                                <option
                                                                                    value="{{ $drug->id }}">
                                                                                    {{ $drug->drug_name }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                        </td>
                                                                        <td><input type="text" name="doseopd1"
                                                                                style="width: 40px;"></td>
                                                                        <td><input type="text" name="periodopd1"
                                                                                style="width: 40px;"></td>
                                                                        {{-- <td><button type="button"
                                                                                class="badge badge-danger delete-row"
                                                                                onclick="$('#faqs-row0').remove();"><i
                                                                                    class="fa fa-trash"></i>
                                                                                Delete</button></td> --}}
                                                                    </tr>
                                                                    <tr id="faqs-row0">
                                                                        <input type="hidden" name="faqs_row_id[]"
                                                                            value="0">
                                                                        <td>
                                                                            <select class="select2" id="opddrug5"
                                                                            style="width: 400px;">
                                                                            <option value="">--Select--</option>  @foreach ($drugs as $drug)
                                                                                <option
                                                                                    value="{{ $drug->id }}">
                                                                                    {{ $drug->drug_name }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                        </td>
                                                                        <td><input type="text" name="doseopd1"
                                                                                style="width: 40px;"></td>
                                                                        <td><input type="text" name="periodopd1"
                                                                                style="width: 40px;"></td>
                                                                        {{-- <td><button type="button"
                                                                                class="badge badge-danger delete-row"
                                                                                onclick="$('#faqs-row0').remove();"><i
                                                                                    class="fa fa-trash"></i>
                                                                                Delete</button></td> --}}
                                                                    </tr>
                                                                </tbody>

                                                            </table>

                                                            <div class="text-center"><button type="button"
                                                                    onclick="addfaqs();" class="badge badge-success"
                                                                    style=" background-color:#978FF3; color:white; font-size:12px; border-radius: 15px; background-image: linear-gradient(to bottom, #7900ff, #2b8ffc); "><i
                                                                        class="fa fa-plus"></i> ADD
                                                                    NEW</button></div>
                                                        </div>


                                                    </div>
                                                </div>
                                                <div class="p-2 align-self-end"
                                                    style="height:150px;  width: 500px; border-style: none; background-color: #EBEFF3;">
                                                    <b>OUTSIDE
                                                        DRUGS</b>

                                                    <div class="p-0">

                                                        <div class="table-responsive "
                                                            style="font-size:12px;  width: 490px;  height:120px;">

                                                            <table id="table2">
                                                                <thead>
                                                                    <tr>
                                                                        <th style="width: 80%;">Drug name</th>
                                                                        <th style="width: 10%;">Dose</th>
                                                                        <th style="width: 10%;">Period</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <!-- Rows with hidden input for unique identifier -->

                                                                    <tr>
                                                                        <input type="hidden" name="row_id[]">
                                                                        <td>
                                                                            <select class="select2" id="outsidedrug1"
                                                                                    style="width: 400px;">
                                                                                    <option value="">--Select--</option>  @foreach ($drugs as $drug)
                                                                                        <option
                                                                                            value="{{ $drug->id }}">
                                                                                            {{ $drug->drug_name }}
                                                                                        </option>
                                                                                    @endforeach
                                                                                </select>
                                                                        </td>
                                                                        <td><input type="text" name="outsidedose1"
                                                                                style="width: 40px;"></td>
                                                                        <td><input type="text" name="outsideperiod1"
                                                                                style="width: 40px;"></td>
                                                                        {{-- <td><button type="button"
                                                                                class="badge badge-danger delete-row"><i
                                                                                    class="fa fa-trash"></i>
                                                                                Delete</button></td> --}}
                                                                    </tr>
                                                                    <tr>
                                                                        <input type="hidden" name="row_id[]">
                                                                        <td>
                                                                            <select class="select2" id="outsidedrug2"
                                                                                    style="width: 400px;">
                                                                                    <option value="">--Select--</option>  @foreach ($drugs as $drug)
                                                                                        <option
                                                                                            value="{{ $drug->id }}">
                                                                                            {{ $drug->drug_name }}
                                                                                        </option>
                                                                                    @endforeach
                                                                                </select>
                                                                        </td>
                                                                        <td><input type="text" name="outsidedose1"
                                                                                style="width: 40px;"></td>
                                                                        <td><input type="text" name="outsideperiod1"
                                                                                style="width: 40px;"></td>
                                                                        {{-- <td><button type="button"
                                                                                class="badge badge-danger delete-row"><i
                                                                                    class="fa fa-trash"></i>
                                                                                Delete</button></td> --}}
                                                                    </tr>
                                                                    <tr>
                                                                        <input type="hidden" name="row_id[]">
                                                                        <td>
                                                                            <select class="select2" id="outsidedrug3"
                                                                            style="width: 400px;">
                                                                            <option value="">--Select--</option>  @foreach ($drugs as $drug)
                                                                                <option
                                                                                    value="{{ $drug->id }}">
                                                                                    {{ $drug->drug_name }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                        </td>
                                                                        <td><input type="text" name="outsidedose1"
                                                                                style="width: 40px;"></td>
                                                                        <td><input type="text" name="outsideperiod1"
                                                                                style="width: 40px;"></td>
                                                                        {{-- <td><button type="button"
                                                                                class="badge badge-danger delete-row"><i
                                                                                    class="fa fa-trash"></i>
                                                                                Delete</button></td> --}}
                                                                    </tr>
                                                                    <tr>
                                                                        <input type="hidden" name="row_id[]">
                                                                        <td>
                                                                            <select class="select2" id="outsidedrug4"
                                                                            style="width: 400px;">
                                                                            <option value="">--Select--</option>  @foreach ($drugs as $drug)
                                                                                <option
                                                                                    value="{{ $drug->id }}">
                                                                                    {{ $drug->drug_name }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                        </td>
                                                                        <td><input type="text" name="outsidedose1"
                                                                                style="width: 40px;"></td>
                                                                        <td><input type="text" name="outsideperiod1"
                                                                                style="width: 40px;"></td>
                                                                        {{-- <td><button type="button"
                                                                                class="badge badge-danger delete-row"><i
                                                                                    class="fa fa-trash"></i>
                                                                                Delete</button></td> --}}
                                                                    </tr>
                                                                    <tr>
                                                                        <input type="hidden" name="row_id[]">
                                                                        <td>
                                                                            <select class="select2" id="outsidedrug5"
                                                                                    style="width: 400px;">
                                                                                    <option value="">--Select--</option>  @foreach ($drugs as $drug)
                                                                                        <option
                                                                                            value="{{ $drug->id }}">
                                                                                            {{ $drug->drug_name }}
                                                                                        </option>
                                                                                    @endforeach
                                                                                </select>
                                                                        </td>
                                                                        <td><input type="text" name="outsidedose1"
                                                                                style="width: 40px;"></td>
                                                                        <td><input type="text" name="outsideperiod1"
                                                                                style="width: 40px;"></td>
                                                                        {{-- <td><button type="button"
                                                                                class="badge badge-danger delete-row"><i
                                                                                    class="fa fa-trash"></i>
                                                                                Delete</button></td> --}}
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                            <div class="text-center"><button type="button"
                                                                    onclick="addrowtable();" class="badge badge-success"
                                                                    style=" background-color:#978FF3; margin-top:28px; color:white; font-size:12px; border-radius: 15px; text-shadow: 2px 2px 4px #000000; background-image: linear-gradient(to bottom, #7900ff, #2b8ffc); "><i
                                                                        class="fa fa-plus"></i> ADD
                                                                    NEW</button></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>




                                            <div class="p-2" style="margin-left: 25px;">
                                                <div class="mb-3"
                                                    style=" margin-bottom: 2px; width: 160px; height:50px; font-size:12px;">
                                                    <p><b> NEXT VISIT DATE</b></p>
                                                    <input type="date" class="form-control" id="next_visit_date"
                                                        placeholder="" name="next_visit_date" value=""
                                                        style="width: 150px;">

                                                </div>

                                                <div class="p-2"
                                                    style="height:115px;  width: 150px; background-color: #EBEFF3; border: none;">
                                                    <textarea value="" id="comment" name="comment" rows="10" cols="3"
                                                        style="height:115px;  width: 100px; background-color: #EBEFF3; border: none;">Remark</textarea>
                                                </div>

                                                <label for="tname"
                                                    style="text-align:left ; color:white; background-color:#dbb8b3; height:50px; width: 145px;  margin-top: 20px;">
                                                    <br><label>Total Amount</label>
                                                    <input step="100" id="amount" name="amount" type="number"
                                                        class="form-control"
                                                        style="text-align:left ; background-color:#e3b8b1; border:none;">
                                                

                                                <div>
                                                    <button type="submit"
                                                        style=" background-color:#4DFF98 ; height:40px; width: 160px; font-size:18px;  margin-top: 15px; color:white; border-radius: 15px; text-shadow: 2px 2px 4px #000000; padding-top: 5px; background-image: linear-gradient(to bottom, #4fdcd7, #52f3bc);"
                                                        class="btn  btn-primary "><b> FINISH</b></button>
                                                </div>
                                            </div>

                                        </div>
                                    @endif

                            </form>
                        @endforeach

                    </div>

                </div>

            </div>
        @endsection
        @include('footer')
</body>


<script>

document.getElementById('finishButton').addEventListener('keypress', function (e) {
        if (e.which === 13) {
            e.preventDefault(); 
        }
    });
    $(document).ready(function() {

        $(".select2").select2({
        });

    })

    function showDateTime() {
        var myDiv = document.getElementById("myDiv");

        var date = new Date();
        var dayList = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];
        var monthNames = [
            "January",
            "February",
            "March",
            "April",
            "May",
            "June",
            "July",
            "August",
            "September",
            "October",
            "November",
            "December"
        ];
        var dayName = dayList[date.getDay()];
        var monthName = monthNames[date.getMonth()];
        var today = `${dayName}, ${monthName} ${date.getDate()}, ${date.getFullYear()}`;

        var hour = date.getHours();
        var min = date.getMinutes();
        var sec = date.getSeconds();

        var time = hour + ":" + min + ":" + sec;
        myDiv.innerText = `${time}`;
    }
    setInterval(showDateTime, 1000);


<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('openPopup').addEventListener('click', function() {
            document.getElementById('updatePopup').style.display = 'block';
        });
        document.getElementById('closePopup').addEventListener('click', function() {
            document.getElementById('updatePopup').style.display = 'none';
        });
    });
</script>

<script>
    function myCategory() {
        document.getElementById("myDropdown").classList.toggle("show");
    }

    function medicalCategory() {
        document.getElementById("medicalDropdown").classList.toggle("show");
    }

    function filterFunction() {
        var input, filter, ul, li, a, i, option;
        input = document.getElementById("myInput");
        filter = input.value.toUpperCase();
        div = document.getElementById("myDropdown");
        option = div.getElementsByTagName("option");
        for (i = 0; i < option.length; i++) {
            txtValue = option[i].textContent || option[i].innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                option[i].style.display = "";
            } else {
                option[i].style.display = "none";
            }
        }
    }
</script>


<script>
    $(document).ready(function () {
        $('#outside_drugs').select2({
            tags: true,  // Allow adding new tags
            tokenSeparators: [',', ' '],  // Define separators for multiple tags
        });
        $('#opd_drugs').select2({
            tags: true,  // Allow adding new tags
            tokenSeparators: [',', ' '],  // Define separators for multiple tags
        });
        $('#medicalTest').select2({
            tags: true,  // Allow adding new tags
            tokenSeparators: [',', ' '],  // Define separators for multiple tags
        });
        $('#investigation').select2({
            tags: true,  // Allow adding new tags
            tokenSeparators: [',', ' '],  // Define separators for multiple tags
        });

        $('#outside_drugs').on('select2:select', function (e) {
            var selectedValue = e.params.data.text;
            addRowToTableoutside(selectedValue);
            // Remove the selected option from the dropdown
            var optionToRemove = $('#outside_drugs').find('option[value="' + selectedValue + '"]');
            optionToRemove.remove();
        });
        $('#opd_drugs').on('select2:select', function (e) {
            var selectedValue = e.params.data.text;
            addRowToTableopd(selectedValue);
            // Remove the selected option from the dropdown
            var optionToRemove = $('#opd_drugs').find('option[value="' + selectedValue + '"]');
            optionToRemove.remove();
        });
        $('#medicalTest').on('select2:select', function (e) {
            var selectedValue = e.params.data.text;
            addlist(selectedValue);
            
            // Remove the selected option from the dropdown
            var optionToRemove = $('#medicalTest').find('option[value="' + selectedValue + '"]');
            optionToRemove.remove();
        });
        $('#investigation').on('select2:select', function (e) {
            var selectedValue = e.params.data.text;
            addinvestigation(selectedValue);
            
            // Remove the selected option from the dropdown
            var optionToRemove = $('#investigation').find('option[value="' + selectedValue + '"]');
            optionToRemove.remove();
        });
        $('#outside_drugs').on('change', function (e) {
            // Check if the event is triggered by user action, not programmatic changes
            if (e.originalEvent) {
                var inputValue = $(this).val();
                if (inputValue && $('#outside_drugs option[value="' + inputValue + '"]').length === 0) {
                    addRowToTableoutside(inputValue);
                    $(this).val(null).trigger('change'); // Clear the input value
                }
            }
        });
        $('#medicalTest').on('change', function (e) {
            // Check if the event is triggered by user action, not programmatic changes
            if (e.originalEvent) {
                var inputValue = $(this).val();
                if (inputValue && $('#medicalTest option[value="' + inputValue + '"]').length === 0) {
                    addlist(inputValue);
                    $(this).val(null).trigger('change'); // Clear the input value
                }
            }
        });
        $('#investigation').on('change', function (e) {
            // Check if the event is triggered by user action, not programmatic changes
            if (e.originalEvent) {
                var inputValue = $(this).val();
                if (inputValue && $('#investigation option[value="' + inputValue + '"]').length === 0) {
                    addinvestigation(inputValue);
                    $(this).val(null).trigger('change'); // Clear the input value
                }
            }
        });
        $('#outside_drugs').on('change', function (e) {
            // Check if the event is triggered by user action, not programmatic changes
            if (e.originalEvent) {
                var inputValue = $(this).val();
                if (inputValue && $('#outside_drugs option[value="' + inputValue + '"]').length === 0) {
                    addRowToTableoutside(inputValue);
                    $(this).val(null).trigger('change'); // Clear the input value
                }
            }
        });

        $('#table2').on('click', '.delete-row', function () {
            // Remove the row when the delete button is clicked
            $(this).closest('tr').remove();
        });

        function addRowToTableoutside(drugName) {
            var table = $('#table2 tbody');
            var newRow = '<tr>' +
                '<td>' + drugName + '</td>' +
                '<td><input type="text" style="font-size:10px;" name="dose[]" class="form-control"></td>' +
                '<td><input type="text" style="font-size:10px;" name="period[]" class="form-control"></td>' +
                '<td><button type="button" style="font-size:10px;" class="btn-sm btn-danger delete-row">Delete</button></td>' +
                '</tr>';
            table.append(newRow);
        }

        $('#faqs').on('click', '.delete-row', function () {
            // Remove the row when the delete button is clicked
            $(this).closest('tr').remove();
        });

        function addRowToTableopd(drugName) {
            var table = $('#faqs tbody');
            var newRow = '<tr>' +
                '<td>' + drugName + '</td>' +
                '<td><input type="text" style="font-size:10px;" name="dose[]" class="form-control"></td>' +
                '<td><input type="text" style="font-size:10px;" name="period[]" class="form-control"></td>' +
                '<td><button type="button" style="font-size:10px;" class="btn-sm btn-danger delete-row">Delete</button></td>' +
                '</tr>';
            table.append(newRow);
        }
        function addlist(drugName) {

            var table = $('#listView');
            var newItem = '<tr>' +
                '<td>' + drugName + '</td>' +
                '<td><button type="button" style="font-size:8px;" class="btn-sm btn-danger delete-item">Delete</button></td>' +
                '</tr>';            table.append(newItem);
        }
        $('#listView').on('click', '.delete-item', function () {
            $(this).closest('tr').remove();
    });
    function addinvestigation(drugName) {

var table = $('#investigationTable');
var newItem = '<tr>' +
    '<td>' + drugName + '</td>' +
    '<td><button type="button" style="font-size:8px;" class="btn-sm btn-danger delete-item-investi">Delete</button></td>' +
    '</tr>';            table.append(newItem);
}
$('#investigationTable').on('click', '.delete-item-investi', function () {
$(this).closest('tr').remove();
});

    });

</script>



</html>
