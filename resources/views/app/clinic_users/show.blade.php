@extends('layouts.app')

@section('content')
    <div class="">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">
                    <a href="{{ route('clinic-users.index') }}" class="mr-4"><i class="icon ion-md-arrow-back"></i></a>
                    @lang('crud.clinic_users.show_title')
                </h4>

                <div class="mt-4">
                    <div class="mb-4">
                        <h5>@lang('crud.clinic_users.inputs.user_id')</h5>
                        <span>{{ optional($clinicUser->user)->name ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5>@lang('crud.clinic_users.inputs.encounter_id')</h5>
                        <span>{{ optional($clinicUser->encounter)->id ?? '-' }}</span>
                    </div>
                </div>

                <div class="mt-4">
                    <a href="{{ route('clinic-users.index') }}" class="btn btn-light">
                        <i class="icon ion-md-return-left"></i>
                        @lang('crud.common.back')
                    </a>

                    @can('create', App\Models\ClinicUser::class)
                        <a href="{{ route('clinic-users.create') }}" class="btn btn-light">
                            <i class="icon ion-md-add"></i> @lang('crud.common.create')
                        </a>
                    @endcan
                </div>
            </div>
        </div>

        {{-- @can('view-any', App\Models\VitalSign::class)
            <div class="card mt-4">
                <div class="card-body">
                    <h4 class="card-title w-100 mb-2">Vital Signs</h4>

                    <livewire:clinic-user-vital-signs-detail :clinicUser="$clinicUser" />
                </div>
            </div>
            @endcan @can('view-any', App\Models\VitalSign::class)
            <div class="card mt-4">
                <div class="card-body">
                    <h4 class="card-title w-100 mb-2">Vital Signs</h4>

                    <livewire:clinic-user-vital-signs-detail :clinicUser="$clinicUser" />
                </div>
            </div>
            @endcan @can('view-any', App\Models\MedicalRecord::class)
            <div class="card mt-4">
                <div class="card-body">
                    <h4 class="card-title w-100 mb-2">Medical Records</h4>

                    <livewire:clinic-user-medical-records-detail :clinicUser="$clinicUser" />
                </div>
            </div>
            @endcan @can('view-any', App\Models\LabTestRequestGroup::class)
            <div class="card mt-4">
                <div class="card-body">
                    <h4 class="card-title w-100 mb-2">Lab Test Request Groups</h4>

                    <livewire:clinic-user-lab-test-request-groups-detail :clinicUser="$clinicUser" />
                </div>
            </div>
            @endcan 
            @can('view-any', App\Models\LabTestRequest::class)
            <div class="card mt-4">
                <div class="card-body">
                    <h4 class="card-title w-100 mb-2">Lab Test Requests</h4>

                    <livewire:clinic-user-lab-test-requests-detail :clinicUser="$clinicUser" />
                </div>
            </div>
            @endcan 
        @can('view-any', App\Models\LabTestRequest::class)
            <div class="card mt-4">
                <div class="card-body">
                    <h4 class="card-title w-100 mb-2">Lab Test Requests3</h4>

                    <livewire:clinic-user-lab-test-requests3-detail :clinicUser="$clinicUser" />
                </div>
            </div>
            @endcan --}}
        {{-- @can('view-any', App\Models\clinic_clinic_user::class)
            <div class="card mt-4">
                <div class="card-body">
                    <h4 class="card-title w-100 mb-2">Clinics</h4>

                    <livewire:clinic-user-clinics-detail :clinicUser="$clinicUser" />
                </div>
            </div>
        @endcan --}}
    </div>
@endsection
