<?php

namespace Database\Seeders;

use App\Constants;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;
use PHPUnit\TextUI\XmlConfiguration\Constant;
use Illuminate\Support\Facades\Log;

require_once app_path('Helper/constants.php');


class PermissionsSeeder extends Seeder
{
    public function run(): void
    {

        try {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // updateOrCreate default permissions
        Permission::updateOrCreate(['name' => 'list appointments']);
        Permission::updateOrCreate(['name' => 'view appointments']);
        Permission::updateOrCreate(['name' => 'create appointments']);
        Permission::updateOrCreate(['name' => 'update appointments']);
        Permission::updateOrCreate(['name' => 'delete appointments']);

        Permission::updateOrCreate(['name' => 'list campuses']);
        Permission::updateOrCreate(['name' => 'view campuses']);
        Permission::updateOrCreate(['name' => 'create campuses']);
        Permission::updateOrCreate(['name' => 'update campuses']);
        Permission::updateOrCreate(['name' => 'delete campuses']);

        Permission::updateOrCreate(['name' => 'list clinics']);
        Permission::updateOrCreate(['name' => 'view clinics']);
        Permission::updateOrCreate(['name' => 'create clinics']);
        Permission::updateOrCreate(['name' => 'update clinics']);
        Permission::updateOrCreate(['name' => 'delete clinics']);

        Permission::updateOrCreate(['name' => 'list allclinicservices']);
        Permission::updateOrCreate(['name' => 'view allclinicservices']);
        Permission::updateOrCreate(['name' => 'create allclinicservices']);
        Permission::updateOrCreate(['name' => 'update allclinicservices']);
        Permission::updateOrCreate(['name' => 'delete allclinicservices']);

        Permission::updateOrCreate(['name' => 'list clinicusers']);
        Permission::updateOrCreate(['name' => 'view clinicusers']);
        Permission::updateOrCreate(['name' => 'create clinicusers']);
        Permission::updateOrCreate(['name' => 'update clinicusers']);
        Permission::updateOrCreate(['name' => 'delete clinicusers']);

        Permission::updateOrCreate(['name' => 'list collages']);
        Permission::updateOrCreate(['name' => 'view collages']);
        Permission::updateOrCreate(['name' => 'create collages']);
        Permission::updateOrCreate(['name' => 'update collages']);
        Permission::updateOrCreate(['name' => 'delete collages']);

        Permission::updateOrCreate(['name' => 'list diagnoses']);
        Permission::updateOrCreate(['name' => 'view diagnoses']);
        Permission::updateOrCreate(['name' => 'create diagnoses']);
        Permission::updateOrCreate(['name' => 'update diagnoses']);
        Permission::updateOrCreate(['name' => 'delete diagnoses']);

        Permission::updateOrCreate(['name' => 'list encounters']);
        Permission::updateOrCreate(['name' => 'view encounters']);
        Permission::updateOrCreate(['name' => 'create encounters']);
        Permission::updateOrCreate(['name' => 'update encounters']);
        Permission::updateOrCreate(['name' => 'delete encounters']);

        Permission::updateOrCreate(['name' => 'list labcatagories']);
        Permission::updateOrCreate(['name' => 'view labcatagories']);
        Permission::updateOrCreate(['name' => 'create labcatagories']);
        Permission::updateOrCreate(['name' => 'update labcatagories']);
        Permission::updateOrCreate(['name' => 'delete labcatagories']);

        Permission::updateOrCreate(['name' => 'list labtests']);
        Permission::updateOrCreate(['name' => 'view labtests']);
        Permission::updateOrCreate(['name' => 'create labtests']);
        Permission::updateOrCreate(['name' => 'update labtests']);
        Permission::updateOrCreate(['name' => 'delete labtests']);

        Permission::updateOrCreate(['name' => 'list labtestrequests']);
        Permission::updateOrCreate(['name' => 'view labtestrequests']);
        Permission::updateOrCreate(['name' => 'create labtestrequests']);
        Permission::updateOrCreate(['name' => 'update labtestrequests']);
        Permission::updateOrCreate(['name' => 'delete labtestrequests']);

        Permission::updateOrCreate(['name' => 'list labtestrequestgroups']);
        Permission::updateOrCreate(['name' => 'view labtestrequestgroups']);
        Permission::updateOrCreate(['name' => 'create labtestrequestgroups']);
        Permission::updateOrCreate(['name' => 'update labtestrequestgroups']);
        Permission::updateOrCreate(['name' => 'delete labtestrequestgroups']);

        Permission::updateOrCreate(['name' => 'list maindiagnoses']);
        Permission::updateOrCreate(['name' => 'view maindiagnoses']);
        Permission::updateOrCreate(['name' => 'create maindiagnoses']);
        Permission::updateOrCreate(['name' => 'update maindiagnoses']);
        Permission::updateOrCreate(['name' => 'delete maindiagnoses']);

        Permission::updateOrCreate(['name' => 'list medicalrecords']);
        Permission::updateOrCreate(['name' => 'view medicalrecords']);
        Permission::updateOrCreate(['name' => 'create medicalrecords']);
        Permission::updateOrCreate(['name' => 'update medicalrecords']);
        Permission::updateOrCreate(['name' => 'delete medicalrecords']);

        Permission::updateOrCreate(['name' => 'list prescriptions']);
        Permission::updateOrCreate(['name' => 'view prescriptions']);
        Permission::updateOrCreate(['name' => 'create prescriptions']);
        Permission::updateOrCreate(['name' => 'update prescriptions']);
        Permission::updateOrCreate(['name' => 'delete prescriptions']);

        Permission::updateOrCreate(['name' => 'list programs']);
        Permission::updateOrCreate(['name' => 'view programs']);
        Permission::updateOrCreate(['name' => 'create programs']);
        Permission::updateOrCreate(['name' => 'update programs']);
        Permission::updateOrCreate(['name' => 'delete programs']);

        Permission::updateOrCreate(['name' => 'list religions']);
        Permission::updateOrCreate(['name' => 'view religions']);
        Permission::updateOrCreate(['name' => 'create religions']);
        Permission::updateOrCreate(['name' => 'update religions']);
        Permission::updateOrCreate(['name' => 'delete religions']);

        Permission::updateOrCreate(['name' => 'list rooms']);
        Permission::updateOrCreate(['name' => 'view rooms']);
        Permission::updateOrCreate(['name' => 'create rooms']);
        Permission::updateOrCreate(['name' => 'update rooms']);
        Permission::updateOrCreate(['name' => 'delete rooms']);

        Permission::updateOrCreate(['name' => 'list stocks']);
        Permission::updateOrCreate(['name' => 'view stocks']);
        Permission::updateOrCreate(['name' => 'create stocks']);
        Permission::updateOrCreate(['name' => 'update stocks']);
        Permission::updateOrCreate(['name' => 'delete stocks']);

        Permission::updateOrCreate(['name' => 'list stockcategories']);
        Permission::updateOrCreate(['name' => 'view stockcategories']);
        Permission::updateOrCreate(['name' => 'create stockcategories']);
        Permission::updateOrCreate(['name' => 'update stockcategories']);
        Permission::updateOrCreate(['name' => 'delete stockcategories']);

        Permission::updateOrCreate(['name' => 'list stockunits']);
        Permission::updateOrCreate(['name' => 'view stockunits']);
        Permission::updateOrCreate(['name' => 'create stockunits']);
        Permission::updateOrCreate(['name' => 'update stockunits']);
        Permission::updateOrCreate(['name' => 'delete stockunits']);

        Permission::updateOrCreate(['name' => 'list students']);
        Permission::updateOrCreate(['name' => 'view students']);
        Permission::updateOrCreate(['name' => 'create students']);
        Permission::updateOrCreate(['name' => 'update students']);
        Permission::updateOrCreate(['name' => 'delete students']);

        Permission::updateOrCreate(['name' => 'list suppliers']);
        Permission::updateOrCreate(['name' => 'view suppliers']);
        Permission::updateOrCreate(['name' => 'create suppliers']);
        Permission::updateOrCreate(['name' => 'update suppliers']);
        Permission::updateOrCreate(['name' => 'delete suppliers']);

        Permission::updateOrCreate(['name' => 'list vitalsigns']);
        Permission::updateOrCreate(['name' => 'view vitalsigns']);
        Permission::updateOrCreate(['name' => 'create vitalsigns']);
        Permission::updateOrCreate(['name' => 'update vitalsigns']);


        Permission::updateOrCreate(['name'=>'delete vitalsigns']);
        Permission::updateOrCreate(['name'=>'view-dashboard']);
        Permission::updateOrCreate(['name'=>'view-dashboard']);
        Permission::updateOrCreate(['name'=>'sync-student']);
        Permission::updateOrCreate(['name'=>'sync-photo']);
        Permission::updateOrCreate(['name'=>'patient-checkin']);
        Permission::updateOrCreate(['name'=>'view_lab_waiting']);
        Permission::updateOrCreate(['name'=>'waiting-queue']);
        Permission::updateOrCreate(['name'=>'view-lab-dispay']);
        Permission::updateOrCreate(['name'=>'view-OPD-dispay']);
        Permission::updateOrCreate(['name'=>'view-setting']);
        Permission::updateOrCreate(['name'=>'accept_patient']);
        Permission::updateOrCreate(['name' => 'reporting']);
        Permission::updateOrCreate(['name' => 'lab_notification']);
        Permission::updateOrCreate(['name' => 'result_notification']);
    //////////////////////////////////////////////////////////

        Permission::findOrCreate('store.*');
        Permission::findOrCreate('store.product.*');
        Permission::findOrCreate('store.product.index');
        Permission::findOrCreate('store.product.create');
        Permission::findOrCreate('store.product.update');
        Permission::findOrCreate('store.product.view');
        Permission::findOrCreate('store.product.item');
        Permission::findOrCreate('store.request.*');
        Permission::findOrCreate('store.request.index');
        Permission::findOrCreate('store.request.approve');
        Permission::findOrCreate('store.request.reject');
        Permission::findOrCreate('store.records.*');
        Permission::findOrCreate('store.records.index');
        Permission::findOrCreate('store.records.edit');
        Permission::findOrCreate('store.records.view');
        Permission::findOrCreate('store.records.delete');
        Permission::findOrCreate('pharmacy.*');
        Permission::findOrCreate('pharmacy.prescriptions.*');
        Permission::findOrCreate('pharmacy.prescriptions.index');
        Permission::findOrCreate('pharmacy.prescriptions.approve');
        Permission::findOrCreate('pharmacy.prescriptions.view');
        Permission::findOrCreate('pharmacy.products.*');
        Permission::findOrCreate('pharmacy.products.index');
        Permission::findOrCreate('pharmacy.products.*');
        Permission::findOrCreate('pharmacy.products.index');
        Permission::findOrCreate('pharmacy.products.request');
        Permission::findOrCreate('pharmacy.products.view');
        Permission::findOrCreate('pharmacy.history.*');

    //////////////////////////////////////////////////////////////////

        // updateOrCreate admin exclusive permissions
        Permission::updateOrCreate(['name' => 'list roles']);
        Permission::updateOrCreate(['name' => 'view roles']);
        Permission::updateOrCreate(['name' => 'create roles']);
        Permission::updateOrCreate(['name' => 'update roles']);
        Permission::updateOrCreate(['name' => 'delete roles']);

        Permission::updateOrCreate(['name' => 'list permissions']);
        Permission::updateOrCreate(['name' => 'view permissions']);
        Permission::updateOrCreate(['name' => 'create permissions']);
        Permission::updateOrCreate(['name' => 'update permissions']);
        Permission::updateOrCreate(['name' => 'delete permissions']);

        Permission::updateOrCreate(['name' => 'list users']);
        Permission::updateOrCreate(['name' => 'view users']);
        Permission::updateOrCreate(['name' => 'create users']);
        Permission::updateOrCreate(['name' => 'update users']);
        Permission::updateOrCreate(['name' => 'delete users']);




        $pharmacy_user = Role::updateOrCreate(['name' => Constants::PHARMACY_USER]);
        $store_user = Role::updateOrCreate(['name' => Constants::STORE_USER_ROLE]);



      //  $store_user = Role::updateOrCreate(Constants::STORE_USER_ROLE);

        $store_user->syncPermissions('store.*','store.product.*', 'store.product.index', 'store.product.create', 'store.product.update', 'store.product.view', 'store.product.item', 'store.request.*', 'store.request.index', 'store.request.approve', 'store.request.reject', 'store.records.*', 'store.records.index', 'store.records.view', 'store.records.edit', 'store.records.delete');



        $pharmacy_user->syncPermissions('pharmacy.*','pharmacy.prescriptions.*', 'pharmacy.prescriptions.index', 'pharmacy.prescriptions.approve', 'pharmacy.prescriptions.view', 'pharmacy.products.*', 'pharmacy.products.index', 'pharmacy.products.request', 'pharmacy.products.view', 'pharmacy.history.*');


        }
    catch (\Exception $e) {
        Log::error('Error in PermissionsSeeder: ' . $e->getMessage());
    }
    }

}
