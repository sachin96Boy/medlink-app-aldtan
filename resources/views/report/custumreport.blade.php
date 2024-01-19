<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upcoming Patients Report</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Custom styles go here */
        body {
            padding-top: 50px;
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
    <div class="container">
        <div class="report-header">
            <h2>Upcoming Patients Report</h2>
            <p>Selected Period: [Your Selected Period]</p>
        </div>

        <table class="table table-striped patient-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Appointment Date</th>
                    <th>Doctor</th>
                </tr>
            </thead>
            <tbody>
                <!-- Sample Data, replace with dynamic data from your backend -->
                <tr>
                    <td>1</td>
                    <td>John Doe</td>
                    <td>2023-11-21</td>
                    <td>Dr. Smith</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Jane Doe</td>
                    <td>2023-11-22</td>
                    <td>Dr. Johnson</td>
                </tr>
                <!-- Add more rows as needed -->
            </tbody>
        </table>
    </div>

    <!-- Bootstrap JS and dependencies (jQuery) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
