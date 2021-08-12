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

Route::get('/', "ChatController@show");

Route::get('/login', 'SessionController@index')->name('login');

Route::post('/login', 'SessionController@login');

Route::get('/signup', 'SessionController@show_signup');

Route::post('/signup', 'SessionController@signup');

Route::get('/logout','SessionController@destroy');

Route::get('/dashboard', "DashboardController@index")->name('dashboard');

Route::get('/patient', "PatientController@index");

Route::post('/patient', "PatientController@store");

Route::put('/patient/{user}', "PatientController@update");

Route::delete('/patient/{user}', "PatientController@destroy");

Route::get('/doctor', "doctorController@index");

Route::post('/doctor', "doctorController@store");

Route::put('/doctor/{user}', "doctorController@update");

Route::delete('/doctor/{user}', "doctorController@destroy");

Route::get('/agent_detail/{user}', "doctorController@agent_detail");

Route::get('/settings', "SettingsController@index");

Route::get('/settings/change_password', "SettingsController@change_password");

Route::put('/settings/change_password/{user}', "SettingsController@update");

Route::post('/message', "MessageController@store");

Route::put('/message/{message}', "MessageController@update");

Route::get('/ticket/answer/{user}', "TicketController@answer");

Route::get('/ticket/create', "TicketController@create");

Route::post('/ticket/create', "TicketController@store");

Route::get('/ticket/{ticket}', "TicketController@show");

Route::get('/ticket', "TicketController@index")->name('ticket');

Route::post('/ticket', "TicketController@store");

Route::put('/ticket/{ticket}', "TicketController@update");

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


Route::get('/chat', "ChatController@show");
Route::get('/chat2', "ChatController@show2");

//dari msoftweb
Route::get('/preview','PreviewController@preview');
Route::get('/preview/data','PreviewController@previewdata');

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

//user
Route::get('/userlist','UserController@index')->name('userlist');
Route::get('/user/{id}','UserController@edit')->name('user');
Route::post('/user/{id}','UserController@update');
Route::get('/user','UserController@create');
Route::post('/user','UserController@store');
Route::get('/user/delete/{id}','UserController@destroy');
Route::get('/user/editpassword/{id}','UserController@editpassword');
Route::post('/user/editpassword/{id}','UserController@updatepassword');

//pivot
Route::get('/dashboard','eisController@dashboard')->name('dashboard');
Route::get('/store_dashb','WebserviceController@store_dashb');
Route::get('/eis','eisController@show')->name('eis');
Route::get('/reveis','eisController@reveis')->name('reveis');
Route::get('/pivot_get', "eisController@table");

//stisla ??
Route::name('js.')->group(function() {
    Route::get('dynamic.js', 'JsController@dynamic')->name('dynamic');
});