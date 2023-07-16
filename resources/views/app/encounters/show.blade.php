@extends('layouts.app')

@section('content')
    <div class="">
        <div class="card">

            <div class="card collapsed-card p-3">
                <div class="card-header">
                    <h3 class="card-title w-full">
                        <a href="{{ route('encounters.index') }}" class="mr-4"><i class="icon ion-md-arrow-back"></i></a>
                        Current Encounter statu
                    </h3>
                    <div class="row ">
                        <span class="badge badge-info">Ongoing</span>
                        <div class="small-1 float-right d-inline-block">
                            <form method="post" action="" class="d-inline-block">
                                <input hidden="" name="call_next" value="true">
                                <button class="btn btn-sm btn-outline-primary">Call Next</button>
                            </form>

                            <button class="btn btn-sm d-inline-block btn-outline-primary" data-toggle="modal"
                                data-target="#refer">
                                <span class="fal fa-user-plus"></span>&nbsp;Refer</button>
                            <button id="finish" class="btn btn-sm d-inline-block btn-outline-primary">
                                <span class="fa fa-check d-inline-block"></span>&nbsp;Close Encounter</button>

                        </div>
                    </div>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body p-0" style="display: none;">
                    <div class="mt-4">
                        <div class="mb-4">
                            <h5>@lang('crud.encounters.inputs.check_in_time')</h5>
                            <span>{{ $encounter->check_in_time ?? '-' }}</span>
                        </div>
                        <div class="mb-4">
                            <h5>@lang('crud.encounters.inputs.status')</h5>
                            <span>{{ $encounter->status ?? '-' }}</span>
                        </div>
                        <div class="mb-4">
                            <h5>@lang('crud.encounters.inputs.student_id')</h5>
                            <span>{{ $encounter->student->id_number ?? '-' }}</span>
                        </div>
                        <div class="mb-4">
                            <h5>@lang('crud.encounters.inputs.closed_at')</h5>
                            <span>{{ $encounter->closed_at ?? '-' }}</span>
                        </div>
                        <div class="mb-4">
                            <h5>@lang('crud.encounters.inputs.priority')</h5>
                            <span>{{ $encounter->priority ?? '-' }}</span>
                        </div>
                        <div class="mb-4">
                            <h5>@lang('crud.encounters.inputs.clinic_id')</h5>
                            <span>{{ optional($encounter->clinic)->name ?? '-' }}</span>
                        </div>
                    </div>

                    <div class="mt-4">
                        <a href="{{ route('encounters.index') }}" class="btn btn-light">
                            <i class="icon ion-md-return-left"></i>
                            @lang('crud.common.back')
                        </a>

                        @can('create', App\Models\Encounter::class)
                            <a href="{{ route('encounters.create') }}" class="btn btn-light">
                                <i class="icon ion-md-add"></i> @lang('crud.common.create')
                            </a>
                        @endcan
                    </div>
                </div>

            </div>

        </div>

        @can('view-any', App\Models\Appointment::class)
            <div class="card mt-4">
                <div class="card-body">
                    <h4 class="card-title w-100 mb-2">Appointments</h4>

                    <livewire:encounter-appointments-detail :encounter="$encounter" />
                </div>
            </div>
            @endcan @can('view-any', App\Models\MedicalRecord::class)
            <div class="card mt-4">
                <div class="card-body">
                    <h4 class="card-title w-100 mb-2">Medical Records</h4>

                    <livewire:encounter-medical-records-detail :encounter="$encounter" />
                </div>
            </div>
            @endcan @can('view-any', App\Models\MainDiagnosis::class)
            <div class="card mt-4">
                <div class="card-body">
                    <h4 class="card-title w-100 mb-2">Main Diagnoses</h4>

                    <livewire:encounter-main-diagnoses-detail :encounter="$encounter" />
                </div>
            </div>
        @endcan
    </div>
@endsection
