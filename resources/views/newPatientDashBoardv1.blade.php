<!DOCTYPE html>
<html lang="en">
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Doctor Screen</title>
    @include('header')
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

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

        4 .dropdown {
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




        .container-fluid {
            margin-top: 0px;
            overflow-x: hidden;
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
</script>
<?php
}



// Close connection
$conn->close();
}
?>

<body class="bg-gray-100">
    @extends('layouts.app')
    @section('content')
        @foreach ($patientDtl as $p)
            <!--Pop up message assign old user-->
            <div class="popup" id="updatePopup">
                <!-- Close button -->
                <span class="close" id="closePopup">&times;</span>
                <form action="#" method="GET" onsubmit="return validateForm()">
                    @csrf
                    <input type="hidden" name="newUserId" value="{{ $p->id }}" id="user_id"><br>
                    <div class="col">
                        <label>Please select old name:</label>
                        <div class="row">
                            <div class="col-9">
                                <select style="font-size: 12px;" class="form-control" id="name" name="oldUserId">
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
            </div>
            <form action="{{ route('appoinmentfinished', $p->id) }}" method="POST" onsubmit="return confirmSubmit()"
                id="form1">
                @csrf
                <input type="hidden" id="patient_id" name="patient_id" value="{{ $p->id }}">
                <!--View start -->
                <div class="container-fluid">
                    <div class="row justify-content-start">
                        <div class="col-12">
                            <div class="container-fluid p-4" style="background-color:#FFFFFF; border-radius:10px;">
                                <!-- Patient Name and History buttons-->
                                <div
                                    class="d-flex gap-2 flex-column flex-md-row align-items-center justify-content-between">
                                    <!--Patient name and Family name-->
                                    <div class="d-flex flex-column flex-lg-row gap-2 align-items-cente">
                                        <i class="fa fa-user-o mt-2" style="font-size:16px;"></i>patient
                                        <b>{{ $p->name }}</b>
                                        <button type="button"
                                            onclick="submitForm('{{ $p->family_name }}', '{{ $p->id }}')"
                                            style="border-radius: 15px;background-color:#8ff397; background-image: linear-gradient(to bottom, #ff0055, #fc2ba8); "
                                            class="btn btn-primary btn-sm"><b>{{ $p->family_name }}</b></button>
                                    </div>
                                    <div
                                        class="d-flex flex-column flex-lg-row align-items-center justify-content-center gap-2">
                                        <div class="d-flex flex-column flex-md-row align-items-center gap-2">
                                            <!--Investigation History Button-->
                                            <div>
                                                <a href="{{ route('investigationhistory', ['id' => $p->id]) }}"><button
                                                        type="button" class="btn btn-primary btn-sm"
                                                        style="border-radius: 15px; background-color:#978FF3; background-image: linear-gradient(to bottom, #7900ff, #2b8ffc); "><b>
                                                            Investigation History</b></button></a>
                                            </div>
                                            <!--Medical History Button-->
                                            <div>
                                                <a href="{{ route('medicalhistory', ['id' => $p->id]) }}"><button
                                                        type="button" class="btn btn-primary btn-sm "
                                                        style="border-radius: 15px; background-image: linear-gradient(to bottom, #7900ff, #2b8ffc);"><b>
                                                            Medical History</b></button></a>
                                            </div>
                                            <!--Drugs History Button-->
                                            <div>
                                                <a href="{{ route('drughistory', ['id' => $p->id]) }}"><button
                                                        type="button" class="btn btn-primary btn-sm "
                                                        style="border-radius: 15px; background-image: linear-gradient(to bottom, #7900ff, #2b8ffc);"><b>
                                                            Drugs history </b></button></a>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-column flex-md-row align-items-center gap-2">
                                            <!--Patient Profile Button-->
                                            <div>
                                                <a href="{{ route('investigation_history', ['id' => $p->id]) }}"><button
                                                        type="button" class="btn btn-primary btn-sm "
                                                        style="border-radius: 15px; background-image: linear-gradient(to bottom, #7900ff, #2b8ffc);">
                                                        <b>Patient Profile</b></button></a>
                                            </div>
                                            <!--Assign to Old User Button-->
                                            <div>
                                                <button type="button" class="btn btn-primary btn-sm " id="openPopup"
                                                    style="border-radius: 15px; background-image: linear-gradient(to bottom, #7900ff, #2b8ffc);">
                                                    <b>Assign old user</b></button>
                                            </div>
                                            <!--Key Functions-->
                                            <script>
                                                document.addEventListener('keydown', function(event) {
                                                    // Press F1 Button
                                                    if (event.keyCode === 112) {
                                                        event.preventDefault();

                                                        // Get the input element
                                                        var dataInput = document.getElementById('investi');

                                                        // Focus on the input field
                                                        dataInput.focus();
                                                    }
                                                    // Press F2 Button
                                                    else if (event.keyCode === 113) {
                                                        event.preventDefault();

                                                        // Get the input element
                                                        var dataInput = document.getElementById('investigation_details');

                                                        // Focus on the input field
                                                        dataInput.focus();
                                                    }
                                                    // Press F3 Button
                                                    else if (event.keyCode === 114) {
                                                        event.preventDefault();

                                                        // Get the input element
                                                        var dataInput = document.getElementById('treatment');

                                                        // Focus on the input field
                                                        dataInput.focus();
                                                    }
                                                    // Press F4 Button
                                                    else if (event.keyCode === 115) {
                                                        event.preventDefault();

                                                        // Get the input element
                                                        var dataInput = document.getElementById('mediTest');

                                                        // Focus on the input field
                                                        dataInput.focus();
                                                    }
                                                    // Press F5 Button
                                                    else if (event.keyCode === 116) {
                                                        event.preventDefault();

                                                        // Get the input element
                                                        var dataInput = document.getElementById('opdInput');

                                                        // Focus on the input field
                                                        dataInput.focus();
                                                    }
                                                    // Press F6 Button
                                                    else if (event.keyCode === 117) {
                                                        event.preventDefault();

                                                        // Get the input element
                                                        var dataInput = document.getElementById('outInput');

                                                        // Focus on the input field
                                                        dataInput.focus();
                                                    }
                                                    // Press F7 Button
                                                    else if (event.keyCode === 118) {
                                                        event.preventDefault();

                                                        // Get the input element
                                                        var dataInput = document.getElementById('next_visit_date');

                                                        // Focus on the input field
                                                        dataInput.focus();
                                                    }
                                                    // Press F8  Button
                                                    else if (event.keyCode === 119) {
                                                        event.preventDefault();

                                                        // Get the input element
                                                        var dataInput = document.getElementById('comment');

                                                        // Focus on the input field
                                                        dataInput.focus();
                                                    }
                                                    // Press F9 Button
                                                    else if (event.keyCode === 120) {
                                                        event.preventDefault();
                                                        var dataInput = document.getElementById('amount');
                                                        dataInput.focus();
                                                    }
                                                    //press F10
                                                    else if (event.keyCode === 121) {
                                                        event.preventDefault();

                                                        window.location.href = '{{ route('patienteditview', ['id' => $p->id]) }}';

                                                    }
                                                    // Press F12 Button
                                                    else if (event.keyCode === 123) {
                                                        event.preventDefault();

                                                        submitForm('form1');
                                                    }
                                                    // Press ctrl + u Buttons
                                                    //investigation history
                                                    else if (event.ctrlKey == true && event.key === 'u') {

                                                        window.location.href = '{{ route('investigationhistory', ['id' => $p->id]) }}';

                                                    }
                                                    // Press ctrl + g Buttons
                                                    // medical history
                                                    else if (event.ctrlKey == true && event.key === 'g') {
                                                        window.location.href = '{{ route('medicalhistory', ['id' => $p->id]) }}';


                                                    }
                                                    // Press ctrl + h Buttons
                                                    // drug history
                                                    else if (event.ctrlKey == true && event.key === 'h') {

                                                        window.location.href = '{{ route('drughistory', ['id' => $p->id]) }}';

                                                    }
                                                    // Press ctrl + j Buttons
                                                    // patient data
                                                    else if (event.ctrlKey == true && event.key === 'j') {

                                                        window.location.href = '{{ route('investigation_history', ['id' => $p->id]) }}';

                                                    }
                                                    // Press ctrl + k Buttons
                                                    // print report
                                                    else if (event.ctrlKey == true && event.key === 'k') {
                                                        postData();

                                                    }
                                                    // Press ctrl + m Buttons
                                                    else if (event.ctrlKey == true && event.key === 'm') {


                                                    }
                                                    // Press ctrl + b Buttons
                                                    else if (event.ctrlKey == true && event.key === 'b') {


                                                    }
                                                });
                                            </script>



                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex flex-column flex-md-row align-items-center gap-3">

                                    <!-- Patient Details-->
                                    <div class="container  p-lg-2" style="background-color:#d8ebd5;border-radius:10px;">
                                        <div class="d-flex align-items-center">
                                            <div class="col-3">
                                                <p style="font-size: 12px;"><b>Age:</b> {{ $p->age }}</p>
                                                <p style="font-size: 12px;"><b>Weight:</b> {{ $p->weight }}</p>
                                                <p style="font-size: 12px;"><b>Allergies:</b></p>
                                            </div>
                                            <div class="col-7">
                                                <p style="font-size: 12px;"><b>Gender:</b> {{ $p->gender }}</p>
                                                <p style="font-size: 12px;"><b>Address:</b> {{ $p->address }}</p>
                                            </div>
                                            <div class="col-lg-2">
                                                <a href="{{ route('patienteditview', ['id' => $p->id]) }}"> <button
                                                        type="button" class="btn btn-primary btn-sm"
                                                        style="border-radius: 15px; background-image: linear-gradient(to bottom, #7900ff, #2b8ffc); "><b>
                                                            EDIT</b></button></a>
                                            </div>
                                        </div>
                                    </div>


                                    <!-- Last Visit History-->
                                    <div class="container p-2 " style="background-color: #eef1da; border-radius:10px;">
                                        <p><b>Last Visit Sumary </b></p>

                                        <div style="font-size: 12px;">
                                            <table scope="col">
                                                <tr>
                                                    <td>medicalTest :</td>
                                                    <td>Treatment :</td>
                                                    <td>Investigation Name :</td>
                                                </tr>
                                                <tr>
                                                    <td>Last Visit Date :</td>
                                                    <td>comment :</td>
                                                </tr>
                                                <tr>
                                                </tr>
                                            </table>
                                        </div>

                                    </div>

                                </div>
                                <!-- Doctor's Data entry container-->

                                <div class="container-fluid p-2 mt-2"
                                    style="background-color: #b2d8e5; border-radius:10px;">

                                    <div class="d-flex flex-lg-row flex-column container-fluid w-100">
                                        <div class="d-flex flex-column flex-sm-row">

                                            <!-- Investigation -->

                                            {{-- investigation wrapper --}}
                                            <div class="gap-2 p-2 m-2"
                                                style="background-color: #EBEFF3; border-radius:10px;">
                                                <!--Topic-->
                                                <div class="row text-center">
                                                    <b>PRESENTING COMPLAIN <label for="help">[F1]</label></b>


                                                </div>
                                                <!--Insert Input and add button-->
                                                <div class="d-flex flex-column align-items-center">
                                                    <div
                                                        class="d-flex flex-column flex-md-row align-items-center justify-content-center gap-2">
                                                        <div>
                                                            <input type="text" id="investi" name="investi"
                                                                list="invList" class="form-control"
                                                                onkeypress="investihandleKeyPress(event)" />
                                                        </div>
                                                        <button type="button" onclick="addtableInvesti()"
                                                            style="font-size: 13px;"
                                                            class="btn btn-primary btn-sm mt-3">+</button>
                                                    </div>
                                                    <div class="col-2 my-1 pl-2">
                                                        <datalist id="invList">
                                                            @foreach ($diagnostic_categories as $diagnostic)
                                                                <option value="{{ $diagnostic->category_name }}">
                                                            @endforeach
                                                        </datalist>
                                                    </div>
                                                </div>
                                                <!-- Investigation print table-->
                                                <div class="p-3">
                                                    <div class="table-responsive"
                                                        style="font-size:13px;  overflow-x: hidden;">
                                                        <table id="investigationTable" style="width: 100%;">
                                                            <tbody>
                                                                <th style="width: 80%;"></th>
                                                                <th style="width: 10%;"></th>
                                                                @foreach ($investigation_history as $detail)
                                                                    <tr>
                                                                        <td>{{ $detail->investtigation }}</td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <!-- Investigation TestArea -->
                                                <div class="p-2">
                                                    <div class="col text-center">
                                                        <textarea title="Press F2" id="investigation_details"
                                                            style="line-height: 1.4; font-size: 13px; background-color: #EBEFF3; height: 32dvh; width: 100%;"
                                                            name="investigation_details" placeholder="Investigation Details">
                                                        @if ($investigationDel->isNotEmpty())
{{ $investigationDel->last()->investigation_details }}
@endif
                                                    </textarea>

                                                    </div>
                                                </div>
                                                {{-- end of  Investigation TestArea --}}
                                            </div>
                                            {{-- investigation wrapper end --}}



                                            <!-- Medical test and Treatments-->
                                            <div class="d-flex flex-column gap-2 m-2">
                                                <!--Treatments-->
                                                <div class="p-2" style="height:50%">
                                                    {{-- start wrapper --}}
                                                    <div class="container"
                                                        style="background-color: #EBEFF3; border-radius:10px;">
                                                        <!--Topic-->
                                                        <div class="row text-center">
                                                            <b>TREATMENTS<label for="help">[F3]</label></b>


                                                        </div>
                                                        <!-- TextArea -->
                                                        <div class="p-2 text-center ">
                                                            <textarea id="treatment" name="treatment" rows="5" cols="23"
                                                                style="line-height: 1.4; font-size: 13px; background-color: #EBEFF3;width:100%; height:28.6dvh;border-style: none;border: 0px solid #EBEFF3;margin-bottom:5px;"> 
                                                    @if ($investigationDel->isNotEmpty())
{{ $investigationDel->last()->treatment }}
@endif
                                                </textarea>
                                                        </div>
                                                    </div>
                                                    {{-- end of wrapper --}}
                                                </div>
                                                <div style="height:50%">
                                                    <!--Medical Test-->
                                                    <div class="p-2"
                                                        style="background-color: #EBEFF3; border-radius:10px;">
                                                        <!--Topic-->
                                                        <div class="row text-center">
                                                            <b>MEDICAL TESTS<label for="help">[F4]</label></b>


                                                        </div>
                                                        <!-- Input and Add button -->
                                                        <div
                                                            class="d-flex flex-column flex-md-row align-items-center gap-2">
                                                            <div>
                                                                <input type="text" id="mediTest" name="mediTest"
                                                                    list="mediList" class="form-control"
                                                                    style="display:inline-flex; align-items:baseline;"
                                                                    onkeypress="meditesthandleKeyPress(event)">
                                                            </div>
                                                            <div>
                                                                <button type="button" onclick="addtableMedicaltest()"
                                                                    style="font-size:13px;"
                                                                    class="btn btn-primary btn-m mt-3">+</button>
                                                            </div>
                                                            <datalist id="mediList">
                                                                @foreach ($medical_tests as $medical_test)
                                                                    <option value="{{ $medical_test->test_name }}">
                                                                @endforeach
                                                            </datalist>
                                                        </div>
                                                        <!--Mediacl tests table-->
                                                        <div class="p-3">
                                                            <div class="table-responsive"
                                                                style="font-size:13px; height:23dvh; overflow-x: hidden;">
                                                                <table id="listView"
                                                                    style="margin-top:2px; line-height: 1.4; font-size: 13px;">
                                                                    <tbody>
                                                                        <th style="width: 80%;"></th>
                                                                        <th style="width: 10%; "></th>
                                                                        @foreach ($reccomanded_medical_test as $medtest)
                                                                            <tr>
                                                                                <td>{{ $medtest->medical_test }}</td>
                                                                            </tr>
                                                                        @endforeach
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- medical test and treatment wrapper ends --}}


                                            <!-- Drugs-->
                                            <div class="d-flex flex-column gap-2 m-2">
                                                <div style="height:50%;">
                                                    <div class="p-2"
                                                        style="background-color: #EBEFF3; border-radius:10px;">
                                                        <!--Topic-->
                                                        <div class="row text-center">
                                                            <b>OPD Drugs<label for="help">[F5]</label></b>


                                                        </div>
                                                        <!-- Input and Add button -->
                                                        <div
                                                            class="text-center gap-2 d-flex flex-column flex-md-row align-items-center">
                                                            <div>
                                                                <input type="text" id="opdInput" name="opd"
                                                                    list="drugList" class="form-control"
                                                                    onkeypress="opdhandleKeyPress(event) ">
                                                            </div>
                                                            <div>
                                                                <button type="button" onclick="addtableopd()"
                                                                    style="font-size:13px;"
                                                                    class="btn btn-primary btn-m mt-3">+</button>
                                                            </div>
                                                        </div>
                                                        <datalist id="mediList">
                                                            @foreach ($medical_tests as $medical_test)
                                                                <option value="{{ $medical_test->test_name }}">
                                                            @endforeach
                                                        </datalist>
                                                        <!--OPD table-->
                                                        <div class="p-3">
                                                            <div class="table-responsive"
                                                                style="font-size:13px; overflow-x: hidden;height:23.5dvh; overflow-y: auto;">
                                                                <table id="faqs" style="margin-top:5px; ">
                                                                    <thead>
                                                                        <tr>
                                                                            <th style="width: 80%;">Drug name
                                                                            </th>
                                                                            <th style="width: 10%;">Dose</th>
                                                                            <th style="width: 10%;">Period</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody style="font-size:13px; line height:1.4px;">
                                                                        @foreach ($reccomanded_opd_drugs as $opddrugs)
                                                                            <tr>
                                                                                <td>{{ $opddrugs->drug }}</td>
                                                                                <td>{{ $opddrugs->dose }}</td>
                                                                                <td>{{ $opddrugs->period }}</td>
                                                                            </tr>
                                                                        @endforeach
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- OUT SIDE Drugs-->
                                                <div style="height:50%;">
                                                    <div class="p-2"
                                                        style="background-color: #EBEFF3; border-radius:10px;">
                                                        <!--Topic-->
                                                        <div class="row text-center">
                                                            <b>OUTSIDE Drugs<label for="help">[F6]</label></b>


                                                        </div>
                                                        <!-- Input and Add button -->
                                                        <div class="d-flex gap-2 flex-col flex-md-row align-items-center ">
                                                            <div>
                                                                <input type="text" id="outInput" name="out"
                                                                    list="drugList" class="form-control"
                                                                    onkeypress="outhandleKeyPress(event)" />
                                                            </div>
                                                            <div>
                                                                <datalist id="drugList">
                                                                    @foreach ($drugs as $drug)
                                                                        <option value="{{ $drug->drug_name }}">
                                                                    @endforeach
                                                                </datalist>
                                                                <button type="button" onclick="addtableout()"
                                                                    style="font-size:13px;"
                                                                    class="btn btn-primary btn-m mt-3">+</button>
                                                            </div>
                                                        </div>
                                                        <!--Outside drug table-->
                                                        <div class="p-3">
                                                            <div class="table-responsive"
                                                                style="font-size:13px; height:23dvh; overflow-x: hidden;">
                                                                <table id="table2" style="margin-top:5px;">
                                                                    <thead>
                                                                        <tr>
                                                                            <th style="width: 80%;">Drug name
                                                                            </th>
                                                                            <th style="width: 10%;">Dose</th>
                                                                            <th style="width: 10%;">Period</th>

                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        @foreach ($reccomanded_outside_drugs as $outdrugs)
                                                                            <tr>
                                                                                <td>{{ $outdrugs->drug }}</td>
                                                                                <td>{{ $outdrugs->dose }}</td>
                                                                                <td>{{ $outdrugs->period }}</td>
                                                                            </tr>
                                                                        @endforeach
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- wrapper div --}}
                                        <div class="d-flex flex-row flex-lg-column align-items-center  gap-2 m-2">
                                            <div class="p-2">

                                                {{-- first section --}}
                                                <div>
                                                    <div class="row text-center">
                                                        <b> NEXT VISIT DATE<label for="help">[F7]</label> </b>


                                                    </div>
                                                    <!-- Next visit date input tag-->
                                                    <div class="input-group date" data-provide="datepicker">
                                                        <input type="text" class="form-control" id="next_visit_date"
                                                            placeholder="" name="next_visit_date" value="" />
                                                        <div class="input-group-addon">
                                                            <span class="glyphicon glyphicon-th"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                {{-- second section --}}
                                                <div>
                                                    <div class="row text-center mt-3">
                                                        <b>Remark<label for="help">[F8]</label></b>


                                                    </div>
                                                    <!-- Comment Input Box-->
                                                    <div class="p-2 justify-content-center my-1"
                                                        style="border-radius:10px; background-color: #EBEFF3;">
                                                        <textarea class="mx-1" value="" id="comment" name="comment" rows="10" cols="3"
                                                            style="line-height: 1.3; width: 90%; background-color: #EBEFF3; border: none;margin-top:1.5px;">
                                                                        @if ($investigationDel->isNotEmpty())
{{ $investigationDel->last()->comment }}
@endif
                                                </textarea>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="p-2">

                                                {{-- third section --}}
                                                <div class="p-2">
                                                    <!--Amount insert box-->
                                                    <div class="row justify-content-center align-items-center">
                                                        <label for="tname"
                                                            style="text-align:left ; color:white; background-color:#dbb8b3;width: 100%; height:100%; border-radius:10px;">
                                                            <br><label>Total Amount</label>
                                                            <label for="help">[F9]</label>

                                                            <input step="100" value="" id="amount"
                                                                name="amount" type="number" class="form-control"
                                                                style="text-align:left ; background-color:#e3b8b1; margin-bottom:5px;"></label>
                                                    </div>
                                                </div>
                                                {{-- forth --}}
                                                <!-- Finish and Print report Buttons-->
                                                <div class="row justify-content-center">
                                                    <!-- Finish button-->
                                                    <input type="button"
                                                        style="background-color: #4DFF98; width: 90%; font-size: 18px; color: white; border-radius: 15px; text-shadow: 2px 2px 4px #000000; padding-top: 5px; background-image: linear-gradient(to bottom, #4fdcd7, #52f3bc);"
                                                        class="btn btn-primary" value="FINISH" id="finishButton"
                                                        onclick="submitForm('form1')">

                                                    <!-- Print report Button-->
                                                    <button type="button"
                                                        style=" background-color:#4DFF98 ;width: 90%; font-size:18px; color:white; border-radius: 15px; text-shadow: 2px 2px 4px #000000; padding-top: 5px; background-image: linear-gradient(to bottom, #4fdcd7, #52f3bc);"
                                                        class="btn  btn-primary " onclick="postData()">Print
                                                        Report</button>
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        @endforeach
        <!-- Print Button report Form -->
        <form id="postDataForm" action="{{ route('handle.ajax.request') }}" method="POST">
            @csrf
            <input type="hidden" name="comment" id="comment" value="">
            <input type="hidden" name="uid" id="uid" value="">
            <input type="hidden" name="treatment" id="treatment" value="">
            <input type="hidden" name="investigation" id="investigation_details" value="">
            <input type="hidden" name="tableData" id="tableData" value="">
            <input type="hidden" name="tableOutData" id="tableOutData" value="">
            <input type="hidden" name="tableMedical" id="tableMedical" value="">
            <input type="hidden" name="tableInvesti" id="tableInvesti" value="">
        </form>
    @endsection
    @include('footer')
