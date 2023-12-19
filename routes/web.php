<?php

use App\LabQueueCard;
use App\Models\ClinicUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SRSController;
use App\Http\Controllers\GateController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\QueueController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\CampusController;
use App\Http\Controllers\ClinicController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SpeechController;
use App\Http\Controllers\CollageController;
use App\Http\Controllers\LabTestController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\PharmacyController;
use App\Http\Controllers\ReligionController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\DiagnosisController;
use App\Http\Controllers\EncounterController;
use App\Http\Controllers\StockUnitController;
use App\Http\Controllers\VitalSignController;
use App\Http\Controllers\ClinicUserController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\LabCatagoryController;
use App\Http\Controllers\PrescriptionController;
use App\Http\Controllers\MainDiagnosisController;
use App\Http\Controllers\MedicalRecordController;
use App\Http\Controllers\StockCategoryController;
use App\Http\Controllers\ClinicServicesController;
use App\Http\Controllers\LabTestRequestController;
use App\Http\Controllers\ProductRequestController;
use App\Http\Controllers\ItemsInPharmacyController;
use App\Http\Controllers\MedicalSickLeaveController;
use App\Http\Controllers\LabTestRequestGroupController;
use App\Http\Controllers\ProductResponseController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    return redirect('/login');
});


Auth::routes();

// Route::get('/home', [HomeController::class, 'home'])->name('home');

