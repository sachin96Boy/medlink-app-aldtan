<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OPD Drugs</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <style>

        /* Add other styles as needed */
    </style>
        <style type="text/css">
            body {
                width: 80mm;
                margin: 0;
                padding: 0;
            }

            body {
                margin: 0;
            }

            #content {
                font-size: 12px;
                padding: 10mm;
            }
        table {
            width: 80%; 
            border-collapse: collapse;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
    <div id="content">
<h5 style="text-align: center;">SUWA SEWANA MEDICAL CENTER</h5>
<p style="text-align: center;"><b>OPD DRUG REPORT</b></p>
@foreach ($patients as $p)
                        <table style="text-align: left; border-collapse: collapse;">
                            <tbody>
                                <tr>
                                    <td style="width: 50%;">Name of Patient</td>
                                    <td style="width: 50%;">: {{$p->name}}</td>
                                </tr>
                                <tr>
                                    <td style="width: 30%;">Age</td>
                                    <td style="width: 70%;">: {{$p->age}}</td>
                                </tr>
                                <tr>
                                    <td style="width: 30%;">Date</td>
                                    <td style="width: 70%;">: {{ date('Y-m-d') }}</td>
                                </tr>
                                    <tr>
                                        <td style="width: 70%;">Patient No</td>
                                    <td style="width: 30%;">: {{$p->id}}</td>
                                    </tr>
                                    
                            </tbody>
                        </table>
                        @endforeach
@if (empty($opdReport1))
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Drug Name</th>
                <th>Dose</th>
                <th>Period</th>
                <th>Terms</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($opdReport as $outdrugs)
                <tr>
                    <td>{{ $outdrugs->drug }}</td>
                    <td>{{ $outdrugs->dose }}</td>
                    <td>{{ $outdrugs->period }}</td>
                    <td>{{ $outdrugs->terms }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@else
        <table class="table table-bordered">
        <thead>
            <tr>
                <th>Drug Name</th>
                <th>Dose</th>
                <th>Period</th>
                <th>Terms</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($opdReport1 as $row)
                <tr>
                    <td>{{ $row['drugName'] }}</td>
                    <td>{{ $row['dose'] }}</td>
                    <td>{{ $row['period'] }}</td>
                     <td>{{ $row['terms'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif


    <table class="px-3">
<tr>

@foreach ($appoi as $ap)
<td style="width: 100%; text-align: right;">  </td>
</tr>
<tr>
<td style="width: 100%; text-align: left;"><span>Appoiment Number</span> :{{$ap->appointment_no}}</td>


</tr>
@endforeach
<tr>
<td style="width: 100%; text-align: right;"><span>Charges:- Rs.</span> {{ $amount }}</td>
</tr>
    </table>
<p style="text-align: center;">© Copyright Medlink. All Rights Reserved</p>
</div>
<script>
    window.onload = function() {
        window.print();

        window.onafterprint = function() {
window.history.back();

        };
    };
</script>


<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>