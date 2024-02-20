<!DOCTYPE html>
<html lang="en">

<head> @include('header') <title></title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        table {
            line-height: 1.4;
            font-size: 13px;
            width: 80%;
            /* Adjust the width as needed */
            border-collapse: collapse;
            margin-top: 20px;
            /* Adjust the top margin as needed */
            margin-left: 20px;
            /* Adjust the top margin as needed */
        }

        th,
        td {
            padding: 8px;
            text-align: left;
        }
    </style>
</head>

<body class="g-sidenav-show  bg-gray-100">
    @extends('layouts.app')
    @section('content')
        <div class="container">
            <div class="row">
                <div class="col-1">
                </div>
                <a href="{{ url()->previous() }}"
                    style="margin-left: 2px; margin-bottom: 7px;border-radius: 30px; background-image: linear-gradient(to bottom, #7900ff, #2b8ffc);width:150px;"
                    type="button" class="btn  btn-info btn-sm"><button><b> Back </b></button></a>
                <center>
                    <h5>Patient Profile</h5>
                </center>
                @foreach ($patients as $p)
                    <div class="col-12 overflow-scroll" style="height: 550px; background-color:#d1dfec;">
                        <form action="{{ route('patient_list_by_family_name.search') }}" method="POST">
                            @csrf
                            <input type="hidden" id="family_name" name="family_name" value="{{ $p->family_name }}">
                            <input type="hidden" id="currentPatientId" name="currentPatientId" value="{{ $p->id }}">
                            <button type="submit"
                                style=" border-radius: 15px; margin-bottom: 0px;  background-color:#8ff397; background-image: linear-gradient(to bottom, #ff0055, #fc2ba8); "
                                class="btn  btn-primary btn-sm "><b> {{ $p->family_name }}</b></button>
                        </form>
                        <table>
                            <thead>
                                <th scope="col"></th>
                                <th scope="col"></th>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Family Name </td>
                                    <td>: {{ $p->family_name }}</td>
                                </tr>
                                <tr>
                                    <td>Name</td>
                                    <td>: {{ $p->name }}</td>
                                </tr>
                                <tr>
                                    <td>Date of Birth</td>
                                    <td>: {{ $p->birthday }}</td>
                                </tr>
                                <tr>
                                    <td>Age</td>
                                    <td>: {{ $p->age }}</td>
                                </tr>
                                <tr>
                                    <td>Address</td>
                                    <td>: {{ $p->address }}</td>
                                </tr>
                                <tr>
                                    <td>Mobile / Whatsapp</td>
                                    <td>: {{ $p->mobile }}</td>
                                </tr>
                                <tr>
                                    <td>Gender</td>
                                    <td>: {{ $p->gender }}</td>
                                </tr>
                                <tr>
                                    <td>Email</td>
                                    <td>: {{ $p->email }}</td>
                                </tr>
                                <tr>
                                    <td>Height</td>
                                    <td>
                                        <label style="font-size: 12px;">Feets</label>: {{ $p->height_feets }}
                                        <label style="font-size: 12px;">Inches</label>: {{ $p->height_inches }}
                                        <label style="font-size: 12px;">Centimeters</label>: {{ $p->height_cen }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Weight</td>
                                    <td>: {{ $p->weight }}</td>
                                </tr>
                                <tr>
                                    <td>NIC</td>
                                    <td>: {{ $p->nic }}</td>
                                </tr>
                                <tr>
                                    <td>Occupation</td>
                                    <td>: {{ $p->occupation }}</td>
                                </tr>
                            </tbody>
                        </table>
                @endforeach


            </div>
        </div>
        </div>
    @endsection
    @include('footer')
</body>

</html>
