<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>OPD Drugs</title>

    <style type="text/css">
        body {
            width: 80mm;
            margin: 0;
            padding: 0;
        }
    </style>
</head>

<body>
    <div id="content">

        <p style="text-align: center;"><b>SUWA SEWANA MEDICAL CENTER</b>
            No:78, Badulla Road,Lellopitiya,Rathnapura.<br>
            Hotline:- 045 22 75 111/ 070 62 22 300<br>
            Email:-suwasewanatreat@gmail.com<br>
            ---------------------------------------------------<br>
            <span><b>OPD DRUG REPORT</b></span>
        </p>
        @foreach ($patients as $p)
            <table style="text-align: left; border-collapse: collapse;">
                <thead>
                    <tr>
                        <th< /th>
                            <th></th>
                            <th></th>
                            <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Name of Patient</td>
                        <td colspan="2">: {{ $p->name }}</td>
                    </tr>
                    <tr>
                        <td>Age</td>
                        <td>: {{ $p->age }}</td>
                        <td style="text-align: right;">Date</td>
                        <td>: {{ date('Y-m-d') }}</td>
                    </tr>
                    <tr>
                        <td>Patient No</td>
                        <td>: {{ $p->id }}</td>
                        <td style="text-align: right; padding-left:3px;width: 25%;">Ap Num</td>
                        <td>: {{ $appoi->last()->appointment_no }}</td>
                    </tr>



                </tbody>
            </table>
        @endforeach
        <p style="text-align: center;">---------------------------------------------------</p>

        @if (empty($opdReport1))
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Drug Name</th>
                        <th>Dose</th>
                        <th>Terms</th>
                        <th>Period</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($opdReport as $outdrugs)
                        <tr>
                            <td>{{ $outdrugs->drug }}</td>
                            <td>{{ $outdrugs->dose }}</td>
                            <td>{{ $outdrugs->terms }}</td>
                            <td>{{ $outdrugs->period }}</td>
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
                        <th>Terms</th>
                        <th>Period</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($opdReport1 as $row)
                        <tr>
                            <td>{{ $row['drugName'] }}</td>
                            <td>{{ $row['dose'] }}</td>
                            <td>{{ $row['terms'] }}</td>
                            <td>{{ $row['period'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

        <p style="text-align: center;">---------------------------------------------------</p>
        <table class="px-3">

            <tr>
                <td style="width: 100%; text-align: left;"><span>Charges:- Rs.</span> {{ $amount }}</td>
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


</body>

</html>