</body>

<script>
    function submitForm(formId, event) {
        var isConfirmed = confirm('Are you sure you want to submit the form?');

        // If not confirmed, prevent form submission
        if (!isConfirmed) {
            event.preventDefault();
        } else {
            document.getElementById(formId).submit();
        }
    }

    document.getElementById('form1').addEventListener('keydown', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
        }
    });


    function investihandleKeyPress(event) {

        if (event.key === 'Enter') {
            addtableInvesti();
        }
    }

    function meditesthandleKeyPress(event) {

        if (event.key === 'Enter') {
            addtableMedicaltest();
        }
    }

    function opdhandleKeyPress(event) {

        if (event.key === 'Enter') {
            addtableopd();
        }
    }

    function outhandleKeyPress(event) {

        if (event.key === 'Enter') {
            addtableout();
        }
    }


    function validateForm() {
        var selectedValue = document.getElementById("name").value;
        if (selectedValue === "") {
            alert("Please select a value");
            return false;
        }
        return true;
    }
</script>
<script>
    $(function() {
        $("#next_visit_date").datepicker({
            format: 'yy-mm-dd'
        });
    });
</script>

<script>
    // This Function use to print report function add insert data to PostdataForm and pass that data to dom pdf page
    function postData() {
        var tableData = [];
        var tableOutData = [];
        var tableMedical = [];
        var tableInvesti = [];


        $('#faqs tbody tr').each(function(index, row) {
            var drugName = $(row).find('td:eq(0)').text().trim();
            var dose = $(row).find('td:eq(1) input').val();
            var period = $(row).find('td:eq(2) input').val();

            dose = dose ? dose.trim() : '';
            period = period ? period.trim() : '';
            var rowData = {
                'drugName': drugName,
                'dose': dose,
                'period': period
            };

            tableData.push(rowData);
        });
        $('#table2 tbody tr').each(function(index, row) {
            var drugName = $(row).find('td:eq(0)').text().trim();
            var dose = $(row).find('td:eq(1) input').val();
            var period = $(row).find('td:eq(2) input').val();


            dose = dose ? dose.trim() : '';
            period = period ? period.trim() : '';
            var rowData = {
                'drugName': drugName,
                'dose': dose,
                'period': period
            };

            tableOutData.push(rowData);
        });

        $('#listView tbody tr').each(function(index, row) {
            var medicalTest = $(row).find('td:eq(0)').text().trim();

            var rowData = {
                'medicalTest': medicalTest,
            };

            tableMedical.push(rowData);
        });
        $('#investigationTable tbody tr').each(function(index, row) {
            var investigation = $(row).find('td:eq(0)').text().trim();

            var rowData = {
                'investigation': investigation,
            };

            tableInvesti.push(rowData);
        });

        var form = document.getElementById('postDataForm');
        form.elements['uid'].value = document.getElementById('user_id').value;
        form.elements['comment'].value = document.getElementById('comment').value;
        form.elements['treatment'].value = document.getElementById('treatment').value;
        form.elements['investigation'].value = document.getElementById('investigation_details').value;


        form.elements['tableData'].value = JSON.stringify(tableData);
        form.elements['tableOutData'].value = JSON.stringify(tableOutData);
        form.elements['tableMedical'].value = JSON.stringify(tableMedical);
        form.elements['tableInvesti'].value = JSON.stringify(tableInvesti);


        form.submit();
    }
