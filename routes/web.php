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
/*
Route::get('/', function () {
    return view('welcome');
});*/

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
Auth::routes();
Route::get('/', 'HomeController@index');

// Users
Route::prefix('account')->group(function () {

    Route::get('/add', 'AccountController@addaccount'); // add User To System View
    Route::post('/add', 'AccountController@addaccount'); // add User To System Post

});

// Diseases
Route::prefix('diseases')->group(function () {

    Route::get('/add', 'DiseasesController@create'); // add User To System View
    Route::post('/add', 'DiseasesController@create'); // add User To System Post





});

// Patients
Route::prefix('user')->group(function () {

    Route::get('add', 'PatientsController@add')->name('add.item');// Add
    Route::post('add', 'PatientsController@add')->name('add.item');//add

    Route::get('/search', 'PatientsController@show'); // search for patients

    Route::get('edit', 'PatientsController@edit');// Edit Page View

    Route::get('edit/{id}', 'PatientsController@update'); // update User info
    Route::post('edit/{id}', 'PatientsController@update')->name('update.item');

    Route::post('delete', 'PatientsController@delete')->name('delete.Patients');


    Route::get('/view/{id}', 'PatientsController@view'); // View Peation Card
    Route::get('/download/{id}', 'PatientsController@download'); // View Peation Card

    Route::get('update/{id}', 'PatientsController@update');
    Route::post('update/{id}', 'PatientsController@update')->name('update.item');

    Route::get('delete/{id}', 'PatientsController@delete')->name('delete.item');

});

// Centers
Route::prefix('center')->group(function () {

    Route::get('add', 'CenterController@add')->name('add.item');// Add
    Route::post('add', 'CenterController@add')->name('add.item');//add

    Route::get('/search', 'CenterController@show'); // View

    Route::get('edit', 'CenterController@edit');// Edit Page View

    Route::get('edit/{id}', 'CenterController@update'); // update User info
    Route::post('edit/{id}', 'CenterController@update')->name('update.item');

    Route::get('update/{id}', 'CenterController@update');
    Route::post('update/{id}', 'CenterController@update')->name('update.item');

    Route::get('delete/{id}', 'CenterController@delete')->name('delete.item');

});

// Accounter
Route::prefix('accounter')->group(function () {

    Route::get('/search', 'AccounterController@show'); // View

    Route::get('add', 'AccounterController@add')->name('add.item');// Add
    Route::post('add', 'AccounterController@add')->name('add.item');//add

    Route::get('edit', 'AccounterController@edit');// Edit Page View

    Route::get('update/{id}', 'AccounterController@update');
    Route::post('update/{id}', 'AccounterController@update')->name('update.item');

    Route::get('delete/{id}', 'AccounterController@delete')->name('delete.item');

});

// Doctors
Route::prefix('doctor')->group(function () {

    Route::get('/search', 'DoctorController@show'); // View

    Route::get('add', 'DoctorController@add')->name('add.item');// Add
    Route::post('add', 'DoctorController@add')->name('add.item');//add

    Route::get('edit', 'DoctorController@edit');// Edit Page View

    Route::get('edit/{id}', 'DoctorController@update'); // update User info
    Route::post('edit/{id}', 'DoctorController@update')->name('update.item');

    /*  Route::get('money/{id}','DoctorController@moeny');*/

    Route::get('dates/{id}', 'DoctorController@dates');


});

// Laboratory
Route::prefix('lab')->group(function () {

    Route::get('/search', 'LabsController@show'); // View

    Route::get('add', 'LabsController@add')->name('add.item');// Add
    Route::post('add', 'LabsController@add')->name('add.item');//add

    Route::get('edit', 'LabsController@edit');// Edit Page View

    Route::get('update/{id}', 'LabsController@update'); // update User info
    Route::post('update/{id}', 'LabsController@update')->name('update.item');


});

// Records
Route::prefix('records')->group(function () {

    Route::get('/search', 'RecordController@index'); // View
    Route::get('/select', 'RecordController@index'); // select user

    Route::get('add/{id}', 'RecordController@add')->name('add.item');// Add
    Route::post('add/{id}', 'RecordController@add')->name('add.item');//add

    Route::get('view/{id}', 'RecordController@show');// Edit Page View

    Route::get('doctor/{id}', 'RecordController@showDoctorRecord');// Edit Page View


    Route::get('/edit', 'RecordController@update'); // view  all user for select record

    Route::get('/user/{id}', 'RecordController@getuserrecord'); // update User info

    Route::get('/change/{id}', 'RecordController@updaterecord'); // update this Record
    Route::post('/change/{id}', 'RecordController@updaterecord'); // update this Record

});

// Dates
Route::prefix('dates')->group(function () {

    Route::get('choose', 'DatesController@index');

    Route::get('choose/{id}', 'DatesController@addMetting');
    Route::post('choose/{id}', 'DatesController@addMetting');

    Route::get('select', 'DatesController@viewMetting');

    Route::get('edit', 'DatesController@SelectToEdit');
    Route::get('DatesList/{id}', 'DatesController@DatesList');

    Route::get('view/{id}', 'DatesController@DatesData');
    Route::post('view/{id}', 'DatesController@DatesData');

    Route::get('delete/{id}', 'DatesController@deleteDates')->name('delete_dates');
    Route::post('delete/{id}', 'DatesController@deleteDates');


});

