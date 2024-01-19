<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/viewclear', function(){
    Artisan::call('view:clear ',[]);
    return 'success';
});

Route::get('/cacheclear', function(){
    Artisan::call('cache:clear',[]);
    return 'success';
});

Route::get('/routeclear', function(){
    Artisan::call('route:clear',[]);
    return 'success';
});
Route::get('/routelist', function(){
    Artisan::call('route:list',[]);
    return 'success';
});

Route::get('/', function () {
    return view('welcome');
});

Route::get('/configClear', function(){
    Artisan::call('config:clear', []);
    return 'success';
});


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/homeview', [App\Http\Controllers\HomeController::class, 'homeview'])->name('homeview');
Route::get('/view_patient_details/{id}', [App\Http\Controllers\HomeController::class, 'view_patient_details'])->name('view_patient_details');
Route::post('/appointment_search', [App\Http\Controllers\HomeController::class, 'appointment_search'])->name('appointment_search');
Route::get('/view_appoiment_His_details/{channel_date}/{patient_id}', [App\Http\Controllers\HomeController::class, 'view_appoiment_details'])->name('view_appoiment_His_details');


//Patient
Route::get('/patientaddview', [App\Http\Controllers\PatientController::class, 'view'])->name('patientaddview');
Route::post('/patientadd', [App\Http\Controllers\PatientController::class, 'add'])->name('patient.add');
Route::get('/patientdelete/{id}', [App\Http\Controllers\PatientController::class, 'delete'])->name('patientdelete');
Route::get('/patient_list_view', [App\Http\Controllers\PatientController::class, 'patient_list_view'])->name('patient_list.view');
Route::post('/patient_list_search', [App\Http\Controllers\PatientController::class, 'patient_list_search'])->name('patient_list.search');
Route::post('/patient_list_search_by_family_name', [App\Http\Controllers\PatientController::class, 'patient_list_search_by_family_name'])->name('patient_list_by_family_name.search');
Route::get('/patienteditview/{id}', [App\Http\Controllers\PatientController::class, 'edit_view'])->name('patienteditview');
Route::get('/patienteditviewtable/{id}', [App\Http\Controllers\PatientController::class, 'edit_viewtable'])->name('patienteditviewtable');
Route::post('/patientupdate/{id}',[App\Http\Controllers\PatientController::class, 'update'])->name("patientupdate");

//Appoinment
Route::get('/appointmentaddview', [App\Http\Controllers\AppointmentController::class, 'view'])->name('appointment_addview');
Route::get('/appointmentListView', [App\Http\Controllers\AppointmentController::class, 'appointment_list'])->name('appointments_view');
Route::get('/appointmentadd/{id}', [App\Http\Controllers\AppointmentController::class, 'add'])->name('appointment.add');
Route::get('/waitingList', [App\Http\Controllers\AppointmentController::class, 'waitingList'])->name('waiting.list');
Route::get('/finishedList', [App\Http\Controllers\AppointmentController::class, 'finishedList'])->name('finished.list');
Route::post('/appoinmentfinished/{id}',[App\Http\Controllers\AppointmentController::class, 'finished'])->name("appoinmentfinished");


//DiagnosticCategories
Route::get('/diagnosticCategoriesAddView', [App\Http\Controllers\DiagnosticCategoriesController::class, 'view'])->name('diagnosticCategoriesAdd.view');
Route::post('/diagnosticCategoriesadd', [App\Http\Controllers\DiagnosticCategoriesController::class, 'add'])->name('diagnosticCategories.add');
Route::get('/diagnosticCategoriesListView', [App\Http\Controllers\DiagnosticCategoriesController::class, 'diagnosticCategories_list'])->name('diagnosticCategories_view');
Route::get('/diagnostic-categories /delete/{id}',[App\Http\Controllers\DiagnosticCategoriesController::class, 'delete'])->name('diagnosticCategories.delete');
Route::get('/diagnostic-categories /active/{id}',[App\Http\Controllers\DiagnosticCategoriesController::class, 'active'])->name('diagnosticCategories.active');
Route::post('/diagnostic_categorie_search', [App\Http\Controllers\DiagnosticCategoriesController::class, 'diagnostic_categorie_search'])->name('diagnosticCategorie.search');
Route::get('/diagnosticCategorieEdit/{id}', [App\Http\Controllers\DiagnosticCategoriesController::class, 'edit'])->name('diagnosticCategorieEdit');
Route::post('/diagnosticCategorieUpdate/{id}',[App\Http\Controllers\DiagnosticCategoriesController::class, 'update'])->name("diagnosticCategorieUpdate");