Route::get('/sync-data', [SRSController::class, 'insert'])->name('sync');
Route::get('/sync-photo', [SRSController::class, 'fetchPhoto'])->name('sync-photo');
Route::get('/sync-program', [SRSController::class, 'srsData'])->name('sync.program');
Route::get('/sync-products', [ProductController::class, 'sync'])->name('sync.product');

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout');
Route::get('/lab-queue', [QueueController::class, 'getLabQueue'])->name('lab-queue');
Route::get('/opd-queue', [QueueController::class, 'getOPDQueue'])->name('opd-queue');
Route::prefix('/')->middleware('auth')->group(function () {
    //->middleware('redirectIfDoctor');
    Route::resource('roles', RoleController::class);
    Route::resource('permissions', PermissionController::class);
    Route::resource('appointments', AppointmentController::class);
    Route::resource('campuses', CampusController::class);
    Route::resource('clinics', ClinicController::class);
    Route::get('all-clinic-services', [ClinicServicesController::class, 'index',])->name('all-clinic-services.index');
    Route::post('/update-status', [HomeController::class, 'closeOpenCase'])->name('update.status');
    Route::post('all-clinic-services', [
        ClinicServicesController::class,
        'store',
    ])->name('all-clinic-services.store');
    Route::get('all-clinic-services/create', [
        ClinicServicesController::class,
        'create',
    ])->name('all-clinic-services.create');
    Route::get('all-clinic-services/{clinicServices}', [
        ClinicServicesController::class,
        'show',
    ])->name('all-clinic-services.show');
    Route::get('all-clinic-services/{clinicServices}/edit', [
        ClinicServicesController::class,
        'edit',
    ])->name('all-clinic-services.edit');
    Route::put('all-clinic-services/{clinicServices}', [
        ClinicServicesController::class,
        'update',
    ])->name('all-clinic-services.update');
    Route::delete('all-clinic-services/{clinicServices}', [
        ClinicServicesController::class,
        'destroy',
    ])->name('all-clinic-services.destroy');


    Route::get('/opd-queue-to-be', [QueueController::class, 'TableCOntent'])->name('opd-to-be');
    Route::post('/check-in', [HomeController::class, 'checkIn'])->name('checkin');
    Route::post('/unmap-rfid', [HomeController::class, 'unmapRfid'])->name('unmap-rfid');
    Route::post('/map-rfid', [HomeController::class, 'mapRfid'])->name('map-rfid');
    Route::post('/changeStatuss', [EncounterController::class, 'changeStatus'])->name('changeStatuss');
    Route::post('/rechecin', [EncounterController::class, 'rechecin'])->name('rechecin');
    // routes/web.php

    Route::post('/toggle-arrival', [EncounterController::class, 'toggleArrival'])->name('toggleArrival');

    Route::post('/approve', [EncounterController::class, 'approve'])->name('approval');

    Route::get('/encouter-list', [HomeController::class, 'getEncouter'])->name('encounter-list');
    Route::post('/autosearch-encounters', [HomeController::class, 'autoSearch'])->name('autosearch-encounters');
    Route::resource('clinic-users', ClinicUserController::class);
    Route::resource('collages', CollageController::class);
    Route::resource('diagnoses', DiagnosisController::class);
    Route::get('/reception', [EncounterController::class, 'reception'])->name('reception');
    Route::get('/lab-waiting', [EncounterController::class, 'labWaiting'])->name('lab.waiting');

    Route::post('/dignosis-encounter-create', [EncounterController::class, 'createMainDignosis'])->name('encounter.maindignosis');


    Route::resource('lab-catagories', LabCatagoryController::class);
    Route::resource('lab-tests', LabTestController::class);
    Route::resource('lab-test-requests', LabTestRequestController::class);

    Route::post('/labtest/request', [LabTestRequestController::class, 'insert'])->name('labTest.insert');

    Route::resource('lab-test-request-groups', LabTestRequestGroupController::class);
    Route::resource('main-diagnoses', MainDiagnosisController::class);
    Route::resource('medical-records', MedicalRecordController::class);
    // Route::resource('prescriptions', PrescriptionController::class);
    Route::resource('programs', ProgramController::class);
    Route::resource('religions', ReligionController::class);
    Route::resource('rooms', RoomController::class);
    Route::resource('stocks', StockController::class);
    Route::resource('stock-categories', StockCategoryController::class);
    Route::resource('stock-units', StockUnitController::class);
    Route::resource('students', StudentController::class);
    Route::resource('suppliers', SupplierController::class);
    Route::resource('gate', GateController::class);


    Route::resource('videos', VideoController::class);


    Route::resource('clinic-users', ClinicUserController::class);
    Route::post('/clinc/clinc-user-clinic-chage', [ClinicUserController::class, 'changeClinicClinic'])->name('clinic-change-user-clinic');
    Route::post('/clinc/clinc-user-room-chage', [ClinicUserController::class, 'changeClinicRoom'])->name('clinic-change-user-room');



    Route::resource('collages', CollageController::class);
    Route::resource('diagnoses', DiagnosisController::class);

    Route::get('/reception', [EncounterController::class, 'reception'])->name('reception');
    Route::get('/lab-waiting', [EncounterController::class, 'labWaiting'])->name('lab.waiting');
    Route::resource('lab-catagories', LabCatagoryController::class);
    Route::resource('lab-tests', LabTestController::class);
    Route::resource('lab-test-requests', LabTestRequestController::class);

    Route::post('/labtest/request', [LabTestRequestController::class, 'insert'])->name('labTest.insert');

    Route::resource('lab-test-request-groups', LabTestRequestGroupController::class);
    Route::resource('main-diagnoses', MainDiagnosisController::class);
    Route::resource('medical-records', MedicalRecordController::class);
    Route::resource('programs', ProgramController::class);
    Route::resource('religions', ReligionController::class);
    Route::resource('rooms', RoomController::class);
    Route::resource('stocks', StockController::class);
    Route::resource('stock-categories', StockCategoryController::class);
    Route::resource('stock-units', StockUnitController::class);
    Route::resource('students', StudentController::class);
    Route::resource('suppliers', SupplierController::class);

    Route::post('user/{user}/role_permission_update', [UserController::class, 'updateRoleAndPermission'])->name('user.role.permission.update');
    Route::post('/user/{user}/assignPharmacy', [UserController::class, 'assignPharamacyPlace'])->name('user.assignPharamacyPlace');
    Route::post('/user/{user}/assignStore', [UserController::class, 'assignStorePlace'])->name('user.assignStorePlace');
    Route::get('/store_and_pharmacy_users/pharmacy/assignPharmacy/{user}', [UserController::class, 'assignPharmacyView'])->name('store_and_pharmacy_users.assignPharamacyPlace');
    Route::post('/store_and_pharmacy_users/pharmacy/assignPharmacy/{user}', [UserController::class, 'assignPharmacy'])->name('user.assignPharamacy');
    Route::get('/store_and_pharmacy_users/store/assignStore/{user}', [UserController::class, 'assignStoreView'])->name('store_and_pharmacy_users.assignStorePlace');
    Route::post('/store_and_pharmacy_users/store/assignStore/{user}', [UserController::class, 'assignStore'])->name('user.assignStore');
    Route::get('/pharmacy/student/history', [PharmacyController::class, 'studentHistory'])->name('pharmacy.student.history');

    // Route::post('/')
    Route::resource('users', UserController::class);
    Route::resource('vital-signs', VitalSignController::class);


    Route::get('/encounters/opened', [EncounterController::class, 'openedEencounter'])->name('encounters.opened');

    Route::get('/print-sick-leave/{encounterId}', [EncounterController::class, 'generateSickLeavePdf'])->name('printSickLeave');


    Route::resource('encounters', EncounterController::class);

    Route::any('/search', [EncounterController::class, 'search'])->name('search');


    Route::post('/encounters/{encounter}', [EncounterController::class, 'callNext'])->name('encounters.callNext');
    // Route::post('/encounters/{encounter}/call-next', 'EncounterController@callNext')->name('encounters.callNext');
    Route::post('/encounters/{encounter}/changeDoctor', [EncounterController::class, 'changeDoctor'])->name('encounters.changeDoctor');


    Route::post('/encounters/{encounter}/room', [EncounterController::class, 'roomChange'])->name('encounters.room');


    Route::get('/encounters/{encounter}/accept', [EncounterController::class, 'accept'])->name('encounters.accept');


    Route::post('/encounters/{encounter}/close', [EncounterController::class, 'closeEencounter'])->name('encounters.closeEencounter');

    Route::post('/encounters/{encounter}/terminate', [EncounterController::class, 'termniateEencounter'])->name('encounters.termniateEencounter');



    Route::resource('medical-sick-leaves', MedicalSickLeaveController::class);


    // My routes

    Route::get('/store_and_pharmacy_users/pharmacy_users', [UserController::class, 'pharmacy_users'])->name('store_and_pharmacy_users.pharmacy');
    Route::get('/store_and_pharmacy_users/store_users', [UserController::class, 'store_users'])->name('store_and_pharmacy_users.store');
    Route::get('/product-requests/approve/{productRequest}', [ProductRequestController::class, 'approve'])->name('product-requests.approve');
    Route::get('/product-requests/reject/{productRequest}', [ProductRequestController::class, 'reject'])->name('product-requests.reject');
    Route::get('/product-requests/sentRequests', [ProductRequestController::class, 'sentRequests'])->name('product-requests.sentRequests');
    Route::get('/product-requests/records', [ProductRequestController::class, 'recordsOfRequests'])->name('product-requests.recordsOfRequests');

    Route::get('/prescriptions/history', [PrescriptionController::class, 'history'])->name('prescriptions.history');
    Route::get('/prescriptions/approve/{prescription}', [PrescriptionController::class, 'approve'])->name('prescriptions.approve');
    Route::get('/prescriptions/reject/{prescription}', [PrescriptionController::class, 'reject'])->name('prescriptions.reject');


    Route::get('/groupRequests/', [ProductRequestController::class, 'toBeApprove'])->name('groupRequest.index');
    Route::post('/groupRequest/approve/', [ProductRequestController::class, 'approveByAdmin'])->name('groupRequest.approve');
    Route::post('/groupRequest/reject/', [ProductRequestController::class, 'rejectByAdmin'])->name('groupRequest.reject');
    Route::get('/groupRequests/approved', [ProductResponseController::class, 'approved'])->name('groupRequest.approvedList');
    Route::get('/groupRequests/rejected', [ProductResponseController::class, 'rejected'])->name('groupRequest.rejectedList');

    Route::resource('stores', StoreController::class);
    Route::resource('products', ProductController::class);
    Route::resource('pharmacies', PharmacyController::class);
    Route::resource('product-requests', ProductRequestController::class);
    Route::resource(
        'items-in-pharmacies',
        ItemsInPharmacyController::class
    );
    Route::resource('prescriptions', PrescriptionController::class);



    Route::get('/submit', [SpeechController::class, 'submit'])->name('submit');
    Route::post('/changeRoomAll', [EncounterController::class, 'roomChangeAll'])->name('encounters.all');
    Route::resource('report', ReportController::class);
    Route::get('report/export-excel/{startDate}/{endDate}', [ReportController::class, 'exportExcel'])->name('opd-report.exportExcel');
});
