
<!--///////////////////NOT USING THIS CODE.This is a copy///////////////////////////////-->


<!DOCTYPE html>
<html lang="en">

<head> @include('header') <title>Doctor Screen</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script>
        $(function () {
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

<body class="g-sidenav-show  bg-gray-100">
    @extends('layouts.app')
    @section('content')
    <div class="container-fluid">
        <div class="row">
            <div>
                @include('sidebar')
            </div>
            
            @include('flash_message')
            @foreach ($patientDtl as $p)
            <div class="container-fluid">
                <div class="row">
                    <div class="col-9">
                        <form action="{{ route('patient_list_by_family_name.search') }}" method="POST">
                            @csrf
                            <input type="hidden" id="family_name" name="family_name" value="{{ $p->family_name }}">
                            <input type="hidden" id="currentPatientId" name="currentPatientId" value="{{ $p->id }}">
                            <button type="submit"
                                style="margin-left: 170px; border-radius: 15px; margin-bottom: 0px;  background-color:#8ff397; background-image: linear-gradient(to bottom, #ff0055, #fc2ba8); "
                                class="btn  btn-primary btn-sm "><b> {{ $p->family_name }}</b></button>
                        </form>
                    </div>

                    <div class="col-3">
                        <b>{{ date('Y-m-d') }}</b>

                        <b><span id="myDiv"></span></b> <i class="fa fa-bell-o" style="font-size:24px"></i>
                    </div>
                </div>
            </div>
            <div class="col-11" style="margin-left: 130px;">
                <div class="col-sm-12"
                    style=" background-color: white;  border-radius: 12px;  padding-top: 12px; color: black;">
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

                        <div class="row h-1">
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
                                                Investigation History</b></button></a>
                                </div>
                                <div class="p-1">
                                    <a href="{{ route('medicalhistory', ['id' => $p->id]) }}">
                                        <button type="button" class="btn btn-primary btn-sm "
                                            style="border-radius: 15px; margin-bottom: 0px; background-image: linear-gradient(to bottom, #7900ff, #2b8ffc);"><b>
                                                Medical History</b></button></a>
                                </div>

                                <div class="p-1">
                                    <a href="{{ route('drughistory', ['id' => $p->id]) }}">
                                        <button type="button" class="btn btn-primary btn-sm "
                                            style="border-radius: 15px;margin-bottom: 0px; background-image: linear-gradient(to bottom, #7900ff, #2b8ffc);"><b>
                                                Drugs history </b></button></a>
                                </div>
                                <div class="p-1">
                                    <a href="{{ route('investigation_history', ['id' => $p->id]) }}">
                                        <button type="button" class="btn btn-primary btn-sm "
                                            style="border-radius: 15px; margin-bottom: 0px; background-image: linear-gradient(to bottom, #7900ff, #2b8ffc);">
                                            <b>Patient Profile</b></button></a>
                                </div>
                                <div class="p-1">
                                    <button type="button" class="btn btn-primary btn-sm " id="openPopup"
                                        style="border-radius: 15px; margin-bottom: 0px; background-image: linear-gradient(to bottom, #7900ff, #2b8ffc);">
                                        <b>Assign old user</b></button>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-4" style="background-color: #d8ebd5; height: auto; width: 100%; border-radius: 12px; color: black; margin-left: 50px; padding: 10px;">
                                <div class="row">
                                    <div class="col-3" style="margin-top: 10px; font-size: 12px;">
                                        <p><b>Age:</b> {{ $p->age }}</p>
                                        <p><b>Weight:</b> {{ $p->weight }}</p>
                                        <p><b>Allergies:</b></p>
                                    </div>
                                    <div class="col-7" style="margin-top: 10px; font-size: 12px;">
                                        <p><b>Gender:</b> {{ $p->gender }}</p>
                                        <p><b>Address:</b> {{ $p->address }}</p>
                                    </div>
                                    <div class="col-2" style="margin-top: 30px;">
                                        <a href="{{ route('patienteditview', ['id' => $p->id]) }}">
                                            <button type="button" class="btn btn-primary btn-sm" style="border-radius: 15px; background-image: linear-gradient(to bottom, #7900ff, #2b8ffc);"><b>EDIT</b></button>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            
                            
                            <div class="col-7" style="background-color: #d8ebd5; height:auto; width: 100%; border-radius: 12px; color: black; margin-left: 20px; padding: 10px;">
                                <p style="margin-top: 10px;"><b>Last Visit Summary</b></p>
                                <div class="row">
                                    <div class="col-12" style="font-size: 12px;">
                                        <table style="width: 100%; table-layout: fixed;">
                                            <tr>
                                                <td style="text-align: center;">Medical Test:</td>
                                                <td style="text-align: center;">Treatment:</td>
                                                <td style="text-align: center;">Investigation Name:</td>
                                            </tr>
                                            <tr>
                                                <td style="text-align: center;">Last Visit Date:</td>
                                                <td style="text-align: center;">Comment:</td>
                                                <td></td> <!-- Empty cell for alignment -->
                                            </tr>
                                            <!-- Additional rows here -->
                                        </table>
                                    </div>
                                </div>
                            </div>


                            <div class="flex-container-extend" style="display: flex; flex-wrap: wrap; padding: 10px; align-items: flex-start;"> <!-- Added flex-wrap and padding -->


                                <div class="p-0"
                                    style="width: 300px; height:510px; background-color: #EBEFF3;margin-top: 10px;margin-bottom: 10px;">
                                    <br><b>INVESTIGATION</b>

                                    <div>

                                        <input type="text" id="investi" name="investi" list="invList"
                                            class="form-control"
                                            style="display:inline-flex; align-items:baseline; width:250px; margin-right: 2px;">
                                        <button type="button" onclick="addtableInvesti()"
                                            style="font-size:13px; margin-top:10px"
                                            class="btn btn-primary btn-m">+</button>

                                        <datalist id="invList">
                                            @foreach ($diagnostic_categories as $diagnostic)
                                            <option value="{{ $diagnostic->category_name }}">
                                                @endforeach
                                        </datalist>
                                        <div class="table-responsive "
                                                style="font-size:13px;    height:120px; overflow-x: hidden;">
                                                
                                        <table id="investigationTable" style="width: 100%;">
                                            <tbody>
                                            
                                            <th style="width: 80%;"></th>
                                            <th style="width: 10%;"></th>

                                           @foreach($investigation_history as $detail)
                                              <tr>
                                             <td>{{ $detail->investtigation }}</td> 
                                                  </tr>
                                                @endforeach
                                            </tbody>

                                        </table>
                                        </div>
                                        
                                    <textarea id="investigation_details"
                                            style="line-height: 1.4;font-size: 13px; background-color: #EBEFF3; margin-top: 20px;height:260px; width: 270px;"
                                            name="investigation_details" placeholder="Investigation Details"
                                            value="">
                                        @if($investigationDel->isNotEmpty())
                                         {{ $investigationDel->last()->investigation_details }}
                                        @endif
                                       </textarea>
                      
                                        

                                    </div>
                                </div>

                                <div>
                                    <div class="p-2  align-self-start"
                                        style="margin-top: 10px; width: 220px; height:310px; border-style: none; background-color: #EBEFF3;">
                                        <b>TREATMENTS</b>
                                        <textarea id="treatment" name="treatment" rows="5" cols="23"
                                            style="line-height: 1.4; font-size: 13px; background-color: #EBEFF3; margin-top:10px; height:279px; width:210px;border-style: none;border: 0px solid #EBEFF3;">
                                            @if($investigationDel->isNotEmpty())
                                             {{ $investigationDel->last()->treatment }}
                                            @endif
                                           </textarea>
                                        
                                    </div>
                                    <div class="p-2"
                                        style="height:198px; width: 220px; border: 2px solid #EBEFF3; background-color: #EBEFF3; ">
                                        <b>MEDICAL TESTS</b>
                                        <div style="margin-top: 10px;">

                                            <input type="text" id="mediTest" name="mediTest" list="mediList"
                                                class="form-control"
                                                style="display:inline-flex; align-items:baseline; width:161px; margin-right: 2px;">
                                            <button type="button" onclick="addtableMedicaltest()"
                                                style="font-size:13px; margin-top:10px"
                                                class="btn btn-primary btn-m">+</button>

                                            <datalist id="mediList">
                                                @foreach ($medical_tests as $medical_test)
                                                <option value="{{ $medical_test->test_name }}">
                                                    @endforeach
                                            </datalist>
                                        </div>
                                        <table id="listView" style="margin-top:2px; line-height: 1.4; font-size: 13px;">

                                            <tbody>
                                      <th style="width: 80%;"></th>
                                           <th style="width: 10%; "></th>
                                         @foreach($reccomanded_medical_test as $medtest)
                                        <tr>
                                 <td>{{ $medtest->medical_test }}</td> 
                                     </tr>
                                  @endforeach
                                            </tbody>

                                        </table>
                                    </div>
                                </div>
                                <div>
                                    <div class="p-2  align-self-start"
                                        style="margin-top: 10px; height:310px;  width: 500px; border-style: none; background-color: #EBEFF3;">


                                        <div class="p-0">

                                            <div class="table-responsive "
                                                style="line-height: 1.4; font-size: 13px; width: 490px;  height:280px; overflow-x: hidden;">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <p style="padding-top:15px;"><b>OPD DRUGS :</b></p>

                                                    </div>
                                                    <div class="col-md-6">
                                                        <input type="text" id="opdInput" name="opd" list="drugList"
                                                            class="form-control">
                                                        <datalist id="drugList">
                                                            @foreach ($drugs as $drug)
                                                            <option value="{{ $drug->drug_name }}">
                                                                @endforeach
                                                        </datalist>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <button type="button" onclick="addtableopd()"
                                                            style="margin-top:10px;" 
                                                            class="btn btn-primary btn-m">+</button>
                                                    </div>
                                                </div>



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
                                                    @foreach($reccomanded_opd_drugs as $opddrugs)
                                                    <tr >
                <td>{{ $opddrugs->drug }}</td> 
                <td >{{ $opddrugs->dose }}</td> 
                <td >{{ $opddrugs->period }}</td> 
            </tr>
@endforeach
                                                    </tbody>

                                                </table>


                                            </div>


                                        </div>
                                    </div>
                                    <div class="p-2 align-self-end"
                                        style="height:200px;  width: 500px; border-style: none; background-color: #EBEFF3;">

                                        <div class="p-0 ">

                                            <div class="table-responsive "
                                                style="line-height: 1.4; font-size: 13px;  width: 490px;  height:170px; overflow-x: hidden;">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <p style="padding-top:15px;"><b>OUTSIDE DRUGS :</b></p>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input type="text" id="outInput" name="out" list="drugList"
                                                            class="form-control">
                                                        <datalist id="drugList">
                                                            @foreach ($drugs as $drug)
                                                            <option value="{{ $drug->drug_name }}">
                                                                @endforeach
                                                        </datalist>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <button type="button" onclick="addtableout()"
                                                            class="btn btn-primary btn-m"
                                                            style="margin-top:10px;">+</button>
                                                    </div>
                                                </div>

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

                                                    @foreach($reccomanded_outside_drugs as $outdrugs)
            <tr >
                <td >{{ $outdrugs->drug }}</td> 
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


                                <div class="p-22" style="flex-grow: 1; margin: 0; padding: 5px;"> <!-- Adjusted flex-grow and margin -->
                                    <!-- Next Visit Date Section -->
                                    <div class="mb-3" style="width: 100%; margin-bottom: 5px;"> <!-- Reduced margin-bottom -->
                                        <label><b>NEXT VISIT DATE</b></label>
                                        <input type="date" class="form-control text-center" id="next_visit_date" name="next_visit_date">
                                    </div>
                                
                                    <!-- Remarks Section -->
                                    <div style="margin-bottom: 5px;"> <!-- Reduced margin-bottom -->
                                        <label><b>Remark</b></label>
                                        <textarea id="comment" name="comment" rows="10" style="width: 100%; line-height: 1.3; background-color: #EBEFF3; border: none;"></textarea>
                                    </div>
                                
                                    <!-- Total Amount Section -->
                                    <div style="margin-bottom: 5px;"> <!-- Reduced margin-bottom -->
                                        <label for="amount" style="color:white; background-color:#dbb8b3; padding: 5px; display: block;"> <!-- Reduced padding -->
                                            <b>Total Amount</b>
                                        </label>
                                        <input step="100" id="amount" name="amount" type="number" class="form-control" style="background-color:#e3b8b1; border:none;">
                                    </div>
                                
                                    <!-- Buttons Section -->
                                    <div style="display: flex; flex-direction: column; align-items: center; margin-top: 5px;"> <!-- Reduced margin-top -->
                                        <button type="submit" class="btn btn-primary" style="background-color:#4DFF98; height:40px; width: 180px; font-size:18px; color:white; border-radius: 15px; text-shadow: 2px 2px 4px #000000; padding-top: 5px; background-image: linear-gradient(to bottom, #4fdcd7, #52f3bc); margin-bottom: 5px;">FINISH</button> <!-- Reduced margin-bottom -->
                                        <button type="button" class="btn btn-primary" onclick="postData()" style="background-color:#4DFF98; height:40px; width: 180px; font-size:18px; color:white; border-radius: 15px; text-shadow: 2px 2px 4px #000000; padding-top: 5px; background-image: linear-gradient(to bottom, #4fdcd7, #52f3bc);">Print Report</button>
                                    </div>
                                </div>


                    </form>
                    @endforeach
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



<script>
    function postData() {
        var tableData = [];
        var tableOutData = [];
        var tableMedical = [];
        var tableInvesti = [];

        // Loop through the table rows and populate the array
        $('#faqs tbody tr').each(function(index, row) {
            var drugName = $(row).find('td:eq(0)').text().trim();
         var dose = $(row).find('td:eq(1) input').val();
        var period = $(row).find('td:eq(2) input').val();

        // Check if dose and period are not undefined before trimming
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

        // Check if dose and period are not undefined before trimming
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
            
            // Create an object for each row and push it to the array
            var rowData = {
                'medicalTest': medicalTest,
            };

            tableMedical.push(rowData);
        });
        $('#investigationTable tbody tr').each(function(index, row) {
            var investigation = $(row).find('td:eq(0)').text().trim();
            
            // Create an object for each row and push it to the array
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

        // Set the JSON stringified version of tableData
        form.elements['tableData'].value = JSON.stringify(tableData);
        form.elements['tableOutData'].value = JSON.stringify(tableOutData);
        form.elements['tableMedical'].value = JSON.stringify(tableMedical);
        form.elements['tableInvesti'].value = JSON.stringify(tableInvesti);


        form.submit();
    }
</script>

                </div>

            </div>

        </div>
        @endsection
        @include('footer')
</body>

<script>


    $(document).ready(function () {

        $(".select2").select2({});

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
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('openPopup').addEventListener('click', function () {
            document.getElementById('updatePopup').style.display = 'block';
        });
        document.getElementById('closePopup').addEventListener('click', function () {
            document.getElementById('updatePopup').style.display = 'none';
        });
    });
</script>





<!-- outside table -->
<script>
    function addtableout() {
        var data = document.getElementById("outInput").value;

        if (data === "") {
            alert("Drug name is empty");
        } else {
            addoutside(data);
        }
        document.getElementById("outInput").value = "";
    }

    function addoutside(drugName) {
        var table = $('#table2 tbody');
        var newRow =
            '<tr>' +
            '<td style="text-align: left; line-height: 1.3;"><input type="hidden" style="font-size:10px;" name="outsideid[]" class="form-control" value="' + drugName + '">' + drugName + '</td>' +
            '<td><input type="text" style="font-size:10px;" name="outsidedose[]" class="form-control"></td>' +
            '<td><input type="text" style="font-size:10px;" name="outsideperiod[]" class="form-control"></td>' +
            '<td><button type="button" style="font-size:10px;" class="btn-sm btn-danger delete-row">Delete</button></td>' +
            '</tr>';
        table.append(newRow);
    }

</script>



<!-- opdside table -->
<script>
    function addtableopd() {
        var data = document.getElementById("opdInput").value;
        if (data === "") {
            alert("Drug name is empty");
        } else {
            addopd(data);
        }
        document.getElementById("opdInput").value = "";
    }

    function addopd(drugName) {
        var table = $('#faqs tbody');
        var newRow = '<tr>' +
            '<td style="text-align: left; line-height: 1.3;" ><input type="hidden" style="font-size:10px;" name="opdid[]" class="form-control" value="' +
            drugName + '">' + drugName + '</td>' +
            '<td><input type="text" style="font-size:10px;" name="opddose[]" class="form-control" required></td>' +
            '<td><input type="text" style="font-size:10px;" name="opdperiod[]" class="form-control" required></td>' +
            '<td><button type="button" style="font-size:10px;" class="btn-sm btn-danger delete-row">Delete</button></td>' +
            '</tr>';
        table.append(newRow);
    }

</script>

<!-- MedicalTest table -->
<script>
    function addtableMedicaltest() {
        var data = document.getElementById("mediTest").value;
        if (data === "") {
            alert("Medical test name is empty");
        } else {
            addMedicaltable(data);
        }
        document.getElementById("mediTest").value = "";
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

</script>

<!-- Investigation table -->
<script>
    function addtableInvesti() {
        var data = document.getElementById("investi").value;
        if (data === "") {
            alert("Investigation name is empty");
        } else {
            addInvestitable(data);
        }
        document.getElementById("investi").value = "";
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

</script>

<!-- Delete row-->
<script>
    $(document).ready(function () {
        // opd drug table
        $('#faqs').on('click', '.delete-row', function () {
            $(this).closest('tr').remove();
        });

        // outside drug table
        $('#table2').on('click', '.delete-row', function () {
            $(this).closest('tr').remove();
        });

        // medicaltest drug table
        $('#listView').on('click', '.delete-item', function () {
            $(this).closest('tr').remove();
        });
        // Investigation drug table
        $('#investigationTable').on('click', '.delete-item-investi', function () {
            $(this).closest('tr').remove();
        });
    }); 
</script>


</html>