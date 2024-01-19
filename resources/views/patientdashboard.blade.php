
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
            <!--<div>-->
            <!--    @include('sidebar')-->
            <!--</div>-->
            
            @include('flash_message')
            @foreach ($patientDtl as $p)
            <div class="container-fluid">
                <div class="row">
                    <div class="col-9">
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
                                        <span> patient <b>{{ $p->name }}</b>                                         
                                        <button type="button" onclick="submitForm('{{ $p->family_name }}', '{{ $p->id }}')" style="margin-left: 170px; border-radius: 15px; margin-bottom: 0px; background-color:#8ff397; background-image: linear-gradient(to bottom, #ff0055, #fc2ba8); "
        class="btn btn-primary btn-sm"><b>{{ $p->family_name }}</b></button></i>
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
                                        <table>
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

                            <div class="flex-container-extend" style="margin-top: 10px;">
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




                                <div class="p-2">
                                    <div class="mb-3"
                                        style=" margin-bottom: 2px; width: 220px; height:50px; font-size:12px;">
                                        <p><b> NEXT VISIT DATE</b></p>
                                        <input type="date" class="form-control text-center" id="next_visit_date" placeholder=""
                                            name="next_visit_date" value="" style="width: 220px;">


                                    </div>

                                    <div class="p-2"
                                        style="line-height: 1.4; font-size: 13px; height:290px;  width:220px; background-color: #EBEFF3; border: none;">
                                        Remark
                                        <textarea value="" id="comment" name="comment" rows="10" cols="3"
                                            style="line-height: 1.3; height:260px;  width: 210px; background-color: #EBEFF3; border: none;margin-top:1.5px;">
                                             @if($investigationDel->isNotEmpty())
                                             {{ $investigationDel->last()->comment }}
                                        @endif
                                            </textarea>
                                    </div>

                                    <label for="tname"
                                        style="text-align:left ; color:white; background-color:#dbb8b3; height:60px; width: 168px;  margin-top: 20px;margin-right:180px;">
                                        <br><label>Total Amount</label>
                                        
                                        <input step="100" value="" id="amount" name="amount" type="number"
                                            class="form-control"
                                            style="text-align:left ; background-color:#e3b8b1; border:none;" ></label>

                                    <div>
                                        <button type="submit"
                                            style=" background-color:#4DFF98 ; height:40px; width: 180px; font-size:18px;  margin-top: 15px; color:white; border-radius: 15px; text-shadow: 2px 2px 4px #000000; padding-top: 5px; background-image: linear-gradient(to bottom, #4fdcd7, #52f3bc);"
                                            class="btn  btn-primary "><b> FINISH</b></button>
                                            <button type="button" style=" background-color:#4DFF98 ; height:40px; width: 180px; font-size:18px;  margin-top: 15px; color:white; border-radius: 15px; text-shadow: 2px 2px 4px #000000; padding-top: 5px; background-image: linear-gradient(to bottom, #4fdcd7, #52f3bc);"
                                            class="btn  btn-primary " onclick="postData()">Print Report</button>
                                    </div>
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
<script>
    function submitForm(familyName, currentPatientId) {
        // Create a form element
        var form = document.createElement('form');
        form.action = "{{ route('patient_list_by_family_name.search') }}";
        form.method = 'POST';

        // Create hidden input fields
        var csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = "{{ csrf_token() }}";

        var familyNameInput = document.createElement('input');
        familyNameInput.type = 'hidden';
        familyNameInput.name = 'family_name';
        familyNameInput.value = familyName;

        var currentPatientIdInput = document.createElement('input');
        currentPatientIdInput.type = 'hidden';
        currentPatientIdInput.name = 'currentPatientId';
        currentPatientIdInput.value = currentPatientId;

        // Append input fields to the form
        form.appendChild(csrfInput);
        form.appendChild(familyNameInput);
        form.appendChild(currentPatientIdInput);

        // Append the form to the body and submit it
        document.body.appendChild(form);
        form.submit();
    }
</script>


</html>