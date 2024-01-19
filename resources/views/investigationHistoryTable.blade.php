<form id="generateForm" action="{{ route('generate.report') }}" method="POST">
    @csrf
    <div class="table-container" style="max-height: 50vh; overflow-y: auto;">

    <table id="example1" class="table table-bordered">
    <thead style="position: sticky; top: 0; z-index: 1;">
        <tr style="font-size: 14px; background-color: #4374BE;">
        <th></th>
            <th scope="col">Date</th>
            <th scope="col">Investigation Category</th>
            <th scope="col">Investigation Details</th>
            <th scope="col">Treatments</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($patients as $p)
            <input type="text" hidden name="id" value="{{ $p->id }}"/>
        @endforeach

        @foreach ($investigation_details as $details)
            <tr style="font-size: 13px;">
            <td><input type="checkbox" id="{{ $details->channel_date }}" name="{{ $details->channel_date }}"
                        value="{{ $details->channel_date }}"></td>
            <td>
    <a href="{{ route('view_appoiment_His_details', ['channel_date' => $details->channel_date, 'patient_id' => $p->id]) }}">
        {{ $details->channel_date }}
    </a>
</td>
                
                <td>
                <ul>
    @foreach($investigation_history as $investi)
        @php
            $investiDate = date('Y-m-d', strtotime($investi->appointment_date));
            $detailsDate = date('Y-m-d', strtotime($details->channel_date));
        @endphp

        @if ($investiDate == $detailsDate)
            <li>{{ $investi->investtigation }} ({{ $investi->appointment_date }})</li>

        @endif
    @endforeach
</ul>


                </td>
                <td>{{ $details->investigation_details }}</td>
                <td>{{ $details->treatment }}</td>

            </tr>
        @endforeach
    </tbody>
</table>
</div>


    <button class="btn btn-outline-dark" type="submit" id="generateButton">Generate</button>
</form>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function () {
        var selectedRows = [];
        var showAlert = true;

        $('input[type="checkbox"]').change(function () {
            var selectedRowData = {
                date: $(this).closest('tr').find('td:eq(1)').text(),
                categorie: $(this).closest('tr').find('td:eq(2)').text(),
                details: $(this).closest('tr').find('td:eq(3)').text(),
                treatment: $(this).closest('tr').find('td:eq(4)').text(),
            };

            if ($(this).is(':checked')) {
                selectedRows.push(selectedRowData);
            } else {
                selectedRows = selectedRows.filter(function (row) {
                    return row.date !== selectedRowData.date;
                });
            }
        });

        $('#generateForm').submit(function (event) {
            if (selectedRows.length === 0 && showAlert) {
                alert("Not selected test");
                showAlert = true; // Set flag to false to prevent further alerts
                event.preventDefault(); // Prevent form submission
            } else {
                var pageName = 'Medical Test Report';

                // Clear any existing hidden input fields with the same name
                $('#generateForm').find('input[name^="selectedRows"]').remove();
                $('#generateForm').find('input[name="pageName"]').remove();

                // Append new hidden input fields
                selectedRows.forEach(function (row, index) {
                    $('#generateForm').append('<input type="hidden" name="selectedRows[' + index + '][date]" value="' + row.date + '">');
                    $('#generateForm').append('<input type="hidden" name="selectedRows[' + index + '][categorie]" value="' + row.categorie + '">');
                    $('#generateForm').append('<input type="hidden" name="selectedRows[' + index + '][details]" value="' + row.details + '">');
                    $('#generateForm').append('<input type="hidden" name="selectedRows[' + index + '][treatment]" value="' + row.treatment + '">');
                    // Add other properties as needed
                });
                $('#generateForm').append('<input type="hidden" name="pageName" value="' + pageName + '">');
            }
        });
    });
</script>
