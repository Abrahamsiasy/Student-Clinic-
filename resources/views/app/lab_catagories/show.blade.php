@extends('layouts.app')

@section('content')
<div class="">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a href="{{ route('lab-catagories.index') }}" class="mr-4"
                    ><i class="icon ion-md-arrow-back"></i
                ></a>
           Lab Category Details
            </h4>


            <table class="table" style="font-size: 20px;">
                <thead>
                  <tr>
         
                    <th scope="col">Lab Name</th>
                    <th scope="col">  Description:</th>
            
                  </tr>
                </thead>
                <tbody>
                  <tr>
         
                    <td>{{ $labCatagory->lab_name ?? '-' }} </td>
                    <td>{{ $labCatagory->lab_desc ?? '-' }}</td>
          
                  </tr>
     
            
                </tbody>
              </table>



            <div class="mt-4">
                <a
                    href="{{ route('lab-catagories.index') }}"
                    class="btn btn-light"
                >
                    <i class="icon ion-md-return-left"></i>
                    @lang('crud.common.back')
                </a>

                @can('create', App\Models\LabCatagory::class)
                <a
                    href="{{ route('lab-catagories.create') }}"
                    class="btn btn-light"
                >
                    <i class="icon ion-md-add"></i> @lang('crud.common.create')
                </a>
                @endcan
            </div>
        </div>
    </div>

    @can('view-any', App\Models\LabTest::class)
    <div class="card mt-4">
        <div class="card-body">
            <h4 class="card-title w-100 mb-2">Lab Tests</h4>

            <livewire:lab-catagory-lab-tests-detail
                :labCatagory="$labCatagory"
            />
        </div>
    </div>
    @endcan @can('view-any', App\Models\LabTestRequest::class)
    <div class="card mt-4">
        <div class="card-body">
            <h4 class="card-title w-100 mb-2">Lab Test Requests</h4>

            <livewire:lab-catagory-lab-test-requests-detail
                :labCatagory="$labCatagory"
            />
        </div>
    </div>
    @endcan
</div>
@endsection
