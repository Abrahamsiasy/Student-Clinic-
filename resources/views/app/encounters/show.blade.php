@extends('layouts.app')

@section('content')
    <div class="">
        <div class="card card-primary card-outline">

            <div class="card-header">
                @if (isset($danger_message))
                    <div class="alert alert-danger">
                        {{ $danger_message }}
                    </div>
                @endif

                <div>
                    @php
                        $statusDetails = [
                            STATUS_COMPLETED => [
                                'name' => 'Encounter Closed',
                                'description' => 'The patient\'s appointment is confirmed but not yet attended.',
                                'color' => 'btn-outline-primary',
                            ],
                            STATUS_CHECKED_IN => [
                                'name' => 'Accepted by Reception',
                                'description' => 'The patient has arrived at the clinic and registered their presence.',
                                'color' => 'btn-outline-success',
                            ],
                            STATUS_IN_PROGRESS => [
                                'name' => 'Called by the Doctor',
                                'description' => 'The patient is currently being seen by a healthcare provider.',
                                'color' => 'btn-outline-info',
                            ],
                            STATUS_MISSED => [
                                'name' => 'Missed and Closed',
                                'description' => 'The patient did not show up for their scheduled appointment.',
                                'color' => 'btn-outline-danger',
                            ],
                            STATUS_RESCHEDULED => [
                                'name' => 'Rescheduled',
                                'description' => 'The appointment was rescheduled for a future date.',
                                'color' => 'btn-outline-warning',
                            ],
                            STATUS_WAITING => [
                                'name' => 'Waiting',
                                'description' => 'The patient is waiting to be called for their appointment.',
                                'color' => 'btn-outline-secondary',
                            ],
                            STATUS_ON_HOLD => [
                                'name' => 'On Hold',
                                'description' => 'The patient is temporarily on hold (e.g., waiting for test results).',
                                'color' => 'btn-outline-secondary',
                            ],
                            STATUS_TEST_PENDING => [
                                'name' => 'Test Pending',
                                'description' => 'Test or lab results are pending.',
                                'color' => 'btn-outline-secondary',
                            ],
                            STATUS_TEST_AVAILABLE => [
                                'name' => 'Test Available',
                                'description' => 'Test or lab results are available for review.',
                                'color' => 'btn-outline-success',
                            ],
                            STATUS_TEST_REVIEWED => [
                                'name' => 'Test Reviewed',
                                'description' => 'Test or lab results have been reviewed by a healthcare provider.',
                                'color' => 'btn-outline-success',
                            ],
                            STATUS_FOLLOW_UP_SCHEDULED => [
                                'name' => 'Follow-up Scheduled',
                                'description' => 'A follow-up appointment is scheduled.',
                                'color' => 'btn-outline-primary',
                            ],
                            STATUS_FOLLOW_UP_COMPLETED => [
                                'name' => 'Follow-up Completed',
                                'description' => 'The follow-up appointment has been completed.',
                                'color' => 'btn-outline-success',
                            ],
                            // ... Add details for other status values ...
                        ];
                    @endphp



                    <style>
                        .notification-badge {
                            animation: blinkAnimation 0.5s infinite;
                            /* Blinking animation */
                            color: red;
                        }

                        .notification-badge:hover {
                            animation: none;
                            /* Stop the animation on hover */
                        }

                        @keyframes blinkAnimation {
                            0% {
                                opacity: 1;
                            }

                            50% {
                                opacity: 0;
                            }

                            100% {
                                opacity: 1;
                            }
                        }
                    </style>


                    <div id="accordion">
                        <div class="card">
                            <div class="card-header" id="headingOne">
                                <h5 class="mb-0">

                                    <button class="btn btn-defult btn btn-link collapsed" data-toggle="collapse"
                                        data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne"
                                        style="font-size: 15px;">
                                        <i class="fa fa-user"> </i> <u> {{ $encounter->student->fullName ?? '-' }}'s
                                        </u>Visiting Histoty[ {{ $encounter->count() }}]
                                    </button>


                                    <button class="btn float-right" data-toggle="collapse" data-target="#collapseOne"><i
                                            class="fa fa-angle-down"></i></button>


                                </h5>
                            </div>



                            <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="card col-md-12 mb-2" style="border-radius:1%; border-top-width:2px;">

                                            <ul class="nav nav-pills">
                                                @can('view-any', App\Models\Encounter::class)
                                                    <li class="nav-item"><a class="nav-link" href="#encounters"
                                                            data-toggle="tab">Encounters</a>
                                                    </li>
                                                @endcan
                                                @can('view-any', App\Models\MedicalRecord::class)
                                                    <li class="nav-item"><a class="nav-link" href="#medical-records"
                                                            data-toggle="tab">Medical Diagnosis </a>
                                                    </li>
                                                @endcan

                                                @can('view-any', App\Models\VitalSign::class)
                                                    <li class="nav-item"><a class="nav-link" href="#vital-signs"
                                                            data-toggle="tab">Vital Signs</a></li>
                                                @endcan

                                                @can('view-any', App\Models\MainDiagnosis::class)
                                                    <li class="nav-item"><a class="nav-link" href="#main-diagnoses"
                                                            data-toggle="tab">Laboratory</a>
                                                    </li>
                                                @endcan

                                                @can('view-any', App\Models\MedicalRecord::class)
                                                    <li class="nav-item"><a class="nav-link" href="#medicalRecords"
                                                            data-toggle="tab">Clinical Notes</a></li>
                                                @endcan
                                            </ul>

                                            <div class="tab-content">
                                                @can('view-any', App\Models\Encounter::class)
                                                    <div class="tab-pane" id="encounters">
                                                        <div class="card mt-4">
                                                            <div class="card-body">

                                                                <table class="table table-sm table-striped">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>#</th>
                                                                            <th>Date of visit</th>
                                                                            <th>Student</th>
                                                                            <th>Health Officer</th>
                                                                            <th>Status</th>
                                                                            <th>Sick leave</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>

                                                                        @foreach ($encounters->sortByDesc('created_at') as $index => $encounter)
                                                                            <tr>
                                                                                <td>{{ $encounter->id }}</td>
                                                                                <td>
                                                                                    {{ $encounter->created_at?->format('d M Y') ?? '-' }}
                                                                                </td>
                                                                                <td>{{ $encounter->student->fullName }}</td>
                                                                                <td>{{ $encounter?->doctor->name ?? '-' }}</td>
                                                                                <td>
                                                                                    @if ($encounter->status == 3)
                                                                                        Closed
                                                                                    @elseif ($encounter->status == 4)
                                                                                        Missed
                                                                                    @elseif ($encounter->status == 2)
                                                                                        In-progress
                                                                                    @else
                                                                                        <span
                                                                                            class="badge badge-primary">Checked-in</span>
                                                                                    @endif
                                                                                <td>
                                                                                    <a href="{{ route('printSickLeave', ['encounterId' => $encounter->id]) }}"
                                                                                        class="btn btn-sm d-inline-block btn-outline-primary mr-3"
                                                                                        target="_blank">
                                                                                        <i class="fas fa-print"></i> Print
                                                                                    </a>


                                                                                    @can('view', $encounter)
                                                                                        <a
                                                                                            href="{{ route('encounters.show', $encounter) }}">
                                                                                            <button type="button"
                                                                                                class="btn btn-sm btn-outline-primary mx-1">
                                                                                                <i class="icon fa fa-list"></i>
                                                                                                Details
                                                                                            </button>
                                                                                        </a>
                                                                                    @endcan



                                                                                </td>
                                                                            </tr>
                                                                        @endforeach
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endcan


                                                @can('view-any', App\Models\MedicalRecord::class)
                                                    <div class="tab-pane" id="medical-records">
                                                        <div class="card mt-4">
                                                            <div class="card-body">



                                                                <table class="table table-sm table-striped">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>#</th>
                                                                            <th>Date of visit</th>
                                                                            <th>Main diagnosis</th>
                                                                            <th>Health Officer</th>
                                                                            <!-- Add more columns as needed -->
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>


                                                                        @foreach ($student->encounter->sortByDesc('created_at') as $index => $enc)
                                                                            <tr>
                                                                                <td colspan="9">
                                                                                    <b>{{ ucwords(strtolower($student->fullName)) }}</b>,

                                                                                    &nbsp;Visit date:
                                                                                    {{ optional($enc->created_at)->format('d M Y') ?? '-' }}
                                                                                </td>
                                                                            </tr>

                                                                            @if ($enc->mainDiagnoses)
                                                                                @foreach ($enc->mainDiagnoses as $maindiagnosis)
                                                                                    <tr>

                                                                                        <td> {{ $loop->index + 1 }} </td>
                                                                                        <td>

                                                                                            {{ $maindiagnosis->encounter->created_at?->format('d M Y') ?? '-' }}

                                                                                        </td>
                                                                                        <td>{{ $maindiagnosis->diagnosis->name ?? '-' }}
                                                                                        </td>
                                                                                        <td>{{ $maindiagnosis->encounter?->doctor->name ?? '-' }}
                                                                                        </td>
                                                                                    </tr>
                                                                                @endforeach
                                                                            @endif
                                                                        @endforeach
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endcan

                                                @can('view-any', App\Models\VitalSign::class)
                                                    <div class="tab-pane" id="vital-signs">
                                                        <div class="card mt-4">
                                                            <div class="card-body">
                                                                <table class="table table-sm table-striped">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>#</th>
                                                                            <th>Date of visit</th>
                                                                            <th>Temprature</th>
                                                                            <th>Blood Pressure</th>
                                                                            <th>Pulse rate </th>
                                                                            <th>RR </th>
                                                                            <th>Weight</th>
                                                                            <th>Height</th>
                                                                            <th>MUAC</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>



                                                                        @foreach ($student->encounter->sortByDesc('created_at') as $index => $enc)
                                                                            <tr>
                                                                                <td colspan="9">
                                                                                    <b>{{ ucwords(strtolower($student->fullName)) }}</b>,

                                                                                    &nbsp;Visit date:
                                                                                    {{ optional($enc->created_at)->format('d M Y') ?? '-' }}
                                                                                </td>
                                                                            </tr>

                                                                            @if ($enc->vitalSigns)
                                                                                @foreach ($enc->vitalSigns as $vitalSign)
                                                                                    <tr>

                                                                                        <td> {{ $loop->index + 1 }} </td>
                                                                                        <td> {{ $vitalSign->encounter->created_at?->format('d M Y') ?? '-' }}
                                                                                        </td>

                                                                                        <td>{{ $vitalSign->temp ?? '-' }}</td>
                                                                                        <td>{{ $vitalSign->blood_pressure ?? '-' }}
                                                                                        </td>
                                                                                        <td>{{ $vitalSign->pulse_rate ?? '-' }}
                                                                                        </td>
                                                                                        <td>{{ $vitalSign->rr ?? '-' }}</td>
                                                                                        <td>{{ $vitalSign->weight ?? '-' }}
                                                                                        </td>
                                                                                        <td>{{ $vitalSign->height ?? '-' }}
                                                                                        </td>
                                                                                        <td>{{ $vitalSign->muac ?? '-' }}</td>


                                                                                    </tr>
                                                                                @endforeach
                                                                            @endif
                                                                        @endforeach

                                                                    </tbody>
                                                                </table>

                                                            </div>
                                                        </div>
                                                    </div>
                                                @endcan




                                                @can('view-any', App\Models\LabTestRequest::class)
                                                    <div class="tab-pane" id="main-diagnoses">
                                                        <div class="card mt-4">
                                                            <div class="card-body">


                                                                <table class="table table-sm table-striped">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>#</th>
                                                                            <th>Date of visit</th>
                                                                            <th>Lab</th>
                                                                            <th>Result</th>

                                                                            <th> Comment </th>
                                                                            <th> Order on </th>
                                                                            <th>Sample ID</th>
                                                                            <th>Order by </th>
                                                                            <th>Lab Technician </th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>






                                                                        @if ($student->encounter)
                                                                            @foreach ($student->encounter->sortByDesc('created_at') as $index => $enc)
                                                                                <tr>
                                                                                    <td colspan="9">
                                                                                        <b>{{ ucwords(strtolower($student->fullName)) }}</b>,

                                                                                        &nbsp;Encounter Date:
                                                                                        {{ optional($enc->created_at)->format('d M Y') ?? '-' }}
                                                                                    </td>
                                                                                </tr>


                                                                                @foreach ($enc->labRequests as $labTestRequest)
                                                                                    <tr>

                                                                                        <td> {{ $loop->index + 1 }} </td>
                                                                                        <td> {{ $labTestRequest->encounter->created_at?->format('d M Y') ?? '-' }}
                                                                                        </td>
                                                                                        <td>{{ $labTestRequest->labTest->test_name ?? '-' }}
                                                                                        </td>
                                                                                        <td>{{ $labTestRequest->result ?? '-' }}
                                                                                        </td>

                                                                                        <td>{{ $labTestRequest->comment ?? '-' }}
                                                                                        </td>
                                                                                        <td>{{ $labTestRequest->ordered_on ?? '-' }}
                                                                                        </td>
                                                                                        <td>{{ $labTestRequest->sample_id ?? '-' }}
                                                                                        </td>
                                                                                        <td>{{ $labTestRequest->encounter->doctor->name ?? '-' }}
                                                                                        </td>
                                                                                        <td>{{ $labTestRequest->sample_collected_by_id ?? '-' }}
                                                                                        </td>

                                                                                    </tr>
                                                                                @endforeach
                                                                            @endforeach
                                                                        @endif
                                                                    </tbody>
                                                                </table>

                                                            </div>
                                                        </div>
                                                    </div>
                                                @endcan

                                                @can('view-any', App\Models\MedicalRecord::class)
                                                    <div class="tab-pane" id="medicalRecords">
                                                        <div class="card mt-4">
                                                            <div class="card-body">



                                                                <table class="table table-sm table-striped">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>#</th>

                                                                            <th>subjective</th>
                                                                            <th>Objective </th>
                                                                            <th>Assessment</th>
                                                                            <th>Plan </th>

                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        @if ($student->encounter)
                                                                            @foreach ($student->encounter->sortByDesc('created_at') as $index => $enc)
                                                                                <tr>
                                                                                    <td colspan="9">
                                                                                        <b>{{ ucwords(strtolower($student->fullName)) }}</b>,

                                                                                        &nbsp;Encounter Date:
                                                                                        {{ optional($enc->created_at)->format('d M Y') ?? '-' }}
                                                                                    </td>
                                                                                </tr>


                                                                                @foreach ($enc->medicalRecords as $medicalRecord)
                                                                                    <tr>

                                                                                        <td> {{ $loop->index + 1 }} </td>

                                                                                        <td>{{ $medicalRecord->subjective ?? '-' }}
                                                                                        </td>
                                                                                        <td>{{ $medicalRecord->objective ?? '-' }}
                                                                                        </td>

                                                                                        <td>{{ $medicalRecord->assessment ?? '-' }}
                                                                                        </td>
                                                                                        <td>{{ $medicalRecord->plan ?? '-' }}
                                                                                        </td>


                                                                                    </tr>
                                                                                @endforeach
                                                                            @endforeach
                                                                        @endif
                                                                    </tbody>
                                                                </table>

                                                            </div>
                                                        </div>
                                                    </div>
                                                @endcan
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>

                    </div>

                    {{-- <span class="badge {{ $statusDetails[$encounter->status]['color'] ?? 'badge-secondary' }}"> <i
                            class="fas fa-list"></i><span style="font-size: 15px;">
                            {{ $statusDetails[$encounter->status]['name'] ?? '-' }} encounter
                        </span> 
                    </span>

                    <div
                        class="btn btn-sm btn-outline-{{ $statusDetails[$encounter->status]['color'] ?? 'badge-secondary' }}">
                        <i class="fas fa-door-open"></i>{{ $encounter?->Doctor?->clinicUsers?->room?->name }}
                    </div> --}}

                    <!-- Status Description (Hidden) -->
                    {{-- {{ $statusDetails[$encounter->status]['description'] ?? '-' }} --}}
                </div>

                <div class="card-tools">
                    <div class="row ">

                        <div class="small-1 float-right d-inline-block">
                            {{-- @can('update', $encounter) --}}
                            {{-- <a href="{{ route('medical-sick-leaves.show', $encounter) }}"> --}}


                            @if ($encounter->arrived_at == null)
                                <button type="button" class="btn btn-sm d-inline-block btn-outline-primary mr-3"
                                    data-toggle="modal" data-target="#confirmationModal"
                                    data-record-id="{{ $encounter->id }}"><i class="fa fa-user-minus"></i> <b>Missing? </b>
                                </button>
                            @endif
                            @if ($encounter->arrived_at != null)
                                <a href="{{ route('encounters.index') }}"
                                    class="btn btn-sm d-inline-block btn-outline-primary mr-3">

                                    <i class="fa fa-arrow-left" aria-hidden="true"></i>

                                    Back</a>
                                <button type="button" class="btn btn-sm btn-outline-primary mx-1" data-toggle="modal"
                                    data-target="#medicalSickLeaveModal">
                                    <i class="fa fa-print"></i> Sick Leave
                                </button>
                                {{-- </a> --}}
                                {{-- @endcan  --}}
                                <form action="{{ route('encounters.callNext', ['encounter' => $encounter]) }}"
                                    method="POST" class="d-inline-block">
                                    @csrf
                                    <input type="hidden" name="status" value="{{ $encounter->status }}">
                                    <button type="submit" class="btn btn-sm btn-outline-primary"><i
                                            class="fas fa-step-forward"></i>Call Next</button>
                                </form>

                                <button type="button" class="btn btn-sm d-inline-block btn-outline-primary"
                                    data-toggle="modal" data-target="#roomChangeModal">
                                    <i class="fas fa-door-open"></i></i>&nbsp;Change Room
                                </button>
                                {{-- @dd($encounter->Doctor->rooms) --}}
                                <button type="button" class="btn btn-sm d-inline-block btn-outline-primary"
                                    data-toggle="modal" data-target="#changeDoctorModal">
                                    <i class="fas fa-exchange-alt"></i>
                                    &nbsp;Handover
                                </button>
                                <form
                                    action="{{ route('encounters.closeEencounter', ['encounter' => $encounters->last()]) }}"
                                    method="POST" class="d-inline-block">
                                    @csrf
                                    <input type="hidden" name="status" value="{{ $encounters->last()->status }}">
                                    <button type="submit" class="btn btn-sm btn-outline-primary"> <i
                                            class="fa fa-check"></i>
                                        Close Encounter</button>
                                </form>

                                <form
                                    action="{{ route('encounters.termniateEencounter', ['encounter' => $encounters->last()]) }}"
                                    method="POST" class="d-inline-block">
                                    @csrf
                                    <input type="hidden" name="status" value="{{ $encounters->last()->status }}">
                                    <button type="submit" class="btn btn-sm btn-outline-primary"> <i
                                            class="fa fa-check"></i>
                                        Terminate Encounter</button>
                                </form>


                                @if ($encounter->status == 4)
                                    <button type="button" class="btn btn-sm d-inline-block btn-outline-primary mr-3"
                                        data-toggle="modal" data-target="#confirmationModal"
                                        data-record-id="{{ $encounter->id }}"><i class="fa fa-user-minus"></i>
                                        Re-accept
                                    </button>
                                @else
                                    <button type="button" class="btn btn-sm d-inline-block btn-outline-primary mr-1"
                                        data-toggle="modal" data-target="#confirmationModal"
                                        data-record-id="{{ $encounter->id }}"><i class="fa fa-user-minus"></i> Missing?
                                    </button>
                                @endif
                            @endif


                        </div>

                        <span>
                            @if ($encounters->last()->arrived_at === null)
                                <form method="post" action="{{ route('toggleArrival') }}" class="form-inline">
                                    @csrf
                                    <input type="hidden" name="encounter_id" value="{{ $encounters->last()->id }}">

                                    <button type="submit"
                                        class="btn btn-sm d-inline-block btn-outline-primary mr-1 notification-badge">
                                        <i class="fa fa-wheelchair"></i><b> Did you meet patient?, Yes</b>
                                    </button>


                                </form>
                            @else
                                <form method="post" action="{{ route('toggleArrival') }}" class="form-inline">
                                    @csrf
                                    <input type="hidden" name="encounter_id" value="{{ $encounter->id }}">
                                    <button type="submit" class="btn btn-sm btn-primary mr-1">
                                        <i class="fa fa-wheelchair"></i> Arrived
                                    </button>
                                </form>
                            @endif
                        </span>
                    </div>

                </div>

            </div>




            <!-- Change Room Modal Start-->
            <div class="modal fade" id="roomChangeModal" tabindex="-1" role="dialog"
                aria-labelledby="roomChangeModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="roomChangeModallLabel">Select a Room</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{ route('encounters.room', ['encounter' => $encounter->id]) }}" method="POST">
                            @csrf
                            <input type="hidden" name="encounter_id" value="{{ $encounter->id }}">
                            <div class="modal-body">

                                <ul class="list-group">
                                    <select id="doctorSelect" class="form-control" style="width: 100%;" name="room_id">
                                        @if ($rooms)
                                            @foreach ($rooms as $room)
                                                <option value="{{ $room->id }}">{{ $room->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </ul>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary">Choose Room</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
            <!-- Change Room Modal end-->

            <!-- Change Doctor Modal Start-->
            <div class="modal fade" id="changeDoctorModal" tabindex="-1" role="dialog"
                aria-labelledby="changeDoctorModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="changeDoctorModalLabel">Select a Doctor</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <ul class="list-group">
                                {{-- @foreach ($doctors as $doctor) --}}
                                {{-- <li class="list-group-item">
                                        <input type="radio" name="doctor_id" value="{{ $doctor->id }}" />
                                        {{ $doctor->name }}
                                    </li> --}}
                                <form id="form"
                                    action="{{ route('encounters.changeDoctor', ['encounter' => $encounter]) }}"
                                    method="POST">
                                    @csrf
                                    <div class="modal-body">
                                        <ul class="list-group">
                                            <select id="doctorSelect" class="form-control" style="width: 100%;"
                                                name="newDoctorId">
                                                @foreach ($doctors as $doctor)
                                                    <option value="{{ $doctor->id }}">{{ $doctor->name }}</option>
                                                @endforeach
                                            </select>
                                        </ul>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-primary">Assign Doctor</button>
                                    </div>
                                </form>

                                {{-- <script>
                                    $(document).ready(function() {
                                        $('#doctorSelect').select2();

                                        $('#form').submit(function() {
                                            var data = {
                                                encounter_id: $('#encounter_id').val(),
                                                doctor_id: $('#doctorSelect').val(),
                                            };

                                            $(this).attr('data', JSON.stringify(data));
                                        });
                                    });
                                </script> --}}
                                {{-- @endforeach --}}
                            </ul>
                        </div>

                    </div>
                </div>
            </div>
            <!-- Change Doctor Modal end-->

            <!-- Medical Sick Leave Modal Start-->
            <div class="modal fade" id="medicalSickLeaveModal" tabindex="-1" role="dialog"
                aria-labelledby="medicalSickLeaveModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="medicalSickLeaveModalLabel">Create and print medical sick leave
                                latter</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="content">
                            <div class="card card-primary card-outline">
                                <div class="card-body">
                                    <form action="{{ route('medical-sick-leaves.store') }}" method="POST">
                                        @csrf

                                        <!-- Hidden inputs for student_id, doctor_id, and encounter_id -->
                                        <input type="hidden" name="student_id" id="student_id"
                                            value="{{ $encounter->student->id ?? '-' }}">
                                        <input type="hidden" name="doctor_id" id="doctor_id"
                                            value="{{ Auth::user()->clinicUsers?->id }}">
                                        <input type="hidden" name="encounter_id" id="encounter_id"
                                            value="{{ $encounter->id }}">
                                        <div class="form-group">
                                            <label for="reason">Reason:</label>
                                            <input type="text" name="reason" id="reason" class="form-control"
                                                value="Medical Condition" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="note">Note:</label>
                                            <textarea name="note" id="note" class="form-control" rows="3">Medical note for the sick leave.</textarea>
                                        </div>
                                        {{-- <div class="form-group">
                                            <label for="medical_certificate">Medical Certificate:</label>
                                            <input type="file" name="medical_certificate" id="medical_certificate"
                                                class="form-control-file">
                                        </div> --}}
                                        <div class="form-group">
                                            <label for="start_date">Start Date:</label>
                                            <input type="date" name="start_date" id="start_date" class="form-control"
                                                value="2023-07-23" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="end_date">End Date:</label>
                                            <input type="date" name="end_date" id="end_date" class="form-control"
                                                value="2023-07-28" required>
                                        </div>

                                        <div class="text-center">
                                            <!-- Submit Button with Icon -->
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fas fa-check"></i> Submit
                                            </button>

                                            <!-- Print Button with Icon -->
                                            <button type="button" class="btn btn-primary" onclick="printSickLeave()">
                                                <i class="fas fa-print"></i> Print
                                            </button>

                                            <!-- Cancel Button (using Bootstrap's "data-dismiss" attribute) -->
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                                <i class="fas fa-times"></i> Cancel
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Place this script in your HTML file or in a separate JS file -->

            <script>
                // Function to handle form submission
                function submitForm() {
                    // Get form data
                    var formData = {
                        reason: $('#reason').val(),
                        note: $('#note').val(),
                        start_date: $('#start_date').val(),
                        end_date: $('#end_date').val(),
                        // Add any additional data that you need (student_id, doctor_id, encounter_id)
                    };

                    // Send AJAX request
                    $.ajax({
                        type: 'POST',
                        url: '{{ route('medical-sick-leaves.store') }}', // Replace with the actual route URL
                        data: formData,
                        dataType: 'json',
                        success: function(response) {
                            // Handle success response, if needed
                            console.log(response);
                        },
                        error: function(xhr, status, error) {
                            // Handle error response, if needed
                            console.error(error);
                        }
                    });
                }

                // Function to print the form (you can implement this separately if needed)
                function printSickLeave() {
                    // Implement your printing logic here
                }
            </script>

            <!-- Medical Sick Leave Modal end-->

            {{-- <script>
                $(document).ready(function() {
                    $('#doctorSelect').select2();
                });

                function assignDoctor() {
                    var selectedDoctorId = $('#doctorSelect').val();

                    // Send an AJAX request to update the encounter with the selected doctor ID
                    $.ajax({
                        url: '{{ route('encounters.refer', $encounter) }}',
                        type: 'POST',
                        data: {
                            doctor_id: selectedDoctorId,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            // Handle success response, e.g., show a success message
                            console.log(response);
                        },
                        error: function(xhr, status, error) {
                            // Handle error response, e.g., show an error message
                            console.log(error);
                        }
                    });
                }
            </script> --}}
            <!-- Referral Modal End-->

            <div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Confirm missing Status Change</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            Are you sure you want to change the missing status?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <form method="post" action="{{ route('changeStatuss') }}">
                                @csrf
                                <input type="hidden" name="encounter_id" value="{{ $encounter->id }}">
                                <button type="submit" class="btn btn-primary">
                                    Confirm
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>




            <div class="card-body">
                {{-- <h4 class="card-title">
                    <a href="{{ route('lab-test-request-groups.index') }}" class="mr-4"><i
                            class="icon ion-md-arrow-back"></i></a>
                    @lang('crud.lab_test_request_groups.show_title')
                </h4> --}}

                <div class="row m-2">
                    <div class="col-md-4 mb-2">
                        <i class="fa fa-caret-right"></i>
                        <span>Patient Name:</span>
                        <u>{{ optional($encounter)->student->fullName ?? '-' }}</u>
                    </div>

                    <div class="col-md-4 mb-2">
                        <i class="fa fa-caret-right"></i>
                        <span>Encounter Priority:</span>
                        <span
                            style="color: {{ $encounter->status == 0 ? 'green' : 'red' }};">{{ $encounter->status == 0 ? 'FCFS' : 'FCFS' }}</span>
                    </div>

                    <div class="col-md-4 mb-2">
                        <i class="fa fa-caret-right"></i>
                        <span> Visit status:</span>

                        @if ($encounter->status == 1)
                            <span class="badge badge-secondary"> Checked-in</span>
                        @elseif($encounter->status == 2)
                            <span class="badge  badge-info"> In-progress</span>
                        @elseif($encounter->status == 3)
                            <span class="badge  badge-success"> Completed </span>
                        @else
                            <span class="badge  badge-danger"> Missed </span>
                        @endif



                    </div>

                    <div class="col-md-4 mb-2">
                        <i class="fa fa-caret-right"></i>
                        <span>Date of visit:</span>
                        {{ $encounter->created_at?->format('d M Y') ?? '-' }}

                    </div>

                    <div class="col-md-4 mb-2">
                        <i class="fa fa-caret-right"></i>
                        <span>Age:</span>



                        @if ($encounter->student->date_of_birth === null)
                            {{-- {{ route('map-rfid') }} --}}
                            <form method="post" action="#">
                                @csrf
                                <input type="hidden" name="student_id" value="{{ $encounter->student->id }}">
                                <input type="text" required class="form-control-sm" autocomplete="off" name="rfid"
                                    placeholder="Enter Age">
                                <button type="submit" class="btn btn-sm btn-outline-primary mr-1"> <i
                                        class="icon fa fa-plus"></i> Save</button>
                            </form>
                        @else
                            <span style="color:red;">
                                {{ \Carbon\Carbon::parse($encounter->student->date_of_birth)->diff(\Carbon\Carbon::now())->format('%y years old') }}
                            </span>
                        @endif




                    </div>





                    <div class="col-md-4 mb-2">
                        <i class="fa fa-caret-right"></i>
                        <span>Health officer:</span>
                        {{ $encounter->Doctor?->clinicUsers?->user->name }}
                    </div>

                    <div class="col-md-4 mb-2">
                        <i class="fa fa-caret-right"></i>
                        <span>Clinic:</span>
                        {{ $encounter->clinic->name ?? '-' }}
                    </div>

                    <div class="col-md-4 mb-2">
                        <i class="fa fa-caret-right"></i>
                        <span>Receptionist:</span>
                        {{ $encounter?->RegisteredBy?->clinicUsers?->user->name }}
                    </div>

                    <div class="col-md-4 mb-2">
                        <i class="fa fa-caret-right"></i>
                        <span>Patient ID:</span>
                        {{ $encounter->student->id_number ?? '-' }}
                    </div>



                </div>


                <div class="card  border-warning-left-5  border border-warning">

                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-list"></i>
                            <b> Patient Information </b>
                        </h3>
                    </div>


                    @if ($encounter->arrived_at != null)
                        <div class="card-body">

                            <div class="row">

                                <div class="col-5 col-sm-3">

                                    <div class="nav flex-column nav-tabs h-100" id="vert-tabs-tab" role="tablist"
                                        aria-orientation="vertical">

                                        <ul class="nav nav-pills flex-column">



                                            <li class="nav-item">
                                                <a class="nav-link active" id="vert-tabs-profile-tab" data-toggle="pill"
                                                    href="#vert-tabs-profile" role="tab"
                                                    aria-controls="vert-tabs-profile" aria-selected="false"> <i
                                                        class="fa fa-caret-right nav-icon"></i><b>
                                                        Clinical Note </b></a>
                                            </li>

                                            <li class="nav-item">
                                                <a class="nav-link " id="vert-tabs-tb-tab" data-toggle="pill"
                                                    href="#vert-tabs-tb" role="tab" aria-controls="vert-tabs-tb"
                                                    aria-selected="false"> <i class="fa fa-caret-right nav-icon"></i><b>
                                                        TB Screening </b></a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="vert-tabs-sign-tab" data-toggle="pill"
                                                    href="#vert-tabs-sign" role="tab" aria-controls="vert-tabs-sign"
                                                    aria-selected="false"> <i class="fa fa-caret-right nav-icon"></i>
                                                    <b> Vital Sign</b> </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="vert-tabs-main-dignosis-tab" data-toggle="pill"
                                                    href="#vert-tabs-main-dignosis" role="tab"
                                                    aria-controls="vert-tabs-main-dignosis" aria-selected="false"> <i
                                                        class="fa fa-caret-right nav-icon"></i><b> Main
                                                        Diagnoses </b></a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="vert-tabs-settings-tab" data-toggle="pill"
                                                    href="#vert-tabs-diagnosis" role="tab"
                                                    aria-controls="vert-tabs-diagnosis" aria-selected="false"> <i
                                                        class="fa fa-caret-right nav-icon"></i><b> Laboratory </b> </a>
                                            </li>

                                            <li class="nav-item">
                                                <a class="nav-link" id="vert-tabs-medication-tab" data-toggle="pill"
                                                    href="#vert-tabs-medication" role="tab"
                                                    aria-controls="vert-tabs-medication" aria-selected="false"> <i
                                                        class="fa fa-caret-right nav-icon"></i><b> Prescription </b> </a>
                                            </li>

                                            <li class="nav-item">
                                                <a class="nav-link " id="vert-tabs-home-tab" data-toggle="pill"
                                                    href="#vert-tabs-appointment" role="tab"
                                                    aria-controls="vert-tabs-home" aria-selected="true"> <i
                                                        class="fa fa-caret-right nav-icon"></i><b>
                                                        Appointments </b> <span
                                                        class="badge bg-primary float-right">0</span></a>

                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="vert-tabs-refer-tab" data-toggle="pill"
                                                    href="#vert-tabs-refer" role="tab"
                                                    aria-controls="vert-tabs-refer" aria-selected="false"> <i
                                                        class="fa fa-caret-right nav-icon"></i><b>
                                                        Referral Service</b> </a>
                                            </li>



                                            <li class="nav-item">
                                                <a class="nav-link" id="vert-tabs-history-tab  vert-tabs-history"
                                                    data-toggle="pill" href="#vert-tabs-history" role="tab"
                                                    aria-controls="vert-tabs-history" aria-selected="false"> <i
                                                        class="fa fa-caret-right nav-icon"></i><b>
                                                        Last Visit History </b> </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>


                                <div class="col-7 col-sm-9">
                                    <div class="tab-content" id="vert-tabs-tabContent">

                                        <div class="tab-pane text-left fade show active " id="vert-tabs-profile"
                                            role="tabpanel" aria-labelledby="vert-tabs-profile-tab">
                                            @can('view-any', App\Models\MedicalRecord::class)
                                                <div class="card mt-4">
                                                    <div class="card-body">
                                                        <h4 class="card-title w-100 mb-2">Clinic Notes</h4>

                                                        <livewire:encounter-medical-records-detail :encounter="$encounter" />
                                                    </div>
                                                </div>
                                            @endcan

                                        </div>



                                        <div class="tab-pane fade" id="vert-tabs-sign" role="tabpanel"
                                            aria-labelledby="vert-tabs-sign-tab">

                                            @can('view-any', App\Models\VitalSign::class)
                                                <div class="card mt-4">
                                                    <div class="card-body">
                                                        <h4 class="card-title w-100 mb-2">Vital Sign</h4>
                                                        <livewire:encounter-vital-signs-detail :encounter="$encounter" />
                                                    </div>
                                                </div>
                                            @endcan

                                        </div>

                                        <div class="tab-pane fade" id="vert-tabs-tb" role="tabpanel"
                                            aria-labelledby="vert-tabs-tb-tab">

                                            {{-- @can('view-any', App\Models\VitalSign::class) --}}
                                            <div class="card mt-4">
                                                <div class="card-body">
                                                    <h4 class="card-title w-100 mb-2">TB Screening</h4><br>
                                                    <hr>
                                                    -
                                                    {{-- <livewire:encounter-vital-signs-detail :encounter="$encounter" /> --}}
                                                </div>
                                            </div>
                                            {{-- @endcan --}}

                                        </div>




                                        <div class="tab-pane fade" id="vert-tabs-refer" role="tabpanel"
                                            aria-labelledby="vert-tabs-refer-tab">

                                            {{-- @can('view-any', App\Models\VitalSign::class) --}}
                                            <div class="card mt-4">
                                                <div class="card-body">
                                                    <h4 class="card-title w-100 mb-2">Patient Referral Service</h4><br>
                                                    <hr>
                                                    -
                                                    {{-- <livewire:encounter-vital-signs-detail :encounter="$encounter" /> --}}
                                                </div>
                                            </div>
                                            {{-- @endcan --}}

                                        </div>


                                        <div class="tab-pane fade" id="vert-tabs-history" role="tabpanel"
                                            aria-labelledby="vert-tabs-history-tab">

                                            {{-- @can('view-any', App\Models\VitalSign::class) --}}
                                            <div class="card mt-4">
                                                <div class="card-body">
                                                    <h4 class="card-title w-100 mb-2">Visit History</h4><br>
                                                    <hr>
                                                    -
                                                    {{-- <livewire:encounter-vital-signs-detail :encounter="$encounter" /> --}}
                                                </div>
                                            </div>
                                            {{-- @endcan --}}

                                        </div>



                                        <div class="tab-pane fade" id="vert-tabs-sign" role="tabpanel"
                                            aria-labelledby="vert-tabs-sign-tab">

                                            @can('view-any', App\Models\VitalSign::class)
                                                <div class="card mt-4">
                                                    <div class="card-body">
                                                        <h4 class="card-title w-100 mb-2">Vital Sign</h4>
                                                        <livewire:encounter-vital-signs-detail :encounter="$encounter" />
                                                    </div>
                                                </div>
                                            @endcan

                                        </div>

                                        <div class="tab-pane fade" id="vert-tabs-appointment" role="tabpanel"
                                            aria-labelledby="vert-tabs-appointment-tab">

                                            @can('view-any', App\Models\Appointment::class)
                                                <div class="card mt-4">
                                                    <div class="card-body">
                                                        <h4 class="card-title w-100 mb-2">Appointments</h4>

                                                        <livewire:encounter-appointments-detail :encounter="$encounter" />
                                                    </div>
                                                </div>
                                            @endcan

                                        </div>

                                        <div class="tab-pane fade" id="vert-tabs-main-dignosis" role="tabpanel"
                                            aria-labelledby="vert-tabs-main-dignosis-tab">
                                            @can('view-any', App\Models\MainDiagnosis::class)
                                                <div class="card mt-4">
                                                    <div class="card-body">
                                                        <h4 class="card-title w-100 mb-2">Main Diagnoses</h4>


                                                        {{-- <livewire:encounter-main-diagnoses-detail :encounter="$encounter" /> --}}
                                                        @can('create', App\Models\MainDiagnosis::class)
                                                            <!-- Button trigger modal -->
                                                            <button type="button" class="btn btn-primary" data-toggle="modal"
                                                                data-target="#diagnosisModal">
                                                                <i class="icon ion-md-add"></i>
                                                                @lang('crud.common.new')
                                                            </button>

                                                            <!-- Modal -->
                                                            <div class="modal fade" id="diagnosisModal" tabindex="-1"
                                                                role="dialog" aria-labelledby="diagnosisModalLabel"
                                                                aria-hidden="true">
                                                                <div class="modal-dialog modal-lg" role="document">
                                                                    <!-- modal-lg class for a wider modal -->
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title" id="diagnosisModalLabel">
                                                                                Select Diagnosis</h5>
                                                                            <button type="button" class="close"
                                                                                data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>

                                                                        <div class="modal-body">
                                                                            <form id="diagnosisForm" method="POST"
                                                                                action="{{ route('encounter.maindignosis') }}">
                                                                                @csrf

                                                                                <!-- Hidden inputs -->
                                                                                <input type="hidden" id="studentId"
                                                                                    name="student_id"
                                                                                    value="{{ $encounter->student_id }}">
                                                                                <input type="hidden" id="encounterId"
                                                                                    name="encounter_id"
                                                                                    value="{{ $encounter->id }}">
                                                                                <input type="hidden" id="clinicUserId"
                                                                                    name="clinic_user_id"
                                                                                    value="{{ $encounter?->Doctor?->clinicUsers?->id }}">

                                                                                <!-- Diagnosis Select using Select2 with wider class -->
                                                                                <select id="diagnosisSelect" name="diagnosis_id[]"
                                                                                    class="form-control select2"
                                                                                    multiple="multiple" style="width: 100%;">
                                                                                    @foreach ($allDignosis as $diagnosis)
                                                                                        <option value="{{ $diagnosis->id }}">
                                                                                            {{ $diagnosis->name }}</option>
                                                                                    @endforeach
                                                                                </select>

                                                                                <div class="modal-footer">
                                                                                    <button type="button"
                                                                                        class="btn btn-secondary"
                                                                                        data-dismiss="modal">Close</button>
                                                                                    <button type="submit"
                                                                                        class="btn btn-primary">Save
                                                                                        changes</button>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            {{-- @endcan @can('delete-any', App\Models\MainDiagnosis::class)
                                                            <button class="btn btn-danger"
                                                                {{ empty($selected) ? 'disabled' : '' }}
                                                                onclick="confirm('Are you sure?') || event.stopImmediatePropagation()"
                                                                wire:click="destroySelected">
                                                                <i class="icon ion-md-trash"></i> Delete
                                                                @lang('crud.common.delete_selected')
                                                            </button> --}}
                                                        @endcan


                                                    </div>
                                                </div>


                                                <div class="table-responsive">
                                                    <table class="table table-hover  table-sm table-condensed">
                                                        <thead>
                                                            <tr>
                                                                <th>
                                                                    <input type="checkbox" wire:model="allSelected"
                                                                        wire:click="toggleFullSelection"
                                                                        title="{{ trans('crud.common.select_all') }}" />
                                                                </th>
                                                                <th class="text-left">
                                                                    @lang('crud.encounter_main_diagnoses.inputs.clinic_user_id')
                                                                </th>
                                                                {{-- <th class="text-left">
                                                                    @lang('crud.encounter_main_diagnoses.inputs.student_id')
                                                                </th> --}}
                                                                <th class="text-left">
                                                                    @lang('crud.encounter_main_diagnoses.inputs.diagnosis_id')
                                                                </th>
                                                                <th></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="text-gray-600">
                                                            @foreach ($maindiagnosises as $mainDiagnosis)
                                                                <tr class="hover:bg-gray-100">
                                                                    <td class="text-left">
                                                                        <input type="checkbox"
                                                                            value="{{ $mainDiagnosis->id }}"
                                                                            wire:model="selected" />
                                                                    </td>
                                                                    <td class="text-left">
                                                                        {{ optional($mainDiagnosis->Doctor)?->user->name ?? '-' }}
                                                                    </td>
                                                                    {{-- <td class="text-left">
                                                                        {{ optional($mainDiagnosis->student)->first_name ?? '-' }}
                                                                    </td> --}}
                                                                    <td class="text-left">
                                                                        {{ optional($mainDiagnosis->diagnosis)->name ?? '-' }}
                                                                    </td>
                                                                    <td class="text-right">
                                                                        <div role="group" aria-label="Row Actions"
                                                                            class="relative inline-flex align-middle">
                                                                            @can('update', $mainDiagnosis)
                                                                                <button type="button" class="btn btn-light"
                                                                                    wire:click="editMainDiagnosis({{ $mainDiagnosis->id }})">
                                                                                    <i class="fa fa-edit"></i> Edit
                                                                                </button>
                                                                            @endcan
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>

                                                    </table>
                                                </div>
                                            @endcan
                                        </div>

                                        <div class="tab-pane fade" id="vert-tabs-diagnosis" role="tabpanel"
                                            aria-labelledby="vert-tabs-diagnosis-tab">

                                            <div class="card mt-4">
                                                {{-- @can('view-any', App\Models\LabTestRequestGroup::class)
                                     
                                                <div class="card-body">
                                                    <h4 class="card-title w-100 mb-2"> Lab Test Group </h4>

                                                    <livewire:encounter-lab-test-request-groups-detail :encounter="$encounter" />

                                                </div>
                                                @endcan    --}}

                                                @can('view-any', App\Models\LabTestRequest::class)
                                                    <div class="card-body">
                                                        <h4 class="card-title w-100 mb-2"> Lab Test Requests </h4>
                                                        <livewire:encounter-lab-test-requests-detail :encounter="$encounter" />
                                                    </div>
                                                @endcan


                                                <style>
                                                    select.form-control[multiple],
                                                    select.form-control[size] {
                                                        height: 400px !important;
                                                    }
                                                </style>

                                                <form id="demoform" method="POST" name="lab"
                                                    action="{{ route('labTest.insert') }}">
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                    <input type="hidden" name="encounter" value="{{ $encounter->id }}">

                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <select multiple="multiple" size="72"
                                                                        max-height="500px" overflow-y="auto"
                                                                        name="duallistbox_demo1[]"
                                                                        title="duallistbox_demo1[]">
                                                                        @foreach ($labCategories as $labCategory)
                                                                            <optgroup id="label"
                                                                                label="{{ $labCategory->lab_name }}">
                                                                                {{-- @foreach ($labCategory->labTests as $lab) --}}
                                                                                @foreach ($labCategory?->labTests->where('is_available', 1) as $lab)
                                                                                    <option value="{{ $lab->id }}">
                                                                                        {{ $lab->labCatagory->lab_name }}-{{ $lab->test_name }}
                                                                                    </option>
                                                                                @endforeach
                                                                            </optgroup>
                                                                        @endforeach
                                                                    </select>
                                                                    <br>
                                                                    <div class="row">
                                                                        <div class="col-md-6 offset-md-6">
                                                                            <button type="submit"
                                                                                class="btn btn-primary w-100">Send lab
                                                                                request</button>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>


                                            </div>

                                        </div>



                                        <div class="tab-pane fade" id="vert-tabs-medication" role="tabpanel"
                                            aria-labelledby="vert-tabs-medication-tab">
                                            @can('view-any', App\Models\Prescription::class)
                                                <div class="card mt-4">
                                                    <div class="card-body">
                                                        <h4 class="card-title w-100 mb-2">Medicine Prescription</h4>

                                                        <livewire:encounter-prescriptions-detail :encounter="$encounter" />
                                                    </div>

                                                    {{-- <div class="p-3">
                                                    <div class="prescription-view">
                                                        <h3>Medicine Prescription</h3>
                                                        <div class="prescription-info">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <p>
                                                                        <strong>Patient Name:</strong>
                                                                        <span>&nbsp;<u>{{ optional($encounter)->student->fullName ?? '-' }}
                                                                            </u></span>
                                                                    </p>
                                                                    <p>
                                                                        <strong>Date:</strong>
                                                                        <span> &nbsp;{{ $encounter->created_at ?? '-' }}</span>
                                                                    </p>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <p>
                                                                        <strong>Health Officer:</strong>
                                                                  {{ $encounter->Doctor?->clinicUsers?->user->name  }}

                                                                    </p>

                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="prescription-details">
                                                            <table class="table table-bordered">
                                                                <livewire:encounter-prescriptions-detail :encounter="$encounter" />
                                                            </table>

                                                        </div>

                                                    </div>
                                                </div> --}}
                                                </div>
                                            @endcan
                                        </div>
                                        {{-- 
                                    <div class="tab-pane fade" id="vert-tabs-appointment" role="tabpanel"
                                        aria-labelledby="vert-tabs-appointment-tab">

                                        @can('view-any', App\Models\Appointment::class)
                                            <div class="card mt-4">
                                                <div class="card-body">
                                                    <h4 class="card-title w-100 mb-2">Appointments</h4>

                                                    <livewire:encounter-appointments-detail :encounter="$encounter" />
                                                </div>
                                            </div>
                                        @endcan

                                    </div> --}}

                                        {{-- <div class="tab-pane fade" id="vert-tabs-sign-tab" role="tabpanel"
                                        aria-labelledby="vert-tabs-sign">

                                        @can('view-any', App\Models\VitalSign::class)
                                            <div class="card mt-4">
                                                <div class="card-body">
                                                    <h4 class="card-title w-100 mb-2">Vital Sign</h4>
                                                    <livewire:encounter-vital-signs-detail :encounter="$encounter" />
                                                </div>
                                            </div>
                                        @endcan

                                    </div> --}}

                                        {{-- <div class="tab-pane fade" id="vert-tabs-sign" role="tabpanel"
                                        aria-labelledby="vert-tabs-sign-tab">

                                        @can('view-any', App\Models\VitalSign::class)
                                            <div class="card mt-4">
                                                <div class="card-body">
                                                    <h4 class="card-title w-100 mb-2">Vital Sign</h4>
                                                    <livewire:encounter-vital-signs-detail :encounter="$encounter" />
                                                </div>
                                            </div>
                                        @endcan
                                        <div class="tab-pane fade" id="vert-tabs-history" role="tabpanel"
                                            aria-labelledby="vert-tabs-history-tab">
                                            Tab 6 Visit history
                                        </div>

                                    </div> --}}

                                    </div>
                                </div>

                            </div>
                            <!-- /.card -->
                    @endif
                </div>
                <!-- /.card -->

            </div>
        </div>

    </div>


    {{-- <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script> --}}

    {{-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script> --}}

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <!-- plugin -->
    <script src="{{ asset('plugins/jquery.bootstrap-duallistbox.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    {{-- <script>

           //Bootstrap Duallistbox
    $('.duallistbox').bootstrapDualListbox()

    </script> --}}

    <script>
        var demo1 = $('select[name="duallistbox_demo1[]"]').bootstrapDualListbox({
            nonSelectedListLabel: 'Available labs',
            selectedListLabel: 'Selected labs',
            preserveSelectionOnMove: 'moved',
            moveAllLabel: '>>',
            removeAllLabel: '<<'

        });


        //  $("#demoform").submit(function(event) {
        //   event.preventDefault();

        $("#demoform").submit(function() {


            alert('Are you sure to send all selected labs?\n' + $('[name="duallistbox_demo1[]"]').val());
            //   Swal.fire({
            //   title: 'Error!',
            //   text: 'Do you want to continue',
            //   icon: 'error',
            //   confirmButtonText: 'Cool'
            // })

            return true


        });
    </script>

@endsection
