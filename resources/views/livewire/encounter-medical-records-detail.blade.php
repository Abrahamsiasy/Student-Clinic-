<div>
    <x-modal id="encounter-medical-records-modal" wire:model="showingModal">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ $modalTitle }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div>
                    <x-inputs.group class="col-sm-12">
                        <x-inputs.textarea name="medicalRecord.subjective" label="Subjective"
                            wire:model="medicalRecord.subjective" maxlength="255"></x-inputs.textarea>
                    </x-inputs.group>

                    <x-inputs.group class="col-sm-12">
                        <x-inputs.textarea name="medicalRecord.objective" label="Objective"
                            wire:model="medicalRecord.objective" maxlength="255"></x-inputs.textarea>
                    </x-inputs.group>

                    <x-inputs.group class="col-sm-12">
                        <x-inputs.textarea name="medicalRecord.assessment" label="Assessment"
                            wire:model="medicalRecord.assessment" maxlength="255"></x-inputs.textarea>
                    </x-inputs.group>

                    <x-inputs.group class="col-sm-12">
                        <x-inputs.textarea name="medicalRecord.plan" label="Plan" wire:model="medicalRecord.plan"
                            maxlength="255"></x-inputs.textarea>
                    </x-inputs.group>

                    <input type="hidden" name="medicalRecord.clinic_user_id" value="">


                    {{-- <x-inputs.group class="col-sm-12">
                        <x-inputs.select name="medicalRecord.clinic_user_id" label="Doctor"
                            wire:model="medicalRecord.clinic_user_id">
                            <option value="null" disabled>Please select the Clinic User</option>
                            @foreach ($clinicUsersForSelect as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </x-inputs.select>
                    </x-inputs.group> --}}
                    {{-- 
                    <x-inputs.group class="col-sm-12">
                        <x-inputs.select name="medicalRecord.student_id" label="Student"
                            wire:model="medicalRecord.student_id">
                            <option value="null" disabled>Please select the Student</option>
                            @foreach ($studentsForSelect as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </x-inputs.select>
                    </x-inputs.group> --}}
                </div>
            </div>

            @if ($editing)
            @endif

            <div class="modal-footer">
                <button type="button" class="btn btn-light float-left" wire:click="$toggle('showingModal')">
                    <i class="icon ion-md-close"></i>
                    @lang('crud.common.cancel')
                </button>

                <button type="button" class="btn btn-primary" wire:click="save">
                    <i class="icon ion-md-save"></i>
                    @lang('crud.common.save')
                </button>
            </div>
        </div>
    </x-modal>

    <div class="card-body">
        <div class="mb-4">
            @can('create', App\Models\MedicalRecord::class)
                <button class="btn btn-primary" wire:click="newMedicalRecord">
                    <i class="icon ion-md-add"></i>
                    @lang('crud.common.new')
                </button>
                @endcan @can('delete-any', App\Models\MedicalRecord::class)
                <button class="btn btn-danger" {{ empty($selected) ? 'disabled' : '' }}
                    onclick="confirm('Are you sure?') || event.stopImmediatePropagation()" wire:click="destroySelected">
                    <i class="icon ion-md-trash"></i>
                    @lang('crud.common.delete_selected')
                </button>
            @endcan
        </div>
        @foreach ($medicalRecords as $medicalRecord)
            <div class="h5">

                <input type="checkbox" value="{{ $medicalRecord->id }}" wire:model="selected" />

                {{-- {{ $medicalRecord->created_at }} --}}

                {{-- <span class="p small">By Dr. {{ optional($medicalRecord->Doctor)->id ?? '-' }}</span>
                 <span class="p small">By Dr. {{ $medicalRecord->subjective ?? '-' }}</span>
               
                 <span class="p small">By Dr. {{ $medicalRecord->assessment ?? '-' }}</span>
               
                 <span class="p small">By Dr. {{ $medicalRecord->plan ?? '-' }}</span>
                --}}

                @can('update', $medicalRecord)
                    <button type="button" class="btn btn-light" wire:click="editMedicalRecord({{ $medicalRecord->id }})">
                        <i class="fa fa-edit"></i> Edit
                    </button>
                @endcan
                {{-- 
                @can('delete-any', App\Models\MedicalRecord::class)
                    <button class="btn btn-danger" {{ empty($selected) ? 'disabled' : '' }}
                        onclick="confirm('Are you sure?') || event.stopImmediatePropagation()" wire:click="destroySelected">
                        <i class="icon ion-md-trash"></i>
                        @lang('crud.common.delete_selected')
                    </button>
                @endcan --}}

            </div>
            <div class="bigDiv">
                <div class="callout callout-danger">
                    <h5 class="mb-0">
                        <a href="#subjectiveContent-{{ $medicalRecord->id }}" class="text-dark" data-toggle="collapse"
                            role="button" aria-expanded="false"
                            aria-controls="subjectiveContent-{{ $medicalRecord->id }}">
                            <b>@lang('crud.encounter_medical_records.inputs.subjective')</b>
                        </a>
                    </h5>

                    <span class="p small">{{ $medicalRecord->subjective ?? '-' }}</span>

                </div>

                <div class="callout callout-info">
                    <h5 class="mb-0">
                        <a href="#objectiveContent-{{ $medicalRecord->id }}" class="text-dark" data-toggle="collapse"
                            role="button" aria-expanded="false"
                            aria-controls="objectiveContent-{{ $medicalRecord->id }}">
                            <b>@lang('crud.encounter_medical_records.inputs.objective')</b>
                        </a>
                    </h5>

                    <span class="p small"> {{ $medicalRecord->objective ?? '-' }}</span>

                </div>

                <div class="callout callout-warning">
                    <h5 class="mb-0">
                        <a href="#assessmentContent-{{ $medicalRecord->id }}" class="text-dark" data-toggle="collapse"
                            role="button" aria-expanded="false"
                            aria-controls="assessmentContent-{{ $medicalRecord->id }}">
                            <b>@lang('crud.encounter_medical_records.inputs.assessment')</b>
                        </a>
                    </h5>

                    <span class="p small"> {{ $medicalRecord->assessment ?? '-' }}</span>

                </div>
                <div class="callout callout-success">
                    <h5 class="mb-0">
                        <a href="#planContent-{{ $medicalRecord->id }}" class="text-dark" data-toggle="collapse"
                            role="button" aria-expanded="false" aria-controls="planContent-{{ $medicalRecord->id }}">
                            <b>@lang('crud.encounter_medical_records.inputs.plan')</b>
                        </a>
                    </h5>

                    <span class="p small">{{ $medicalRecord->plan ?? '-' }}</span>


                </div>
            </div>
        @endforeach

    </div>

</div>