//Drugs
Route::get('/drugsAddView', [App\Http\Controllers\DrugsController::class, 'view'])->name('drugsAdd.view');
Route::post('/drugsAdd', [App\Http\Controllers\DrugsController::class, 'add'])->name('drugs.add');
Route::get('/drugsListView', [App\Http\Controllers\DrugsController::class, 'drugs_list'])->name('drugs_view');
Route::get('/drug-delete/{id}', [App\Http\Controllers\DrugsController::class, 'delete'])->name('drug.delete');
Route::get('/drug-active/{id}', [App\Http\Controllers\DrugsController::class, 'active'])->name('drug.active');
Route::post('/drug_search', [App\Http\Controllers\DrugsController::class, 'drug_search'])->name('drug.search');
Route::get('/drugEdit/{id}', [App\Http\Controllers\DrugsController::class, 'edit'])->name('drugEdit');
Route::post('/drugUpdate/{id}',[App\Http\Controllers\DrugsController::class, 'update'])->name("drugUpdate");
Route::get('/drughistory/{id}', [App\Http\Controllers\DrugsController::class, 'drughistory'])->name('drughistory');


//Medical Test
Route::get('/medicalTestView', [App\Http\Controllers\MedicalTestController::class, 'medical_test_list'])->name('medical_test_view');
Route::get('/medicalTestAddView', [App\Http\Controllers\MedicalTestController::class, 'view'])->name('medicalTestAdd.view');
Route::post('/medicalTestAdd', [App\Http\Controllers\MedicalTestController::class, 'add'])->name('medicalTest.add');
Route::get('/medicalTest-delete/{id}', [App\Http\Controllers\MedicalTestController::class, 'delete'])->name('medicalTest.delete');
Route::get('/medicalTest-active/{id}', [App\Http\Controllers\MedicalTestController::class, 'active'])->name('medicalTest.active');
Route::post('/medicalTest_search', [App\Http\Controllers\MedicalTestController::class, 'medical_test_search'])->name('medicalTest.search');
Route::get('/medicalTestEdit/{id}', [App\Http\Controllers\MedicalTestController::class, 'edit'])->name('medicalTestEdit');
Route::post('/medicalTestUpdate/{id}',[App\Http\Controllers\MedicalTestController::class, 'update'])->name("medicalTestUpdate");





Route::get('/investigationhistory/{id}', [App\Http\Controllers\PatientController::class, 'investigationhistory'])->name('investigationhistory');
Route::get('/medicalhistory/{id}', [App\Http\Controllers\PatientController::class, 'medicalhistory'])->name('medicalhistory');
Route::get('/investigation_history/{id}', [App\Http\Controllers\PatientController::class, 'investigation_history'])->name('investigation_history');
Route::post('/genReport', [App\Http\Controllers\PatientController::class, 'genReport'])->name('generate.report');
Route::post('/drugReport', [App\Http\Controllers\PatientController::class, 'drugReport'])->name('drug.report');
Route::post('/reportgenaret', [App\Http\Controllers\AppointmentController::class, 'handleAjaxRequest'])->name('handle.ajax.request');
Route::get('/view_patient_cancel/{id}', [App\Http\Controllers\AppointmentController::class, 'cancel'])->name('view_patient_cancel');
Route::get('/appointmenthistory/{id}', [App\Http\Controllers\AppointmentController::class, 'history'])->name('appointment.history');
Route::get('/helps', [App\Http\Controllers\HomeController::class, 'helps'])->name('helps');




