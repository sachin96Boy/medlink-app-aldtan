<form id="generateForm" action="{{ route('generate.report') }}" method="POST">
    @csrf
                                                        <div class="table-container" style="max-height: 50vh; overflow-y: auto;">
    <table id="example1" class="table table-bordered">
        <thead style="position: sticky; top: 0; z-index: 1;">
            <tr style="font-size: 14px; background-color: #4374BE;">
                <th scope="col"></th>
                <th scope="col">Date</th>
                <th scope="col">Medical Tests</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($patients as $p)
            <input type="text" hidden name="id" value="{{$p->id}}"/>
            @endforeach
            @foreach ($medical_history as $history)
            <tr style="font-size: 13px;">
                <td><input type="checkbox" id="{{ $history->medical_test }}" name="{{ $history->medical_test }}"
                        value="{{ $history->medical_test }}"></td>
                <td>{{ $history->appointment_date }}</td>
                <td>{{ $history->medical_test }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <button class="btn btn-outline-dark" type="submit" id="generateButton">Generate</button>
    </div>
</form>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
$(document).ready(function () {
    var selectedValues = [];
    var showAlert = true;

    $('input[type="checkbox"]').change(function () {
        var selectedValue = $(this).val();

        if ($(this).is(':checked')) {
            selectedValues.push(selectedValue);
        } else {
            selectedValues = selectedValues.filter(function (value) {
                return value !== selectedValue;
            });
        }
    });

    $('#generateForm').submit(function (event) {
        if (selectedValues.length === 0 && showAlert) {
            alert("Not selected test");
            showAlert = true; // Set flag to false to prevent further alerts
            event.preventDefault(); // Prevent form submission
        } else {
            var pageName = 'Medical Test Report';

            // Clear any existing hidden input fields with the same name
            $('#generateForm').find('input[name^="selectedValues"]').remove();
            $('#generateForm').find('input[name="pageName"]').remove();

            // Append new hidden input fields
            selectedValues.forEach(function (value, index) {
                $('#generateForm').append('<input type="hidden" name="selectedValues[]" value="' + value + '">');
            });
            $('#generateForm').append('<input type="hidden" name="pageName" value="' + pageName + '">');
        }
    });
});

</script>