</script>

<script>
    // this script tag use to open popup box and close popup box 
    // assign to old user
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('openPopup').addEventListener('click', function() {
            document.getElementById('updatePopup').style.display = 'block';
        });
        document.getElementById('closePopup').addEventListener('click', function() {
            document.getElementById('updatePopup').style.display = 'none';
        });
    });
</script>
<!-- outside table -->
<script>
    function addtableout() {
        var drugName = $('#outInput').val().trim();
        if (drugName === "") {
            alert("Drug name is empty");
        } else if (!isOutsideDuplicate(drugName)) {
            addoutside(drugName);
            $('#outInput').val('');
        } else {
            alert('Drug name already exists');
        }
        // Get the input element
        var dataInput = document.getElementById('outInput');

        // Focus on the input field
        dataInput.focus();
    }

    function isOutsideDuplicate(name) {
        return $('#table2 tbody td:contains("' + name + '")').length > 0;
    }

    function addoutside(drugName) {
        var table = $('#table2 tbody');
        var newRow =
            '<tr>' +
            '<td style="text-align: left; line-height: 1.3;"><input type="hidden" style="font-size:10px;" name="outsideid[]" class="form-control" value="' +
            drugName + '">' + drugName + '</td>' +
            '<td><input type="text" style="font-size:10px;" name="outsidedose[]" class="form-control"></td>' +
            '<td><input type="text" style="font-size:10px;" name="outsideperiod[]" class="form-control"></td>' +
            '<td><button type="button" onclick="deleteRow(this)" style="font-size:10px;" class="btn-sm btn-danger delete-row">Delete</button></td>' +
            '</tr>';
        table.append(newRow);
    }

    function deleteRow(button) {
        var row = $(button).closest('tr');
        row.remove();
    }
