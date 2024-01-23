
  
  
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
        @if (count($appoinment_list) > 0)
            @php
                $hourDifference = null; // Initialize before the loop
            @endphp

            @if (count($appoinment_list) > 0)
                @php
                    $appointmentPatientIds = $appoinment_list->pluck('patient_id')->toArray();
                    $appointmentPatienttimes = $appoinment_list->pluck('appdateTime')->toArray();
                @endphp

                @if (in_array($patient->id, $appointmentPatientIds))
                    @php
                        $index = array_search($patient->id, $appointmentPatientIds);
                        $current = \Carbon\Carbon::now();
                        $previous = \Carbon\Carbon::Create($appointmentPatienttimes[$index]);
                        $hourDifference = $previous->diffInHours($current);
                    @endphp
                @endif
            @endif

            <tr style="font-size: 13px;">
                <td>{{ $patient->id }}</td>
                <td>{{ $patient->family_name }}</td>
                <td>{{ $patient->name }}</td>
                <td>{{ $patient->nic }}</td>
                <td>{{ $patient->mobile }}</td>
                <td class="project-actions">
                    <center>
                        @if ($hourDifference < 1 && in_array($patient->id, $appointmentPatientIds))
                            <!-- Disable the Appointment button -->
                            <button class="btn btn-outline-dark" id="appbton" disabled>
                                <i class="fa fa-stethoscope"></i>Appointment
                            </button>
                        @else
                            <!-- Enable the Appointment button -->
                            <a href="{{ route('appointment.add', $patient->id) }}" title="Appointment">
                                <button class="btn btn-outline-dark" id="appbton">
                                    <i class="fa fa-stethoscope"></i>Appointment
                                </button>
                            </a>
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
                                </center>
                            </td>
                        </tr>
                   @else
                   <tr style="font-size: 13px;">
                            <td>{{ $patient->id }}</td>
                            <td>{{ $patient->family_name }}</td>
                            <td>{{ $patient->name }}</td>
                            <td>{{ $patient->nic }}</td>
                            <td>{{ $patient->mobile }}</td>
                                                <td class="project-actions ">
                        <div class="d-flex flex-column align-items-center flex-lg-row gap-2">
                            <div class="d-flex flex-row gap-2"><a
                                    href="{{ route('patienteditviewtable', $patient->id) }}" title="Edit">
                                    <button class="btn btn-outline-dark"> <i class="fa fa-edit"></i>Edit</button>
                                </a>
                                <a href="{{ route('patientdelete', $patient->id) }}" title="Delete">
                                    <button class="btn btn-outline-danger"> <i class="fa fa-trash"></i>Delete</button>
                                </a>
                            </div>
                            <div class="d-flex flex-row gap-2">
                                <a href="{{ route('appointment.add', $patient->id) }}" title="Appointment">
                                    <button class="btn btn-outline-dark"> <i
                                            class="fa fa-stethoscope"></i>Appointment</button>
                                </a>
                                <a href="{{ route('appointment.history', $patient->id) }}" title="History">
                                    <button class="btn btn-outline-info"> <i class="fa fa-book"> </i>History</button>
                                </a>
                            </div>
                        </div>
                    </td>
                        </tr>
                   @endif
                @endforeach
            </tbody>
        </table>
