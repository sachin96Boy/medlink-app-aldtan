<!--///////////////////not using this code.this is a copy///////////////////////////////-->


<!DOCTYPE html>
<html lang="en">

<head> @include('header') <title>Doctor Screen</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>


    <style>
        * {
            box-sizing: border-box;
        }

        .column {
            float: left;
            width: 50%;
            height: 60px;
            border-radius: 8px;
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
            height: 400px;
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
            height: 350px;
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
            margin-left: 10px;
            margin-right: 5px;

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





        */
    </style>
</head>

<body class="g-sidenav-show  bg-gray-100">
    @extends('layouts.app')
    @section('content')
        <div class="container">
            <div class="row">
                <div>
                    @include('sidebar')
                </div>
                <div class="col-12">
                    <div class="col-sm-12"
                        @foreach ($patientDtl as $p)
              style=" background-color: white; height: 60px; border-radius: 12px;  padding-top: 12px; color: black;">
              <div class="row">
                <div class="col-4"><i class="fa fa-user-o" style="font-size:18px;">
                    <span> patient <b>{{ $p->name }}</b> </i>

                  <span><label for="fname" style="text-align:left ; color:white; background-color:#F62101; padding:5px;"><b>{{ $p->family_name }}</b></label></span>
                </div>
                <div class="col-4" style="font-size:18px; padding-left: 80px;">
                  <b>Timer:</b>
                </div>
                <div class="col-2" style="font-size:18px;">
                  <b>{{ date('Y-m-d') }}</b>
                </div>

                <div class="col-2" style="font-size:18px;">
                  <b>{{ date('H:i:s') }}</b> <span><i class="fa fa-bell-o" style="font-size:24px"></i></span>
                </div>
              </div>
            </div>


            <div class="container mt-3">
              <div class="d-flex justify-content-around mb-3">
                <div class="p-3">
                  <button class="btn  btn-primary"
                    style="border-radius: 10px; background-image: linear-gradient(to bottom, #7900ff, #2b8ffc);box-shadow: 1px 5px 1px rgba(0, 0, 0, 0.1);"><i
                      class="fa fa-bar-chart"></i><b>
                      Demogrphic Info</b></button>
                </div>
                <div class="p-3">
                  <button class="btn  btn-primary "
                    style="border-radius: 10px; background-image: linear-gradient(to bottom, #7900ff, #2b8ffc);box-shadow: 1px 5px 1px rgba(0, 0, 0, 0.1);"><i
                      class="fa fa-wpforms"></i><b>
                      Medical History</b></button>
                </div>

                <div class="p-3 ">
                  <button class="btn  btn-primary "
                    style="border-radius: 10px; background-image: linear-gradient(to bottom, #7900ff, #2b8ffc);box-shadow: 1px 5px 1px rgba(0, 0, 0, 0.1);"><i
                      class="fa fa-medkit"></i><b>
                      Drugs history </b></button>
                </div>
                <div class="p-3">
                  <button class="btn  btn-primary "
                    style="border-radius: 10px; background-image: linear-gradient(to bottom, #7900ff, #2b8ffc);box-shadow: 1px 5px 1px rgba(0, 0, 0, 0.1);"><i
                      class="fa fa-envelope-o"></i>
                    <b>Investigation History</b></button>
                </div>
              </div>
            </div>


            <div class="row"
              style="background-color:white; height: 150px;margin-top: 2px; border-radius: 12px; padding-top: 2px; color: black;">
              <div class="column">
                <p><b>Age:</b>  {{ $p->age }}</p>
                <p><b>Weight:</b>   {{ $p->weight }}</p>
                <p><b>Allergies:</b></p>
              </div>
              <div class="column">
                <p><b>Genderr:</b>   {{ $p->gender }}</p>
                <p><b>Address:</b>   {{ $p->address }}</p>
                <p><b>Occupation:</b>   {{ $p->occupation }}</p>

                <span style="position:relative; left:350px; ">

                        <button class="btn btn-primary"
                    style="border-radius: 15px; background-image: linear-gradient(to bottom, #7900ff, #2b8ffc); box-shadow: 1px 5px 1px rgba(0, 0, 0, 0.1);"><i
                      class="fa fa-pencil-square-o"></i><b> EDIT</b></button>
                    </span>
              </div>
            </div>



            </br>


            <div class="col-sm-12">
              <div class="row"
                style=" background-color: white; height: 125px; border-radius: 12px; padding-top: 10px; color: black;">

                <p><b>Last Visit Sumary </b></p>

              </div>
            </div> @endforeach
                        </br>


                        <div class="col-sm-12">
                            <div>
                                <div class="row" tyle="width: 180px; ">
                                    <div class="flex-container-extend">
                                        <div class="p-0" style="width: 180px; height: 380px; background-color: #EBEFF3;">
                                            <b>INVESTIGATION</b>

                                            <select class="form-control" id="patient_name" name="patient_name"
                                                rows="4">
                                                <option value="" selected>Diagnostic Category</option>
                                                @foreach ($diagnostic_categories as $diagnostic)
                                                    <option value="{{ $diagnostic->id }}">{{ $diagnostic->category_name }}
                                                    </option>
                                                @endforeach
                                            </select>


                                        </div>

                                        <div>
                                            <div class="p-2  align-self-start"
                                                style=" width: 170px; height:190px; border: 2px solid white; background-color: #EBEFF3;  margin-top: 1px;">
                                                <b>TREATMENTS</b>
                                                <textarea id="w3review" name="w3review" rows="7" cols="14" style="background-color: #EBEFF3; border: none;"></textarea>
                                            </div>
                                            <div class="p-2 align-self-end"
                                                style="height:190px; width: 170px; border: 2px solid white; background-color: #EBEFF3; ">
                                                <b>MEDICAL TESTS</b>
                                                <textarea id="w3review" name="w3review" rows="7" cols="14" style="background-color: #EBEFF3; border: none;"></textarea>
                                            </div>
                                        </div>

                                        <div class="row"
                                            style="height:380px;  width: 270px; border-style: none; background-color: #EBEFF3;">
                                            <b>OPD
                                                DRUGS</b>

                                            <div class="p-0">

                                                <div class="table-responsive "
                                                    style="font-size:12px;  width: 250px;  height:250px;">

                                                    <table id="faqs">
                                                        <thead>
                                                            <tr>
                                                                <th>Drug name</th>
                                                                <th>Dose</th>
                                                                <th>Period</th>

                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td><input type="select" class="form-control"
                                                                        placeholder=""></td>
                                                                <td><input type="text" placeholder=""
                                                                        class="form-control"></td>
                                                                <td><input type="text" placeholder=""
                                                                        class="form-control"></td>
                                                                <td class="mt-10"><button class="badge badge-danger"><i
                                                                            class="fa fa-trash"></i>
                                                                        Delete</button></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>

                                                <div class="text-center"><button onclick="addfaqs();"
                                                        class="badge badge-success"
                                                        style=" background-color:#978FF3; margin-top:28px; color:white; font-size:12px; border-radius: 15px; text-shadow: 2px 2px 4px #000000; background-image: linear-gradient(to bottom, #7900ff, #2b8ffc); "><i
                                                            class="fa fa-plus"></i> ADD NEW</button></div>
                                            </div>
                                        </div>




                                        <div class="row"
                                            style="height:380px;  width: 270px; border-style: none; background-color: #EBEFF3;">
                                            <b>OUTSIDE
                                                DRUGS</b>

                                            <div class="p-0">

                                                <div class="table-responsive "
                                                    style="font-size:12px;  width: 250px;  height:250px;">

                                                    <table id="table2">
                                                        <thead>
                                                            <tr>
                                                                <th>Drug name</th>
                                                                <th>Dose</th>
                                                                <th>Period</th>

                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td><input type="select" class="form-control"
                                                                        placeholder=""></td>
                                                                <td><input type="text" placeholder=""
                                                                        class="form-control"></td>
                                                                <td><input type="text" placeholder=""
                                                                        class="form-control"></td>
                                                                <td class="mt-10"><button class="badge badge-danger"><i
                                                                            class="fa fa-trash"></i>
                                                                        Delete</button></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>

                                                <div class="text-center"><button onclick="addrowtable();"
                                                        class="badge badge-success"
                                                        style=" background-color:#978FF3; margin-top:28px; color:white; font-size:12px; border-radius: 15px; text-shadow: 2px 2px 4px #000000; background-image: linear-gradient(to bottom, #7900ff, #2b8ffc); "><i
                                                            class="fa fa-plus"></i> ADD NEW</button></div>
                                            </div>
                                        </div>




                                        <div class="p-2 ">
                                            <!-- <div style="height:50px;  width: 200px; background-color:white; margin-top: 1px; "> -->
                                            <button
                                                style=" background-color:#978FF3; width: 200px; height:50px; font-size:12px; border-radius: 15px; text-shadow: 2px 2px 4px #000000; background-image: linear-gradient(to bottom, #7900ff, #2b8ffc); "
                                                class="btn  btn-primary "><b> NEXT VISIT DATE</b></button>
                                            <div class="p-2" style="height:190px; width: 200px;  margin-top: 1px">
                                                <textarea id="w3review" name="w3review" rows="4" cols="10"
                                                    style="height:190px;  width: 200px; background-color: #EBEFF3; border: 1px solid white;">remark

                              </textarea>
                                            </div>
                                            <label for="tname"
                                                style="text-align:left ; background-color:#F62101; height:50px; width: 200px; margin-top: 5px">Total
                                                Amount</label>



                                            <div style="height:20px; width: 200px;  background-color:white;">
                                                <button
                                                    style=" background-color:#4DFF98 ; height:40px; width: 200px; font-size:18px;  margin-top: 5px; color:white; border-radius: 15px; text-shadow: 2px 2px 4px #000000; padding-top: 5px; background-image: linear-gradient(to bottom, #4fdcd7, #52f3bc);"
                                                    class="btn  btn-primary "><b> FINISH</b></button>
                                            </div>

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
        html += '<td><input type="text" class="form-control" placeholder=""></td>';
        html += '<td><input type="text" placeholder="" class="form-control"></td>';
        html += '<td><input type="text" placeholder="" class="form-control"></td>';
        html += '<td class="mt-10"><button class="badge badge-danger" onclick="$(\'#faqs-row' + faqs_row +
            '\').remove();"><i class="fa fa-trash"></i> Delete</button></td>';

        html += '</tr>';

        $('#faqs tbody').append(html);

        faqs_row++;
    }

    var table2_row = 0;

    function addrowtable() {
        html = '<tr id="table2-row' + table2_row + '">';
        html += '<td><input type="text" class="form-control" placeholder=""></td>';
        html += '<td><input type="text" placeholder="" class="form-control"></td>';
        html += '<td><input type="text" placeholder="" class="form-control"></td>';
        html += '<td class="mt-10"><button class="badge badge-danger" onclick="$(\'#table2-row' + table2_row +
            '\').remove();"><i class="fa fa-trash"></i> Delete</button></td>';

        html += '</tr>';

        $('#table2 tbody').append(html);

        table2_row++;
    }
</script>

</html>
