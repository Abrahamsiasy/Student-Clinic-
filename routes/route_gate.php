<?php

use Illuminate\Http\Request;
use App\Models\CurrentCardRead;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GateController;
use Illuminate\Console\View\Components\Alert;

Route::prefix('/gate')->middleware('auth')->group(function () {
    Route::get('/', [GateController::class, 'index',])->name('gate');
    Route::post('/store', [GateController::class, 'store',])->name('gate.store');

    // Route::get('check/current-data/{gate_id}', [GateController::class, 'checkCurrentData'])->name('check.current_data');
    // Route::post('search/student', [GateController::class, 'searchStudent'])->name('search.student');
});
Route::get('gate/show/{id}', [GateController::class, 'show',])->name('gate.show');
Route::get('gate/check/current-data/{gate_id}', [GateController::class, 'checkCurrentData'])->name('check.current_data');
Route::post('gate/search/student', [GateController::class, 'searchStudent'])->name('search.student');

Route::get('/qa/mcardsea.php', function (Request $request) {
    CurrentCardRead::where('cjihao',$request->cjihao)->delete();
    CurrentCardRead::create(['card_id'=>$request->cardid, 'mjihao'=>$request->mjihao, 'cjihao'=>$request->cjihao, 'status'=>$request->status]);
});