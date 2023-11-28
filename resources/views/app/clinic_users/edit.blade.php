@extends('layouts.app')

@section('content')
    <div class="">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">

                    <a href="{{ route('clinic-users.index') }}" class="mr-4"><i class="icon ion-md-arrow-back"></i></a>
                    @lang('crud.clinic_users.edit_title')
                </h4>


                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif


                <x-form method="PUT" action="{{ route('clinic-users.update', $clinicUser) }}" class="mt-4">
                    @include('app.clinic_users.form-inputs')

                    <div class="mt-4">
                        <a href="{{ route('clinic-users.index') }}" class="btn btn-light">
                            <i class="icon ion-md-return-left text-primary"></i>
                            @lang('crud.common.back')
                        </a>

                        <a href="{{ route('clinic-users.create') }}" class="btn btn-light">
                            <i class="icon ion-md-add text-primary"></i>
                            @lang('crud.common.create')
                        </a>

                        <button type="submit" class="btn btn-primary float-right">
                            <i class="icon ion-md-save"></i>
                            @lang('crud.common.update')
                        </button>
                    </div>
                </x-form>
            </div>
        </div>

        <div class="row">
            @can('view-any', App\Models\clinic_clinic_user::class)
                <div class="card m-4 col-4">
                    <div class="card-body">
                        <h4 class="card-title w-100 mb-2">Clinics</h4>

                        <livewire:clinic-user-clinics-detail :clinicUser="$clinicUser" />
                    </div>
                </div>
            @endcan
            @can('view-any', App\Models\clinic_user_room::class)
                <div class="card m-4 col-4">
                    <div class="card-body">
                        <h4 class="card-title w-100 mb-2">Rooms</h4>

                        <livewire:clinic-user-rooms-detail :clinicUser="$clinicUser" />
                    </div>
                </div>
            @endcan

        </div>


        {{-- @can('view-any', App\Models\LabTestRequest::class)
            <div class="card mt-4">
                <div class="card-body">
                    <h4 class="card-title w-100 mb-2">Lab Test Requests2</h4>

                    <livewire:clinic-user-lab-test-requests2-detail :clinicUser="$clinicUser" />
                </div>
            </div>
            @endcan @can('view-any', App\Models\MainDiagnosis::class)
            <div class="card mt-4">
                <div class="card-body">
                    <h4 class="card-title w-100 mb-2">Main Diagnoses</h4>

                    <livewire:clinic-user-main-diagnoses-detail :clinicUser="$clinicUser" />
                </div>
            </div>
            @endcan @can('view-any', App\Models\VitalSign::class)
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
            @endcan @can('view-any', App\Models\LabTestRequest::class)
            <div class="card mt-4">
                <div class="card-body">
                    <h4 class="card-title w-100 mb-2">Lab Test Requests</h4>

                    <livewire:clinic-user-lab-test-requests-detail :clinicUser="$clinicUser" />
                </div>
            </div>
            @endcan @can('view-any', App\Models\LabTestRequest::class)
            <div class="card mt-4">
                <div class="card-body">
                    <h4 class="card-title w-100 mb-2">Lab Test Requests3</h4>

                    <livewire:clinic-user-lab-test-requests3-detail :clinicUser="$clinicUser" />
                </div>
            </div>
        @endcan
         --}}
    </div>
@endsection
