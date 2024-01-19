<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Drug History Report</title>
     <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>

<body>

    <div class="container mt-5">
        <h4 class="text-center mb-4">Drug History Report</h4>
        
        <a href="{{ url()->previous() }}" <button
                            style="margin-left: 2px; margin-bottom: 7px;border-radius: 30px; background-image: linear-gradient(to bottom, #7900ff, #2b8ffc);"
                            type="button" class="btn  btn-info btn-sm"><b> Back </b></button></a>

        <div class="card">
            <div class="card-body">
                                  


                @foreach ($patients as $p)
                <h5>Patient Information</h5>
                <p><strong>Name:</strong> {{ $p->name }}</p>
                <p><strong>Age:</strong> {{ $p->age }}</p>
                <p><strong>Gender:</strong> {{ $p->gender }}</p>

            <input type="text" hidden name="id" value="{{$p->id}}"/>
                @endforeach
                <hr>

                <h5>Drug History</h5>
<div class="col-12 overflow-scroll" style="background-color:#d1dfec;">
                    <div class="card-body">
                <div class="table-responsive">
                <form id="generateForm" action="{{ route('drug.report') }}" method="POST">
    @csrf
    @foreach ($patients as $p)

            <input type="text" hidden name="id" value="{{$p->id}}"/>
                @endforeach
                                                                    <div class="table-container" style="max-height: 50vh; overflow-y: auto;">

    <table id="example1" class="table table-bordered">
                        <thead style="position: sticky; top: 0; z-index: 1;background-color: #3498db; color: white;">
                            <tr>
                                <th scope="col"></th>
                                <th scope="col">Date</th>
                                <th scope="col">Drug Name</th>
                                <th scope="col">Dosage</th>
                                <th scope="col">Period</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($drug_history as $drug)
                        <tr style="font-size: 13px;">
                            <td><input type="checkbox" id="" name=""
                        value=""></td>
                            <td>{{ $drug->appointment_date }}</td>
                            <td>{{ $drug->drug }}</td>
                            <td>{{ $drug->dose }}</td>
                            <td>{{ $drug->period }}</td>

                        </tr>
                        @endforeach
                        @foreach ($drug_out as $drug)
                        <tr style="font-size: 13px;">
                            <td><input type="checkbox" id="" name=""
                        value=""></td>
                            <td>{{ $drug->appointment_date }}</td>
                            <td>{{ $drug->drug }}</td>
                            <td>{{ $drug->dose }}</td>
                            <td>{{ $drug->period }}</td>

                        </tr>
                        @endforeach
                            <!-- Add more rows as needed -->
                        </tbody>
                    </table>
                    <button class="btn btn-outline-dark" type="submit" id="generateButton">Generate</button>
</div>
                    </form>

                </div>
</div>
</div>
            </div>
        </div>

    </div>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <script>
$(document).ready(function () {
    var selectedRows = [];

    $('input[type="checkbox"]').change(function () {
        var isChecked = $(this).is(':checked');
        var row = $(this).closest('tr');
        var data = {
            name: row.find('td:nth-child(3)').text(), // Assuming the name is in the third column
            dose: row.find('td:nth-child(4)').text(), // Assuming the dose is in the fourth column
            period: row.find('td:nth-child(5)').text() // Assuming the period is in the fifth column
        };

        if (isChecked) {
            selectedRows.push(data);
        } else {
            selectedRows = selectedRows.filter(function (row) {
                return row.name !== data.name;
            });
        }

    });

    $('#generateForm').submit(function (event) {
        event.preventDefault();
        var pageName = 'Drugs Report';

        // Add hidden input fields for each selected row
        selectedRows.forEach(function (row, index) {
            $('#generateForm').append(
                '<input type="hidden" name="selectedRows[' + index + '][name]" value="' + row.name + '">' +
                '<input type="hidden" name="selectedRows[' + index + '][dose]" value="' + row.dose + '">' +
                '<input type="hidden" name="selectedRows[' + index + '][period]" value="' + row.period + '">'
            );
        });
        $('#generateForm').append('<input type="hidden" name="pageName" value="' + pageName + '">');

        // Submit the form
        this.submit();
    });
});
</script>


</body>

</html>

