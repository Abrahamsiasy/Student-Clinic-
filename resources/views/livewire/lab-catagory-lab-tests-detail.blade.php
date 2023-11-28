<div>
    <div class="mb-4">
        @can('create', App\Models\LabTest::class)
            <button class="btn btn-primary" wire:click="newLabTest">
                <i class="icon ion-md-add"></i>
                @lang('crud.common.new')
            </button>
            @endcan @can('delete-any', App\Models\LabTest::class)
            <button class="btn btn-danger" {{ empty($selected) ? 'disabled' : '' }}
                onclick="confirm('Are you sure?') || event.stopImmediatePropagation()" wire:click="destroySelected">
                <i class="icon ion-md-trash"></i> 
                @lang('crud.common.delete_selected')
            </button>
        @endcan
    </div>

    <x-modal id="lab-catagory-lab-tests-modal" wire:model="showingModal">
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
                        <x-inputs.text name="labTest.test_name" label="Test Name" wire:model="labTest.test_name"
                            maxlength="255" placeholder="Test Name"></x-inputs.text>
                    </x-inputs.group>

                    <x-inputs.group class="col-sm-12">
                        <x-inputs.textarea name="labTest.test_desc" label="Test Desc" wire:model="labTest.test_desc"
                            maxlength="255"></x-inputs.textarea>
                    </x-inputs.group>

                    <x-inputs.group class="col-sm-12">
                        <x-inputs.text name="labTest.status" label="Status" wire:model="labTest.status" maxlength="255"
                            placeholder="Status"></x-inputs.text>
                    </x-inputs.group>

                    <x-inputs.group class="col-sm-12">
                        <x-inputs.checkbox name="labTest.is_available" label="Is Available"
                            wire:model="labTest.is_available"></x-inputs.checkbox>
                    </x-inputs.group>

                    <x-inputs.group class="col-sm-12">
                        <x-inputs.number name="labTest.price" label="Price" wire:model="labTest.price" max="255"
                            step="0.01" placeholder="Price"></x-inputs.number>
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
        <table class="table table-hover  table-bordered table-sm " >
            <thead>
                <tr>
                    <th>
                        <input type="checkbox" wire:model="allSelected" wire:click="toggleFullSelection"
                            title="{{ trans('crud.common.select_all') }}" />
                    </th>
                    <th class="text-left">
                     Lab test Name
                    </th>
                    <th class="text-left">
                    Description
                    </th>
                    <th class="text-left">
                        Total orders
                    </th>
                    <th class="text-left">
                    Status                                                                       
                    </th>
                    <th class="text-right">
                     Price
                    </th>
                    <th></th>
                </tr>
            </thead>
            <tbody class="text-gray-600">
                @foreach ($labTests as $labTest)
                    <tr class="hover:bg-gray-100">
                        <td class="text-left">
                            <input type="checkbox" value="{{ $labTest->id }}" wire:model="selected" />
                        </td>
                        <td class="text-left">{{ $labTest->test_name ?? '-' }}</td>
                        <td class="text-left">{{ $labTest->test_desc ?? '-' }}</td>
                        <td class="text-left">{{ $labTest->labTestRequests->count() ?? '0' }}</td>
                        <td class="text-left">
                              @if($labTest->is_available == 1)
                       

                              
                            

                              <span class="badge badge-info"> Avaliable </span>
             
                              @else
                           
                              <span class="badge badge-danger">   Not avaliable </span>
                              @endif
                        </td>
                        <td class="text-right">{{ $labTest->price ?? '-' }}</td>
                        <td class="text-right">
                            <div role="group" aria-label="Row Actions" class="relative inline-flex align-middle">
                                @can('update', $labTest)
                                    <button type="button" class="btn btn-light"
                                        wire:click="editLabTest({{ $labTest->id }})">
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
                    <td colspan="6">{{ $labTests->render() }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
