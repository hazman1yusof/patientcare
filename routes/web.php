<?php

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

Route::get('/', "DashboardController@redirect");

Route::get('/login', 'SessionController@index')->name('login');

Route::post('/login', 'SessionController@login');

Route::get('/signup', 'SessionController@show_signup');

Route::post('/signup', 'SessionController@signup');

Route::get('/logout','SessionController@destroy');

Route::get('/dashboard', "DashboardController@index")->name('dashboard');


Route::get('/user_maintenance', "UserMaintenanceController@show");
Route::get('/user_maintenance/table', "UserMaintenanceController@table");
Route::post('/user_maintenance/form', "UserMaintenanceController@form");

Route::get('/pivot', "PivotController@show");

Route::get('/pivot_get', "PivotController@get_json_pivot");

Route::get('/dialysis','DialysisController@index');
Route::get('/dialysis_event','DialysisController@dialysis_event');
Route::post('/change_status', "DialysisController@change_status");
Route::post('/save_dialysis', "DialysisController@save_dialysis");
Route::get('/get_data_dialysis', "DialysisController@get_data_dialysis");
Route::post('/transaction_save', "DialysisController@transaction_save");

Route::get('/prescription', "PrescriptionController@index");
Route::get('/prescription/{id}', "PrescriptionController@detail");

//dari msoftweb
Route::get('/preview','PreviewController@preview');
Route::get('/preview/data','PreviewController@previewdata');
Route::get('/localpreview','WebserviceController@localpreview');

Route::get('/previewvideo/{id}','PreviewController@previewvideo');

Route::get('/upload','PreviewController@upload');
Route::post('/upload','PreviewController@form');

Route::get('/emergency','EmergencyController@index');


Route::get('/download/{folder}/{image_path}','PreviewController@download');

//change carousel image to small thumbnail size
Route::get('/thumbnail/{folder}/{image_path}','PreviewController@thumbnail');

//appointment

Route::get('/appointment','AppointmentController@show')->name('appointment');;
Route::get('/appointment/table','AppointmentController@table');
Route::post('/appointment/form','AppointmentController@form');
Route::get('/appointment/getEvent','AppointmentController@getEvent');
Route::post('/appointment/addEvent','AppointmentController@addEvent');
Route::post('/appointment/editEvent','AppointmentController@editEvent');
Route::post('/appointment/delEvent','AppointmentController@delEvent');

//webservice luar
Route::get('/webservice/patmast','WebserviceController@patmast');
Route::get('/webservice/episode','WebserviceController@episode');
Route::get('/webservice/ticket','WebserviceController@ticket');
Route::get('/webservice/login','WebserviceController@login');

//util dr msoftweb
Route::get('/util/get_value_default','defaultController@get_value_default')->name('util_val');
Route::get('/util/get_table_default','defaultController@get_table_default')->name('util_tab');

//pivot
Route::get('/dashboard','eisController@dashboard')->name('dashboard');
Route::get('/store_dashb','WebserviceController@store_dashb');
Route::get('/eis','eisController@show')->name('eis');
Route::get('/reveis','eisController@reveis')->name('reveis');
Route::get('/pivot_get', "eisController@table");

//doctornote
Route::get('/doctornote','DoctornoteController@index');
Route::get('/doctornote/table','DoctornoteController@table')->name('doctornote_route');
Route::post('/doctornote/form','DoctornoteController@form');
Route::post('/doctornote_transaction_save', "DoctornoteController@transaction_save");


//// Dietetic Care Notes page ///
Route::get('/dieteticCareNotes','DieteticCareNotesController@show');
Route::get('/dieteticCareNotes/table','DieteticCareNotesController@table');
Route::post('/dieteticCareNotes/form','DieteticCareNotesController@form');


//// phys Care Notes page ///
Route::get('/phys','physioController@show');
Route::get('/phys/table','physioController@table');
Route::post('/phys/form','physioController@form');