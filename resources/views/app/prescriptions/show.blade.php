@extends('layouts.app')

@section('content')
    <div class="card prescription-card">
        <div class="card-header prescription-header">
            <h4 class="card-title">Medical Prescription</h4>
        </div>

        <div class="card-body prescription-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="prescription-details">
                        <p><strong>Patient Name:</strong> {{ $prescription->encounter->student->first_name ?? '-' }}</p>
                        <p><strong>Date:</strong> {{ $prescription->created_at ?? '-' }}</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="prescription-details">
                        <p><strong>Doctor Name:</strong> {{ optional($prescription->encounter->Doctor)->name ?? '-' }}
                        </p>
                    </div>
                </div>
            </div>

            <hr>

            <div class="prescription-details">
                <h5 class="prescription-subtitle">Prescription Details:</h5>
                <p><strong>Drug Name:</strong> {{ $prescription->drug_name ?? '-' }}</p>
                <p><strong>Dose:</strong> {{ $prescription->dose ?? '-' }}</p>
                <p><strong>Frequency:</strong> {{ $prescription->frequency ?? '-' }}</p>
                <p><strong>Duration:</strong> {{ $prescription->duration ?? '-' }}</p>
                <p><strong>Other Info:</strong> {{ $prescription->other_info ?? '-' }}</p>
                <p><strong>Main Diagnosis ID:</strong> {{ optional($prescription->mainDiagnosis)->id ?? '-' }}</p>
            </div>
        </div>

        <div class="card-footer prescription-footer">
            <p class="prescription-signature"><strong>Doctor's Signature:</strong> ________________________</p>
        </div>
    </div>
@endsection