</script>



<!-- opdside table -->
<script>
    function addtableopd() {
        var drugName = $('#opdInput').val().trim();
        if (drugName === "") {
            alert("Drug name is empty");
        } else if (!isOpdDuplicate(drugName)) {
            addopd(drugName);
            $('#opdInput').val('');
        } else {
            alert('Drug name already exists');
        }
        var dataInput = document.getElementById('opdInput');

        // Focus on the input field
        dataInput.focus();
    }

    function isOpdDuplicate(name) {
        return $('#faqs tbody td:contains("' + name + '")').length > 0;
    }

    function addopd(drugName) {
        var table = $('#faqs tbody');
        var newRow = '<tr>' +
            '<td style="text-align: left; line-height: 1.3;" ><input type="hidden" style="font-size:10px;" name="opdid[]" class="form-control" value="' +
            drugName + '">' + drugName + '</td>' +
            '<td><input type="text" style="font-size:10px;" name="opddose[]" class="form-control" required></td>' +
            '<td><input type="text" style="font-size:10px;" name="opdperiod[]" class="form-control" required></td>' +
            '<td><button type="button" onclick="deleteRow(this)" style="font-size:10px;" class="btn-sm btn-danger delete-row">Delete</button></td>' +
            '</tr>';
        table.append(newRow);
    }

    function deleteRow(button) {
        var row = $(button).closest('tr');
        row.remove();
    }
