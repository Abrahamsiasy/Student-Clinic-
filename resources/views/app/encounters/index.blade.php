@extends('layouts.app')

@section('content')
    <div class="">
        @if (!$rooms)
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>Attention!</strong> You need to assign clinic and rooms to this user.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        <div class="searchbar mt-0 mb-4">

            <div class="row">

                <div class="col-md-6">
                    <form>
                        <div class="input-group">
                            <input id="indexSearch" type="text" name="search"
                                placeholder="{{ __('crud.common.search') }}" value="{{ $search ?? '' }}"
                                class="form-control" autocomplete="off" />
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-primary">
                                    <i class="icon io-md-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-6 text-right">



                    <button type="button" class="btn btn-sm d-inline-block btn-outline-primary" data-toggle="modal"
                        data-target="#roomChangeModal">
                        <i class="fas fa-door-open"></i></i>&nbsp; {{ Auth::user()->clinicUsers?->room?->name }}: Change
                        Room </button>
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
                                <form action="{{ route('encounters.all') }}" method="POST">
                                    @csrf
                                    <div class="modal-body">

                                        <ul class="list-group">
                                            <select id="doctorSelect" class="form-control" style="width: 100%;"
                                                name="room_id">
                                                @if ($rooms)
                                                    @foreach ($rooms as $room)
                                                        <option value="{{ $room->id }}">{{ $room->name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </ul>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-primary">Choose Room</button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                    <!-- Change Room Modal end-->

                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div style="display: flex; justify-content: space-between;">
                    <h4 class="card-title">@lang('crud.encounters.index_title')</h4>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover  table-sm table-condensed">
                        <thead>
                            <tr>
                                <th>#</th>
                                {{-- <th class="text-left">
                                    MRN
                                </th> --}}
                                <th class="text-left">
                                    {{-- @lang('crud.encounters.inputs.student_id') --}}
                                    Student ID
                                </th>
                                <th class="text-left">
                                    {{-- @lang('crud.encounters.inputs.status') --}}

                                    Patient Name
                                </th>

                                <th class="text-left">
                                    {{-- @lang('crud.encounters.inputs.closed_at') --}}
                                    Age
                                </th>
                                {{-- <th class="text-left">
                                    @lang('crud.encounters.inputs.priority')
                                    Prioriry
                                </th> --}}
                                <th class="text-left">
                                    {{-- @lang('crud.encounters.inputs.priority') --}}
                                    Gender
                                </th>
                                <th class="text-left">
                                    {{-- @lang('crud.encounters.inputs.clinic_id') --}}
                                    Date of visit
                                </th>

                                <th class="text-left">
                                    Status
                                </th>

                                <th class="text-left">
                                    Doctor
                                </th>

                                <th class="text-center">
                                    @lang('crud.common.actions')
                                </th>
                            </tr>
                        </thead>


                        <tbody>
                            @foreach ($encounters as $key => $encounter)
                                <tr>

                                    <td> {{ $key + 1 }}
                                        {{-- <td>{{ $encounter->student->id_number ?? '-' }}</td> --}}
                                    <td>{{ $encounter->student->id_number ?? '-' }}</td>
                                    <td>
                                        {{-- @unless (auth()->user()->hasRole('doctor')) --}}
                                        {{ $encounter->student?->fullName ?? '-' }}
                                        {{-- @endunless --}}
                                    </td>
                                    <td>
                                        @php
                                            try {
                                                $age = \Carbon\Carbon::parse($encounter->student->date_of_birth)
                                                    ->diff(\Carbon\Carbon::now())
                                                    ->format('%y years old');
                                            } catch (\Exception $e) {
                                                $age = '<span style="color: red;">Error</span>';
                                            }
                                            echo $age;
                                        @endphp
                                    </td>
                                    {{-- <td>{{ $encounter->priority ?? '-' }}</td> --}}


                                    <td>{{ optional($encounter->student)->sex ?? '-' }}</td>




                                    <td>{{ $encounter->check_in_time ? \Carbon\Carbon::parse($encounter->check_in_time)->format('M d, Y') : '-' }}
                                    </td>
                                    <td>
                                        @php
                                            $statusDetails = [
                                                STATUS_COMPLETED => [
                                                    'name' => 'Encounter Closed',
                                                    'description' => 'The patient\'s appointment is confirmed but not yet attended.',
                                                    'color' => 'btn-outline-primary',
                                                ],
                                                STATUS_CHECKED_IN => [
                                                    'name' => 'Checked-in',
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


                                        <button
                                            class="btn btn-sm {{ $statusDetails[$encounter->status]['color'] ?? 'btn-outline-secondary' }} mx-1">
                                            {{ $statusDetails[$encounter->status]['name'] ?? '-' }}
                                        </button>

                                        <!-- Status Description (Hidden) -->
                                        {{-- {{ $statusDetails[$encounter->status]['description'] ?? '-' }} --}}
                                    </td>
                                    <td> {{ $encounter->doctor->name ?? '-' }}</td>

                                    <td class="text-center">
                                        <div role="group" aria-label="Row Actions" class="btn-group">

                                            {{-- @can('update', $encounter) --}}
                                            {{-- <a href="{{ route('medical-sick-leaves.show', $encounter) }}">
                                                <button type="button" class="btn btn-sm btn-outline-primary mx-1">
                                                    <i class="fa fa-print"></i> Sick Leave
                                                </button>
                                            </a> --}}
                                            {{-- @endcan  --}}

                                            <!-- Check if user is a doctor -->
                                            {{-- @if (auth()->user()->hasRole(DOCTOR_ROLE)) --}}
                                            @can('accept_patient')
                                                @if ($key === 0 && $encounter->status === STATUS_CHECKED_IN)
                                                    <a href="{{ route('encounters.accept', $encounter) }}">
                                                        <button type="button" class="btn btn-sm btn-outline-primary mx-1">
                                                             <i class="icon far fa-clock"></i>  Accept
                                                        </button>
                                                    </a>

                                                @elseif ($key != 0 && $encounter->status === STATUS_CHECKED_IN)
                                                <a href="{{ route('encounters.accept', $encounter) }}">
                                                    <button type="button" class="btn btn-sm btn-outline-primary mx-1">
                                                            <i class="icon far fa-clock"></i>  Waiting
                                                    </button>
                                                </a>
                                          
                                                @else
                                                    @if ($encounter->status === STATUS_IN_PROGRESS)
                                                        <a href="#">
                                                            <button type="button" class="btn btn-sm btn-outline-success mx-1">
                                                                 <i class="icon fa fa-user"></i>  In-progress
                                                            </button>
                                                        </a>
                                                    @else
                                                        <a href="#">
                                                            <button type="button" class="btn btn-sm btn-outline-info mx-1">
                                                                <i class="icon fa fa-check"></i> Case closed 
                                                        </a>
                                                    @endif
                                                @endif
                                            @endcan

                                            @can('view', $encounter)
                                                <a href="{{ route('encounters.show', $encounter) }}">
                                                    <button type="button" class="btn btn-sm btn-outline-primary mx-1">
                                                        <i class="icon fa fa-user"></i> Profile
                                                    </button>
                                                </a>
                                            @endcan






                                    </td>
                                </tr>
                            @endforeach
                </div>

                @if ($encounters->isEmpty())
                    <tr>
                        <td colspan="6">
                            @lang('crud.common.no_items_found')
                        </td>
                    </tr>
                @endif

                </tbody>
                <tfoot>
                    <tr>
                        {{-- <td colspan="6">{!! $encounters->render() !!}</td> --}}
                    </tr>
                </tfoot>
                </table>
            </div>

        </div>
    </div>
    {{-- <script>
            swal(
                'The Internet?',
                'That thing is still around?',
                'question'
            )
        </script> --}}
    </div>
@endsection
