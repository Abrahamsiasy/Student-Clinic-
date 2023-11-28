@extends('layouts.app')

@section('content')



</section>
    <div class="">
        <div class="searchbar mt-0 mb-4">
            <div class="row">
              
           

                        <div class="col-md-3 col-sm-6 col-12">
                          <div class="info-box">
                            <span class="info-box-icon bg-info"><i class="fa fa-users"></i></span>
                
                            <div class="info-box-content">
                              <span class="info-box-text">Total Patients </span>
                              <span class="info-box-number">{{ $myPateints ?? '-' }}</span>
                            </div>
                            <!-- /.info-box-content -->
                          </div>
                          <!-- /.info-box -->
                        </div>
                            <!-- /.col -->
                            <div class="col-md-3 col-sm-6 col-12">
                            <div class="info-box">
                                <span class="info-box-icon bg-warning"><i class="fa fa-flask"></i></span>
                    
                                <div class="info-box-content">
                                <span class="info-box-text">Total labs</span>
                                <span class="info-box-number">{{ $mylabs ?? '-' }}</span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                            </div>
                            
                        <!-- /.col -->
                        <div class="col-md-3 col-sm-6 col-12">
                          <div class="info-box">
                            <span class="info-box-icon bg-success"><i class="fa fa-upload"></i></span>
                
                            <div class="info-box-content">
                              <span class="info-box-text">Pending labs</span>
                              <span class="info-box-number">{{ $pendinglabs }}</span>
                            </div>
                            <!-- /.info-box-content -->
                          </div>
                          <!-- /.info-box -->
                        </div>
          
                        <!-- /.col -->
                        <div class="col-md-3 col-sm-6 col-12">
                          <div class="info-box">
                            <span class="info-box-icon bg-danger"><i class="fa fa-download"></i></span>
                
                            <div class="info-box-content">
                              <span class="info-box-text"> Active Results</span>
                              <span class="info-box-number">{{ $labResults }}</span>
                            </div>
                            <!-- /.info-box-content -->
                          </div>
                          <!-- /.info-box -->
                        </div>
                        <!-- /.col -->
                      </div>
                      <!-- /.row -->
                
                    </div>







 

        <div class="card">
            <div class="card-body">
                <div style="display: flex; justify-content: space-between;">
                    <h4> Lab request for <u>{{ auth()->user()->fullName }} </u></h4>
                </div>


                <hr>
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

                                    {{-- @unless (auth()->user()->hasRole('doctor')) --}}
                                    Patient Name
                                    {{-- @endunless --}}
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

                                <th> No of labs </th>
                                <th class="text-left">
                                    Status
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

                                    <td> {{  $encounter->labRequests->count() }} </td>
                                    <td>
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
                                                    'name' => 'Lab sent',
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

                                    <td class="text-center">
                                        <div role="group" aria-label="Row Actions" class="btn-group">


                                            @if (auth()->user()->hasRole(DOCTOR_ROLE))
                                                <button type="button" class="btn btn-sm btn-outline-primary mx-1" disabled>
                                                    <i class="icon fa fa-user"></i> Call patient
                                                </button>
                                            @endif

                                            @can('view', $encounter)
                                                @if ($encounter->labTestRequests->count() > 0)
                                                    <a href="{{ route('encounters.show', $encounter) }}">
                                                        <button type="button" class="btn btn-sm btn-outline-primary mx-1">
                                                            <i class="icon fa fa-download"></i> View Result
                                                        </button>
                                                    </a>
                                                @else
                                                    <a href="{{ route('encounters.show', $encounter) }}">
                                                        <button type="button" class="btn btn-sm btn-outline-danger mx-1">
                                                            <i class="icon fa fa-flask"></i> LabPending
                                                        </button>
                                                    </a>
                                                @endif
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