</script>

<!-- MedicalTest table -->
<script>
    var medicalTestsArray = [];

    function addtableMedicaltest() {
        var mediTestInput = $('#mediTest');
        var mediTestValue = mediTestInput.val().trim();

        if (mediTestValue === "") {
            alert("Medical test name is empty");
        } else if (!medicalTestsArray.includes(mediTestValue)) {
            addMedicaltable(mediTestValue);
            medicalTestsArray.push(mediTestValue);
            mediTestInput.val('');
        } else {
            alert('Medical test name already exists');
        }
        var dataInput = document.getElementById('mediTest');

        // Focus on the input field
        dataInput.focus();
    }

    function addMedicaltable(drugName) {
        var table = $('#listView');
        var newItem = '<tr>' +
            '<input type="hidden" style="font-size:10px;" name="medid[]" class="form-control" value="' +
            drugName + '"> ' + drugName +

            '<td style="text-align: left; line-height: 1.3;">' + drugName + '</td>' +
            '<td><button type="button" style="font-size:8px;" class="btn-sm btn-danger delete-item">Delete</button></td>' +
            '</tr>';
        table.append(newItem);
    }


    function deleteItem(button) {
        var row = $(button).closest('tr');
        var medicalTestName = row.find('td:first').text();
        medicalTestsArray = medicalTestsArray.filter(item => item !== medicalTestName);
        row.remove();
    }