// Money
Route::prefix('money')->group(function () {

    Route::get('/select', 'TransitionsController@choose'); //
    // Center Move
    Route::get('/center/expense', 'TransitionsController@expenseCenter')->name('out'); // Center سحب
    Route::get('/center/income', 'TransitionsController@incomeCenter')->name('in'); // Center ايداع
    // Center in
    Route::get('/center/income/{uuid}', 'TransitionsController@inCenter')->name('in'); // Center Money in
    Route::post('/center/income/{uuid}', 'TransitionsController@inCenter')->name('in'); // Center Money Out
    // Center out
    Route::get('/center/expense/{uuid}', 'TransitionsController@outCenter')->name('in'); // Center Money in
    Route::post('/center/expense/{uuid}', 'TransitionsController@outCenter')->name('in'); // Center Money Out


    // Doctor Move
    Route::get('/doctors/expense', 'TransitionsController@expenseDoctor')->name('out'); // Doctor سحب
    Route::get('/doctors/income', 'TransitionsController@incomeDoctor')->name('in');; // Doctor أيداع

    // View Doctor in Center
    Route::get('/doctors/expense/{uuid}', 'TransitionsController@ViewDoctoeCenterexpense')->name('out'); // Doctor سحب
    Route::get('/doctors/income/{uuid}', 'TransitionsController@ViewDoctoeCenterincome')->name('in');; // Doctor أيداع
    // Doctor Money In
    Route::get('/doctors/income/push/{uuid}', 'TransitionsController@DoctorMoneyIn')->name('add_money');; // Doctor أيداع
    Route::post('/doctors/income/push/{uuid}', 'TransitionsController@DoctorMoneyIn')->name('in');; // Doctor أيداع
    // Doctor Money Out
    Route::get('/doctors/expense/pull/{uuid}', 'TransitionsController@DoctorMoneyOut')->name('in');; // Doctor أيداع
    Route::post('/doctors/expense/pull/{uuid}', 'TransitionsController@DoctorMoneyOut')->name('in');; // Doctor أيداع


    // Browser
    Route::get('/view', 'TransitionsController@Browser'); // Doctor أيداع
    //Route::post('/view','TransitionsController@BrowserView'); // Doctor أيداع


// Doctor in
    Route::get('/doctors/in', 'TransitionsController@DoctorsIn'); //
    Route::get('/doctors/in/{uuid}', 'TransitionsController@DoctorsInCenter'); //
    Route::get('/doctors/in/push/{uuid}', 'TransitionsController@DoctorsInCenteruuid'); //
    Route::post('/doctors/in/push/{uuid}', 'TransitionsController@DoctorsInCenteruuid'); //

// Doctor Out
    Route::get('/doctors/out', 'TransitionsController@DoctorsOut'); //
    Route::get('/doctors/out/{uuid}', 'TransitionsController@DoctorsOutCenter'); //
    Route::get('/doctors/out/pull/{uuid}', 'TransitionsController@DoctorsOutCenteruuid'); //
    Route::post('/doctors/out/pull/{uuid}', 'TransitionsController@DoctorsOutCenteruuid'); //


    // Center in
    Route::get('/center/in', 'TransitionsController@CenterIn'); //
    Route::get('/center/in/{uuid}', 'TransitionsController@CenterInCenteruuid'); //
    Route::post('/center/in/{uuid}', 'TransitionsController@CenterInCenteruuid'); //

    // Center in
    Route::get('/center/out', 'TransitionsController@CenterOut'); //
    Route::get('/center/out/{uuid}', 'TransitionsController@CenterOutCenteruuid'); //
    Route::post('/center/out/{uuid}', 'TransitionsController@CenterOutCenteruuid'); //

});

// Chat
Route::prefix('Treatment')->group(function () {

    Route::get('/add', 'TreatmentController@add')->name('add.Treatment');
    Route::post('/add', 'TreatmentController@add')->name('add.Treatment');

    Route::get('/contacts', 'TreatmentController@contacts')->name('update.item');
    Route::get('/Conversation/{id}', 'TreatmentController@Conversation')->name('update.item')->middleware('auth');

    Route::post('/Conversation/send', 'TreatmentController@Send')->name('update.item')->middleware('auth');

    //
    Route::get('/search', 'TreatmentController@search'); // Just View The Treatment

    Route::get('/edit', 'TreatmentController@view'); //  View The Treatment To Edit

    Route::get('/update/{id}', 'TreatmentController@update'); //  Update Treatment GET
    Route::post('/update/{id}', 'TreatmentController@update'); //  Update Treatment POST


});


// Chat
Route::prefix('messenger')->group(function () {

    Route::get('/', 'MessengerController@index')->name('update.item');
    Route::get('/contacts', 'MessengerController@contacts')->name('update.item');
    Route::get('/Conversation/{id}', 'MessengerController@Conversation')->name('update.item')->middleware('auth');

    Route::post('/Conversation/send', 'MessengerController@Send')->name('update.item')->middleware('auth');

});



