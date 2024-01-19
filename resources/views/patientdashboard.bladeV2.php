<!DOCTYPE html>
<html lang="en">

<head> @include('header') <title>Doctor Screen</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
  <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
  <script>
  $( function() {
    $( "#datepicker" ).datepicker();
  } );
  </script>


    <style>
        * {
            box-sizing: border-box;
        }

        .column {
            float: left;
            width: 50%;
            border-radius: 12px;
            border: 2px solid white;
            padding: 2px;
            margin-top: 2px;
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
            line-height: 20px;
            font-size: 16px;
            border-radius: 12px;
            border-style: none;
            /* border: 2px solid #d8dfe9; */
            height: 300px;
        }

        .flex-container-extend>div>div {
            color: black;
            text-align: center;
            height: 350px;
            font-size: 16px;
            border-radius: 12px;
            margin: 5px;

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
            line-height: 1.5rem
        }


        .table,
        .jsgrid .jsgrid-table {
            width: 100%;
            max-width: 100%;
            margin-bottom: 1rem;
            background-color: transparent
        }

        .table thead th,
        .jsgrid .jsgrid-table thead th {
            /* border-top: 0; */
            /* border-bottom-width: 1px; */
            font-weight: 500;
            font-size: .875rem;
            text-transform: uppercase
        }

        .table td,
        .jsgrid .jsgrid-table td {
            font-size: 0.875rem;
            /* padding: .475rem 0.4375rem */
            width: 220px;
        }

        .container-xxl{
            margin-top:0ssssssssspx;
        }
        .popup {
            display: none;
            position: fixed;
            height:20dvh;
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
            right: 10px;g
            cursor: pointer;
        }




        */
    </style>
</head>
<?php

