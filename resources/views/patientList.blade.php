<table id="example1" class="table table-bordered">
    <thead style="position: sticky; top: 0; z-index: 1;">
        <tr style="font-size: 14px; background-color: #4374BE;">
            <th scope="col">ID</th>
            <th scope="col">Family Name</th>
            <th scope="col">Name</th>
            <th scope="col">NIC</th>
            <th scope="col">Mobile</th>
            <th scope="col">Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($patient_list as $patient)
            @php
                $hourDifference = null; // Initialize before the loop
                $appointmentPatientIds = [];
                $appointmentPatienttimes = [];
                $appoinment_list = [];
            @endphp

            @if ($appoinment_list && count($appoinment_list) > 0)
                @php
                    $appointmentPatientIds = $appoinment_list->pluck('patient_id')->toArray();
                    $appointmentPatienttimes = $appoinment_list->pluck('appdateTime')->toArray();
                @endphp
            @endif

            @if (in_array($patient->id, $appointmentPatientIds))
                @php
                    $index = array_search($patient->id, $appointmentPatientIds);
                    $current = \Carbon\Carbon::now();
                    $previous = \Carbon\Carbon::Create($appointmentPatienttimes[$index]);
                    $hourDifference = $previous->diffInHours($current);
                @endphp
            @endif

            <tr style="font-size: 13px;">
                <td>{{ $patient->id }}</td>
                <td>{{ $patient->family_name }}</td>
                <td>{{ $patient->name }}</td>
                <td>{{ $patient->nic }}</td>
                <td>{{ $patient->mobile }}</td>
                <td class="project-actions">
                    <center>
                        @if ($hourDifference < 6 && in_array($patient->id, $appointmentPatientIds))
                            <!-- Disable the Appointment button -->
                            <button class="btn btn-outline-dark" disabled>
                                <a href="{{ route('appointment.add', $patient->id) }}" title="Appointment" class="appointment-link">
                                    <i class="fa fa-stethoscope"></i>Appointment
                                </a>
                            </button>
                        @else
                            <!-- Enable the Appointment button -->
                            <button class="btn btn-outline-dark appbton">
                                <a href="{{ route('appointment.add', $patient->id) }}" title="Appointment" class="appointment-link">
                                    <i class="fa fa-stethoscope"></i>Appointment
                                </a>
                            </button>
                        @endif

                        <a href="{{ route('patienteditviewtable', $patient->id) }}" title="Edit">
                            <button class="btn btn-outline-dark"> <i class="fa fa-edit"></i>Edits</button>
                        </a>
                        <a href="{{ route('patientdelete', $patient->id) }}" title="Delete">
                            <button class="btn btn-outline-danger"> <i class="fa fa-trash"></i>Delete</button>
                        </a>
                        <a href="{{ route('appointment.history', $patient->id) }}" title="History">
                            <button class="btn btn-outline-info"> <i class="fa fa-book"> </i>History</button>
                        </a>
                        <a href="{{ route('barcode', $patient->id) }}" title="History">
                            <button class="btn btn-outline-info"> <i class="fa fa-book"> </i>Barcode</button>
                        </a>
                    </center>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<script>
    // Disable the button when clicked

    $(document).ready(function() {
        var clickCount = 0;



        $(".appbton").on("click", function() {
            $(".appbton").prop("disabled", true);
            clickCount++;

            // Check if the button has been clicked more than once
            if (clickCount > 1) {
                event.preventDefault();
            }

        });

        // Re-enable the button when the page finishes loading
        $(window).on("load", function() {
            $(".appbton").prop("disabled", false);
        });
    });
</script>
