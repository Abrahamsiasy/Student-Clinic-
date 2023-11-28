<div>
    <div class="mb-4">
        @can('create', App\Models\LabTestRequest::class)
            <button class="btn btn-primary" wire:click="newLabTestRequest">
                <i class="icon ion-md-add"></i>
                @lang('crud.common.new')
            </button>
            @endcan @can('delete-any', App\Models\LabTestRequest::class)
            <button class="btn btn-danger" {{ empty($selected) ? 'disabled' : '' }}
                onclick="confirm('Are you sure?') || event.stopImmediatePropagation()" wire:click="destroySelected">
                <i class="icon ion-md-trash"></i> 
                @lang('crud.common.delete_selected')
            </button>
        @endcan
    </div>

    <x-modal id="lab-catagory-lab-test-requests-modal" wire:model="showingModal">
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
                        <x-inputs.datetime name="labTestRequest.sample_collected_at" label="Sample Collected At"
                            wire:model="labTestRequest.sample_collected_at" max="255"></x-inputs.datetime>
                    </x-inputs.group>

                    <x-inputs.group class="col-sm-12">
                        <x-inputs.datetime name="labTestRequest.sample_analyzed_at" label="Sample Analyzed At"
                            wire:model="labTestRequest.sample_analyzed_at" max="255"></x-inputs.datetime>
                    </x-inputs.group>

                    <x-inputs.group class="col-sm-12">
                        <x-inputs.text name="labTestRequest.status" label="Status" wire:model="labTestRequest.status"
                            maxlength="255" placeholder="Status"></x-inputs.text>
                    </x-inputs.group>

                    <x-inputs.group class="col-sm-12">
                        <x-inputs.text name="labTestRequest.notification" label="Notification"
                            wire:model="labTestRequest.notification" maxlength="255" placeholder="Notification">
                        </x-inputs.text>
                    </x-inputs.group>

                    <x-inputs.group class="col-sm-12">
                        <x-inputs.textarea name="labTestRequest.note" label="Note" wire:model="labTestRequest.note"
                            maxlength="255"></x-inputs.textarea>
                    </x-inputs.group>

                    <x-inputs.group class="col-sm-12">
                        <x-inputs.textarea name="labTestRequest.result" label="Result"
                            wire:model="labTestRequest.result" maxlength="255"></x-inputs.textarea>
                    </x-inputs.group>

                    <x-inputs.group class="col-sm-12">
                        <x-inputs.textarea name="labTestRequest.comment" label="Comment"
                            wire:model="labTestRequest.comment" maxlength="255"></x-inputs.textarea>
                    </x-inputs.group>

                    <x-inputs.group class="col-sm-12">
                        <x-inputs.text name="labTestRequest.analyser_result" label="Analyser Result"
                            wire:model="labTestRequest.analyser_result" maxlength="255" placeholder="Analyser Result">
                        </x-inputs.text>
                    </x-inputs.group>

                    <x-inputs.group class="col-sm-12">
                        <x-inputs.datetime name="labTestRequest.approved_at" label="Approved At"
                            wire:model="labTestRequest.approved_at" max="255"></x-inputs.datetime>
                    </x-inputs.group>

                    <x-inputs.group class="col-sm-12">
                        <x-inputs.number name="labTestRequest.price" label="Price" wire:model="labTestRequest.price"
                            max="255" step="0.01" placeholder="Price"></x-inputs.number>
                    </x-inputs.group>

                    <x-inputs.group class="col-sm-12">
                        <x-inputs.text name="labTestRequest.sample_id" label="Sample Id"
                            wire:model="labTestRequest.sample_id" maxlength="255" placeholder="Sample Id">
                        </x-inputs.text>
                    </x-inputs.group>

                    <x-inputs.group class="col-sm-12">
                        <x-inputs.datetime name="labTestRequest.ordered_on" label="Ordered On"
                            wire:model="labTestRequest.ordered_on" max="255"></x-inputs.datetime>
                    </x-inputs.group>

                    <x-inputs.group class="col-sm-12">
                        <x-inputs.select name="labTestRequest.lab_test_request_group_id" label="Lab Test Request Group"
                            wire:model="labTestRequest.lab_test_request_group_id">
                            <option value="null" disabled>Please select the Lab Test Request Group</option>
                            @foreach ($labTestRequestGroupsForSelect as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </x-inputs.select>
                    </x-inputs.group>

                    <x-inputs.group class="col-sm-12">
                        <x-inputs.select name="labTestRequest.sample_collected_by_id" label="Sample Ccollected By"
                            wire:model="labTestRequest.sample_collected_by_id">
                            <option value="null" disabled>Please select the Clinic User</option>
                            @foreach ($clinicUsersForSelect as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </x-inputs.select>
                    </x-inputs.group>

                    <x-inputs.group class="col-sm-12">
                        <x-inputs.select name="labTestRequest.sample_analyzed_by_id" label="Sample Analyzed By"
                            wire:model="labTestRequest.sample_analyzed_by_id">
                            <option value="null" disabled>Please select the Clinic User</option>
                            @foreach ($clinicUsersForSelect as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </x-inputs.select>
                    </x-inputs.group>

                    <x-inputs.group class="col-sm-12">
                        <x-inputs.select name="labTestRequest.approved_by_id" label="Approved By"
                            wire:model="labTestRequest.approved_by_id">
                            <option value="null" disabled>Please select the Clinic User</option>
                            @foreach ($clinicUsersForSelect as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </x-inputs.select>
                    </x-inputs.group>
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

    <div class="table-responsive">
        <table class="table table-hover  table-sm table-condensed">
            <thead>
                <tr>
                    <th>
                        <input type="checkbox" wire:model="allSelected" wire:click="toggleFullSelection"
                            title="{{ trans('crud.common.select_all') }}" />
                    </th>
                    <th class="text-left">
                    Sample taken at
                    </th>
                  
                    <th class="text-left">
                     Status
                    </th>
                 
                    <th class="text-left">
                    Note
                    </th>
                    <th class="text-left">
                     Result
                    </th>
                    <th class="text-left">
                     Comment
                    </th>
              
             
                    <th class="text-right">
                        Price
                    </th>
                    <th class="text-left"> 
                    Sample ID
                    </th>
                    <th class="text-left">
                      Order on
                    </th>
                    <th class="text-left">
                    Ordered by 
                    </th>
                    <th class="text-left">
                    Sample taken by
                    </th>
             
                 
                 
                </tr>
            </thead>
            <tbody class="text-gray-600">
                @foreach ($labTestRequests as $labTestRequest)
                    <tr class="hover:bg-gray-100">
                        <td class="text-left">
                            <input type="checkbox" value="{{ $labTestRequest->id }}" wire:model="selected" />
                        </td>
                        <td class="text-left">
                            {{ $labTestRequest->sample_collected_at ?? '-' }}
                        </td>
                     
                        <td class="text-left">
                            {{ $labTestRequest->status ?? '-' }}
                        </td>
                       
                        <td class="text-left">
                            {{ $labTestRequest->note ?? '-' }}
                        </td>
                        <td class="text-left">
                            {{ $labTestRequest->result ?? '-' }}
                        </td>
                        <td class="text-left">
                            {{ $labTestRequest->comment ?? '-' }}
                        </td>
                     
                 
                        <td class="text-right">
                            {{ $labTestRequest->price ?? '-' }}
                        </td>
                        <td class="text-left">
                            {{ $labTestRequest->sample_id ?? '-' }}
                        </td>
                        <td class="text-left">
                            {{ $labTestRequest->ordered_on ?? '-' }}
                        </td>
                        <td class="text-left">
                            {{ optional($labTestRequest->labTestRequestGroup)->id ?? '-' }}
                        </td>
                        <td class="text-left">
                            {{ optional($labTestRequest->sampleCcollectedBy)->id ?? '-' }}
                        </td>
                 
                     
                        <td class="text-right">
                            <div role="group" aria-label="Row Actions" class="relative inline-flex align-middle">
                                @can('update', $labTestRequest)
                                    <button type="button" class="btn btn-light"
                                        wire:click="editLabTestRequest({{ $labTestRequest->id }})">
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
                    <td colspan="17">{{ $labTestRequests->render() }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
