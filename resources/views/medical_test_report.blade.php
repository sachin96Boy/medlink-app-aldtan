<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Treatment</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

</head>
<body>
<h1 style="text-align: center;">MEDLINK ALDTAN</h1>

<h4 style="text-align: center;"><b>MEDICAL TEST REPORT</b></h4>
@foreach ($patients as $p)
<table style="width:100%">
    <thead >
        <th style="width:50%"></th>
        <th style="width:50%"></th>
    </thead>
    <tbody>
        <tr>
            <td>
            <table style="width: 100%; text-align: left; border-collapse: collapse;">
            <tbody>
                <tr>
                    <td>Name</td>
                    <td>: {{$p->name}}</td>
                </tr>
                <tr>
                    <td>Age</td>
                    <td>: {{$p->age}}</td>
                </tr>
                <tr>
                    <td>Gender</td>
                    <td>: {{$p->gender}}</td>
                </tr>
                <tr>
                    <td>Date</td>
                    <td>: {{ date('Y-m-d') }}</td>
                </tr>
            </tbody>
        </table>
            </td>
            <td>
            <table style="width: 100%; text-align: left; border-collapse: collapse;">
            <tbody>
                <tr>
                    <td>Doctor</td>
                    <td>: Dr. {{ Auth::user()->name }}</td>
                </tr>
                <tr>
                    <td>Contact Number</td>
                    <td>: {{ Auth::user()->number }}</td>
                </tr>
                <tr>
                    <td>id</td>
                    <td>: {{ Auth::user()->mid }}</td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td>: {{ Auth::user()->email }}</td>
                </tr>
            </tbody>
        </table>
            </td>
        </tr>
        
    </tbody>
</table>
                        @endforeach
    <table class="table table-bordered">
        <thead>
            <tr>
            <th>Test Name</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tableMedical as $row)
                <tr>
                    <td>{{ $row['medicalTest'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <table style="width: 100%;" class="px-3">
<tr>
<td style="width: 100%; text-align: right;">  </td>
</tr>
<tr>
<td style="width: 100%; text-align: right;">

<br>
<br>
..........................</td>
</tr>
<tr>
<td style="width: 100%; text-align: right;"> Doctor in Charge</td>
</tr>
    </table>
    
    
        <footer>
    <div class="copyright">
                &copy; Copyright <strong><span>Medlink</span></strong>. All Rights Reserved
            </div>
    </footer>
<!-- Latest compiled and minified JavaScript -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>