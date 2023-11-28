<div>
    <div class="mb-4">
        @can('create', App\Models\Prescription::class)
            <button class="btn btn-primary" wire:click="newPrescription">
                <i class="icon ion-md-add"></i>
                @lang('crud.common.new')
            </button>
            @endcan @can('delete-any', App\Models\Prescription::class)
            <button class="btn btn-danger" {{ empty($selected) ? 'disabled' : '' }}
                onclick="confirm('Are you sure?') || event.stopImmediatePropagation()" wire:click="destroySelected">
                <i class="icon ion-md-trash"></i>
                @lang('crud.common.delete_selected')
            </button>
        @endcan
    </div>

    <x-modal id="encounter-prescriptions-modal" wire:model="showingModal">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ $modalTitle }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div>
                    {{-- lable for the radio toggle start --}}
                    <div>
                        {{-- Label for the radio toggle start --}}
                        {{-- <div class="form-group">
                            <label for="medication">Select Source:</label>
                            <input type="radio" wire:model="location_of_medication" value="pharmacy"
                                id="pharmacyRadio"> Pharmacy
                            <input type="radio" wire:model="location_of_medication" value="prescription"
                                id="prescriptionRadio"> Prescription
                        </div>
 --}}

                        <div class="form-group">
                            <label for="medication">Select Source:</label>
                            <input type="radio" wire:model="location_of_medication" value="pharmacy"
                                id="pharmacyRadio"> Pharmacy
                            <input type="radio" wire:model="location_of_medication" value="prescription"
                                id="prescriptionRadio"> Prescription
                        </div>
                        {{-- Label for the radio toggle end --}}



                        {{-- Livewire conditional rendering --}}
                        @if ($location_of_medication == 'pharmacy')
                            {{-- <div id="pharmacyInputs">
                                <label for="medication">Drug Name</label>
                                <select name="items_in_pharmacies_id" wire:model="prescription.items_in_pharmacies_id"
                                    maxlength="255">
                                    @foreach ($itemsInPharmcy as $item)
                                        <option value="{{ $item->id }}">{{ $item->item->product->name }}</option>
                                    @endforeach
                                </select>
                            </div> --}}
                            <div id="pharmacyInputs">
                                <label for="medication">Drug Name</label>
                                <select name="prescription.items_in_pharmacies_id"
                                    wire:model="prescription.items_in_pharmacies_id" maxlength="255">
                                    @foreach ($itemsInPharmcy as $item)
                                        <option value="{{ $item->id }}">{{ $item->item->product->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @elseif ($location_of_medication == 'prescription')
                            <x-inputs.group class="col-sm-12" id="prescriptionInputs">
                                <x-inputs.text name="prescription.drug_name" label="Drug Name"
                                    wire:model="prescription.drug_name" maxlength="255"></x-inputs.text>
                            </x-inputs.group>
                        @endif
                    </div>

                    <x-inputs.group class="col-sm-12">
                        <x-inputs.text name="prescription.dose" label="Dose" wire:model="prescription.dose"
                            maxlength="255" placeholder="Dose"></x-inputs.text>
                    </x-inputs.group>

                    <x-inputs.group class="col-sm-12">
                        <x-inputs.text name="prescription.frequency" label="Frequency"
                            wire:model="prescription.frequency" maxlength="255" placeholder="Frequency"></x-inputs.text>
                    </x-inputs.group>

                    <x-inputs.group class="col-sm-12">
                        <x-inputs.text name="prescription.duration" label="Duration" wire:model="prescription.duration"
                            maxlength="255" placeholder="Duration"></x-inputs.text>
                    </x-inputs.group>

                    <x-inputs.group class="col-sm-12">
                        <x-inputs.textarea name="prescription.other_info" label="Other Info"
                            wire:model="prescription.other_info" maxlength="255"></x-inputs.textarea>
                    </x-inputs.group>
                </div>

                {{-- Livewire script for the radio toggle start --}}

                {{-- Livewire script for the radio toggle end --}}

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

    <div class="table-responsive">
        <table class="table table-borderless table-hover">
            <thead>
                <tr>
                    <th>
                        <input type="checkbox" wire:model="allSelected" wire:click="toggleFullSelection"
                            title="{{ trans('crud.common.select_all') }}" />
                    </th>
                    <th class="text-left">
                        @lang('crud.encounter_prescriptions.inputs.drug_name')
                    </th>
                    <th class="text-left">
                        @lang('crud.encounter_prescriptions.inputs.dose')
                    </th>
                    <th class="text-left">
                        @lang('crud.encounter_prescriptions.inputs.frequency')
                    </th>
                    <th class="text-left">
                        @lang('crud.encounter_prescriptions.inputs.duration')
                    </th>
                    <th class="text-left">
                        @lang('crud.encounter_prescriptions.inputs.other_info')
                    </th>
                    <th></th>
                </tr>
            </thead>
            <tbody class="text-gray-600">
                @foreach ($prescriptions as $prescription)
                    <tr class="hover:bg-gray-100">
                        <td class="text-left">
                            <input type="checkbox" value="{{ $prescription->id }}" wire:model="selected" />
                        </td>
                        <td class="text-left">
                            {{ $prescription->drug_name ?? '-' }}
                        </td>
                        <td class="text-left">{{ $prescription->dose ?? '-' }}</td>
                        <td class="text-left">
                            {{ $prescription->frequency ?? '-' }}
                        </td>
                        <td class="text-left">
                            {{ $prescription->duration ?? '-' }}
                        </td>
                        <td class="text-left">
                            {{ $prescription->other_info ?? '-' }}
                        </td>
                        <td class="text-right" style="width: 134px;">
                            <div role="group" aria-label="Row Actions" class="relative inline-flex align-middle">
                                @can('update', $prescription)
                                    <button type="button" class="btn btn-sm btn-outline-primary mx-1""
                                        wire:click="editPrescription({{ $prescription->id }})">
                                        <i class="fa fa-edit"></i> Edit
                                    </button>
                                @endcan
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="6">{{ $prescriptions->render() }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
<div class="text-center mt-4">
    <button class="btn btn-success" onclick="printPrescription()">
        <i class="icon ion-md-print"></i> Print Prescription
    </button>
</div>

@push('scripts')
    <script>
        function printPrescription() {
            var printContents = document.querySelector('.prescription-view').innerHTML;
            var originalContents = document.body.innerHTML;

            document.body.innerHTML = '<div class="print-prescription-view">' + printContents + '</div>';
            window.print();

            document.body.innerHTML = originalContents;
        }
    </script>
@endpush

<style media="print">
    body * {
        visibility: hidden;
    }

    .print-prescription-view,
    .print-prescription-view * {
        visibility: visible;
    }

    .print-prescription-view {
        position: absolute;
        left: 0;
        top: 0;
    }

    .print-prescription-view .prescription-info {
        margin-bottom: 20px;
    }

    .print-prescription-view table {
        width: 100%;
        margin-bottom: 20px;
        border-collapse: collapse;
    }

    .print-prescription-view table,
    .print-prescription-view th,
    .print-prescription-view td {
        border: 1px solid black;
    }

    .print-prescription-view th,
    .print-prescription-view td {
        padding: 10px;
        text-align: left;
    }

    .print-prescription-view .signature {
        margin-top: 30px;
    }

    /* Hide new and delete buttons when printing */
    .print-prescription-view .mb-4,
    .print-prescription-view .modal-footer {
        display: none;
    }
</style>
