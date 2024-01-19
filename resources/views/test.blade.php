<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $pageName }}</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Custom styles go here */
        body {
            padding-top: 20px;
        }

        .report-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .patient-table {
            width: 100%;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <div class="app">
        <div class="name text-center">
            <h1>Medlink Aldtan</h1>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-5">
                    <div class="report-header">

                        <h2>{{ $pageName }}</h2>
                        @foreach ($patients as $p)
                        <table style="text-align: left; border-collapse: collapse;"">
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
                            </tbody>
                        </table>
                        @endforeach
                    </div>
                </div>
                <div class=" col-md-5">
                            <table style="text-align: left; border-collapse: collapse;"">

                                <tbody>
                                    <tr>
                                        <td>Doctor </td>
                                        <td>: </td>
                                    </tr>
                                    <tr>
                                        <td>Contact Number</td>
                                        <td>: </td>
                                    </tr>
                                    <tr>
                                        <td>Date</td>
                                        <td>: </td>
                                    </tr>
                                </tbody>
                                </table>
                                                </div>
                                            </div>
                                <div class=" row">
                                                                <table class="table table-striped patient-table">
                                    <thead>
                                    <th>Date</th>
                <th>Investigation Category</th>
                <th>Investigation Details</th>
                <th>Treatments</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($selectedValues as $value)
                                        <tr>
                                            <td> {{ $value['date'] }}</td>
                                            <td> {{ $value['categorie'] }}</td>
                                            <td> {{ $value['details'] }}</td>
                                            <td> {{ $value['treatment'] }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                    </div>
                </div>
                                <br>
                <br>
                <p>Signature Of Doctor</p>
<p>Date: {{ now()->format('Y-m-d') }}</p>
            </div>


            <!-- Bootstrap JS and dependencies (jQuery) -->
            <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


            <!-- jsPDF -->
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.5/jspdf.debug.js"></script>
            <!-- html2canvas -->
            <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>



            <script>
                $(document).ready(function () {
                    $('#downloadButton').click(function () {
                        var pdf = new jsPDF('p', 'pt', 'a4');

                        var appElement = $('.app')[0];

                        pdf.fromHTML(appElement, 20, 20, {}, function () {
                            pdf.save('report.pdf');
                        });
                    });
                });
            </script>


</body>

</html>