if(isset($_GET["submit"])){

$servername = "89.117.157.1";
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
// Update user ID in the appointment table
$appointmentUpdateQuery = "UPDATE appoinments SET patient_id = $oldUserId WHERE patient_id = $newUserId";
if ($conn->query($appointmentUpdateQuery) === TRUE) {

} else {
   ?><script>alert("error user update")</script><?php
}

 // Update user ID in the patient table
$patientUpdateQuery = "UPDATE patients SET user_id = $oldUserId WHERE user_id = $newUserId ";
if ($conn->query($patientUpdateQuery) === TRUE) {
               ?><script>alert("User ID updated successfully")
                              window.location.href = "https://medlink.aldtan.xyz/home"

               </script>
               <?php

} else {
        ?><script>alert("error user update")</script><?php

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
                <div class="col-12" style="margin-left: 60px;">
                    <div class="col-sm-12"
                        style=" background-color: white;  border-radius: 12px;  padding-top: 12px; color: black;">
                        @foreach ($patientDtl as $p)
                            <div class="popup" id="updatePopup">
        <!-- Close button -->
        <span class="close" id="closePopup">&times;</span>

<form id="updateForm" action="" method="get" autocomplete="off">
            @csrf

            <input type="hidden" name="newUserId" value={{$p->id}}><br>

            <label for="oldUserId">old User ID:</label>
            <input type="text" name="oldUserId" required><br>

        <input type="submit" name="submit" value="Update User ID">
        </form>
    </div>

                            <form action="{{ route('appoinmentfinished', $p->id) }}" method="POST" >
                                @csrf
                                <div class="row">
                                    <div class="col-4"><i class="fa fa-user-o" style="font-size:18px; margin-left:5px;">
                                            <span> patient <b>{{ $p->name }}</b></i>
                                        <span><label for="fname"
                                                style="text-align:left ; color:white; background-color:#F62101; padding:5px; "><b>{{ $p->family_name }}</b></label></span>

                                    </div>
                                    <div class="col-4" style="font-size:18px; padding-left: 80px;">
                                        <b>Timer:</b>
                                    </div>
                                    <div class="col-2" style="font-size:18px;">
                                        <b>{{ date('Y-m-d') }}</b>
                                    </div>

                                    <div class="col-2" style="font-size:18px;">
                                        <b>{{ date('H:i:s') }}</b> <span><i class="fa fa-bell-o"
                                                style="font-size:24px"></i></span>
                                    </div>
                                </div>
                    </div>


                    <div class="container h-1">
                        <div class="d-flex justify-content-around h-1">
                            <div class="p-1">
                                <button class="btn btn-primary btn-sm"
                                    style="border-radius: 15px; margin-bottom: 5px; background-image: linear-gradient(to bottom, #7900ff, #2b8ffc);box-shadow: 1px 5px 1px rgba(0, 0, 0, 0.1);"><b>
                                        Demogrphic Info</b></button>
                            </div>
                            <div class="p-1">
                                <button class="btn btn-primary btn-sm "
                                    style="border-radius: 15px; margin-bottom: 5px; background-image: linear-gradient(to bottom, #7900ff, #2b8ffc);box-shadow: 1px 5px 1px rgba(0, 0, 0, 0.1);"><b>
                                        Medical History</b></button>
                            </div>

                            <div class="p-1">
                                <button class="btn btn-primary btn-sm "
                                    style="border-radius: 15px;margin-bottom: 5px; background-image: linear-gradient(to bottom, #7900ff, #2b8ffc);box-shadow: 1px 5px 1px rgba(0, 0, 0, 0.1);"><b>
                                        Drugs history </b></button>
                            </div>
                            <div class="p-1">
                                <button class="btn btn-primary btn-sm "
                                    style="border-radius: 15px; margin-bottom: 5px; background-image: linear-gradient(to bottom, #7900ff, #2b8ffc);box-shadow: 1px 5px 1px rgba(0, 0, 0, 0.1);">
                                    <b>Investigation History</b></button>
                            </div>
                            <div class="p-1">
                                    <button type="button" class="btn btn-primary btn-sm " id="openPopup"
                                    style="border-radius: 15px; margin-bottom: 5px; background-image: linear-gradient(to bottom, #7900ff, #2b8ffc);box-shadow: 1px 5px 1px rgba(0, 0, 0, 0.1);">
                                    <b>Change user id</b></button>
                            </div>
                        </div>
                    </div>


                    <div class="row h-1"
                        style="background-color:white; margin-left:5px; height: 100px; margin-top: 2px; margin-bottom: 2px; border-radius: 12px; border-height: 0; padding-top: 2px; color: black;">
                        <div class="col-md-6">
                            <p><b>Age:</b> {{ $p->age }}</p>
                            <p><b>Weight:</b> {{ $p->weight }}</p>
                            <p><b>Allergies:</b></p>
                        </div>
                        <div class="col-md-6">
                            <p><b>Gender:</b> {{ $p->gender }}</p>
                            <p><b>Address:</b> {{ $p->address }}</p>
                            <p><b>Occupation:</b> {{ $p->occupation }}
                                <a href="{{ route('patienteditview', ['id' => $p->id]) }}"> <button type="button"
                                        class="btn btn-primary btn-sm"
                                        style="border-radius: 15px; background-image: linear-gradient(to bottom, #7900ff, #2b8ffc); box-shadow: 1px 5px 1px rgba(0, 0, 0, 0.1);margin-left: 320px;"><b>
                                            EDIT</b></button></a>
                            </p>

                        </div>
                    </div>

                    <!--<div class="col-sm-12">-->
                        <div class="row"
                            style=" background-color: #EBEFF3; margin-left:5px; height:60px; margin-top: 5px; margin-bottom: 5px; border-radius: 12px;  padding-top: 10px; color: black;">

                            <p><b>Last Visit Sumary </b></p>

                        <!--</div>-->
                    </div>
                    <div class="col-sm-12">
                        <div>
                            <div class="row" tyle="width: 198px; ">
                                <div class="flex-container-extend">
                                    <div class="p-0" style="width: 198px; height:300px; background-color: #EBEFF3;">
                                        <b>INVESTIGATION</b>

                                        <select class="form-control" id="diagnostic_categories" name="diagnostic_categories"
                                            rows="4">
                                            <option value="" selected>-</option>
                                            @foreach ($diagnostic_categories as $diagnostic)
                                                <option value="{{ $diagnostic->id }}">{{ $diagnostic->category_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div>
                                        <div class="p-2  align-self-start"
                                            style=" width: 180px; height:150px; border: 2px solid white; background-color: #EBEFF3;  margin-top: 1px;">
                                            <b>TREATMENTS</b>
                                            <textarea id="treatment" name="treatment" rows="5" cols="17" style="background-color: #EBEFF3; border: none;"></textarea>
                                        </div>
                                        <div class="p-2 align-self-end"
                                            style="height:150px; width: 180px; border: 2px solid white; background-color: #EBEFF3; ">
                                            <b>MEDICAL TESTS</b>
                                            <textarea id="medicalTest" name="medicalTest" rows="5" cols="17" style="background-color: #EBEFF3; border: none;"></textarea>
                                        </div>
                                    </div>

                                    <div class="row"
                                        style="height:300px;  width: 310px; border-style: none; background-color: #EBEFF3;">
                                        <b>OPD
                                            DRUGS</b>

                                        <div class="p-0">

                                            <div class="table-responsive "
                                                style="font-size:12px;  width: 298px;  height:300px;">

                                                <table id="faqs">
                                                    <thead>
                                                        <tr>
                                                            <th>Drug name </th>
                                                            <th>Dose</th>
                                                            <th>Period</th>

                                                        </tr>
                                                    </thead>
<tbody>
    <!-- Rows with hidden input for unique identifier -->
    <tr id="faqs-row0">
        <input type="hidden" name="faqs_row_id[]" value="0">
        <td> <select class="form-control" id="drug_names" name="drug_names" rows="4">
    <option value="" selected>- Select Drug Name -</option></td>
                    <td><input type="text" name="doseopd[]"  class="form-control"></td>
                    <td><input type="text" name="periodopd[]"  class="form-control"></td>
        <td><button type="button" class="badge badge-danger delete-row" onclick="$('#faqs-row0').remove();"><i class="fa fa-trash"></i> Delete</button></td>
    </tr>
</tbody>

                       </table>

                                                <div class="text-center"><button type="button" onclick="addfaqs();"
                                                        class="badge badge-success"
                                                        style=" background-color:#978FF3; margin-top:28px; color:white; font-size:12px; border-radius: 15px; text-shadow: 2px 2px 4px #000000; background-image: linear-gradient(to bottom, #7900ff, #2b8ffc); "><i
                                                            class="fa fa-plus"></i> ADD NEW</button></div>
                                            </div>


                                        </div>
                                    </div>




                                    <div class="row"
                                        style="height:300px;  width: 310px; border-style: none; background-color: #EBEFF3;">
                                        <b>OUTSIDE
                                            DRUGS</b>

                                        <div class="p-0">

                                            <div class="table-responsive "
                                                style="font-size:12px;  width: 298px;  height:300px;">

                                                <table id="table2">
                                                    <thead>
                                                        <tr>
                                                            <th>Drug name</th>
                                                            <th>Dose</th>
                                                            <th>Period</th>

                                                        </tr>
                                                    </thead>
<tbody>
            <!-- Rows with hidden input for unique identifier -->

                <tr>
                    <input type="hidden" name="row_id[]" >
                    <td><select class="form-control" id="drug_names" name="drug_names" rows="4">
                    <option value="" selected>- Select Drug Name -</option></td>
                    <td><input type="text" name="dose[]"  class="form-control"></td>
                    <td><input type="text" name="period[]"  class="form-control"></td>
                    <td><button type="button" class="badge badge-danger delete-row"><i class="fa fa-trash"></i> Delete</button></td>
                </tr>

        </tbody>
                                                </table>
                                                <div class="text-center"><button type="button" onclick="addrowtable();"
                                                        class="badge badge-success"
                                                        style=" background-color:#978FF3; margin-top:28px; color:white; font-size:12px; border-radius: 15px; text-shadow: 2px 2px 4px #000000; background-image: linear-gradient(to bottom, #7900ff, #2b8ffc); "><i
                                                            class="fa fa-plus"></i> ADD NEW</button></div>
                                            </div>
                                        </div>
                                    </div>




                                    <div class="p-2">
                                        <!-- <div style="height:50px;  width: 200px; background-color:white; margin-top: 1px; "> -->


                                        <p><b> NEXT VISIT DATE</b></p> <input type="text" id="datepicker"

                                            style=" margin-bottom: 1px; width: 190px; height:50px; font-size:12px; border-radius: 15px; text-shadow: 2px 2px 4px #000000; background-image: linear-gradient(to bottom, #7900ff,">
                                        <div class="p-2" style="height:100px; width: 190px;  margin-top: 1px;">
                                            <textarea id="w3review" name="w3review" rows="4" cols="10"
                                                style="height:115px;  width: 184px; background-color: #EBEFF3; border: none;">

                                           </textarea>
                                        </div>

                                        <label for="tname"
                                            style="text-align:left ; background-color:#F62101; height:50px; width: 190px;  margin-top: 20px;">Total
                                            Amount <input type="text" class="form-control" style="text-align:left ; background-color:#F62101; border:none;" id="exampleInput"    </label>


                                            <input type="hidden" name="opdrow" id="opdrow">





                                        <div>
                                            <button type="submit"
                                                style=" background-color:#4DFF98 ; height:40px; width: 188px; font-size:18px;  margin-top: 5px; color:white; border-radius: 15px; text-shadow: 2px 2px 4px #000000; padding-top: 5px; background-image: linear-gradient(to bottom, #4fdcd7, #52f3bc);"
                                                class="btn  btn-primary "><b> FINISH</b></button>
                                        </div>
                                        </form>
                                        @endforeach
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    @endsection
    @include('footer')
</body>


<script>
var faqs_row = 0;

function addfaqs() {
    html = '<tr id="faqs-row' + faqs_row + '">';
    html += '<input type="hidden" name="faqs_row_id[]" value="' + faqs_row + '">';
   html += '<td> <select class="form-control" id="drug_names" rows="4" name="drug_names[]"><option value="" selected>- Select Drug Name -</option></td>';
        html += '<td><input type="text" placeholder="" class="form-control"></td>';
        html += '<td><input type="text" placeholder="" class="form-control"></td>';
    html += '<td class="mt-10"><button type="button" class="badge badge-danger" onclick="$(\'#faqs-row' + faqs_row +
        '\').remove();"><i class="fa fa-trash"></i> Delete</button></td>';

    html += '</tr>';

    $('#faqs tbody').append(html);

    faqs_row++;
    document.getElementById('opdrow').value = JSON.stringify(Array.from({ length: faqs_row }, (_, i) => i + 1));
}




var table2_row = 0;

    function addrowtable() {
        html = '<tr id="table2-row' + table2_row + '">';
        html += '<td><select class="form-control" id="drug_names" rows="4" name="drug_names[]"><option value="" selected>- Select Drug Name -</option></td>';
    html += '<td><input type="text" placeholder="" class="form-control" name="dose[]"></td>';
    html += '<td><input type="text" placeholder="" class="form-control" name="period[]"></td>';
        html += '<td class="mt-10"><button type="button" class="badge badge-danger" onclick="$(\'#table2-row' + table2_row +
            '\').remove();"><i class="fa fa-trash"></i> Delete</button></td>';

        html += '</tr>';

        $('#table2 tbody').append(html);

        table2_row++;
        document.getElementById('outrow').value = JSON.stringify(Array.from({ length: table2_row }, (_, i) => i + 1));

    }



     $(document).on('click', '.delete-row', function () {
        $(this).closest('tr').remove();
    });

    </script>
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

</html>