</script>

<!-- Investigation table -->
<script>
    function addtableInvesti() {
        var data = $('#investi').val().trim();
        if (data === "") {
            alert("Investigation name is empty");
        } else if (!isInvestigationDuplicate(data)) {
            addInvestitable(data);
            $('#investi').val('');
        } else {
            alert('Investigation name already exists');
        }
        var dataInput = document.getElementById('investi');

        // Focus on the input field
        dataInput.focus();
    }

    function isInvestigationDuplicate(name) {
        return $('#investigationTable tbody td:contains("' + name + '")').length > 0;
    }

    function addInvestitable(drugName) {
        var table = $('#investigationTable');
        var newItem = '<tr>' +
            '<input type="hidden" style="font-size:10px;" name="invid[]" class="form-control" value="' +
            drugName + '"> ' + drugName +
            '<td style="text-align: left; line-height: 1.3;">' + drugName + '</td>' +
            '<td><button type="button" style="font-size:8px;" class="btn-sm btn-danger delete-item-investi">Delete</button></td>' +
            '</tr>';
        table.append(newItem);
    }


    function deleteInvestiItem(button) {
        var row = $(button).closest('tr');
        row.remove();
    }
</script>

<!-- Delete row-->
<script>
    $(document).ready(function() {
        // opd drug table
        $('#faqs').on('click', '.delete-row', function() {
            $(this).closest('tr').remove();
        });

        // outside drug table
        $('#table2').on('click', '.delete-row', function() {
            $(this).closest('tr').remove();
        });

        // medicaltest drug table
        $('#listView').on('click', '.delete-item', function() {
            $(this).closest('tr').remove();
        });
        // Investigation drug table
        $('#investigationTable').on('click', '.delete-item-investi', function() {
            $(this).closest('tr').remove();
        });
    });
</script>

</html>
