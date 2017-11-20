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

//Auth::routes();

// Authentication Routes...
//$this->get('login', 'Auth\LoginController@showLoginForm')->name('login');
//$this->post('login', 'Auth\LoginController@login');
//$this->post('logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...
//$this->get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
//$this->post('register', 'Auth\RegisterController@register');

// Password Reset Routes...
//$this->get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
//$this->post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
//$this->get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
//$this->post('password/reset', 'Auth\ResetPasswordController@reset');


//Route::get('/', 'DashboardController@Home');


Route::group(['middleware' => 'web', 'prefix' => config('backpack.base.route_prefix')], function () {
    Route::auth();
    Route::get('logout', 'Auth\LoginController@logout');
});


Route::group(['middleware'=>['auth','adminsonly']],function(){
    CRUD::resource('users','UserCrudController');
    CRUD::resource('admins','AdminsCrudController');
    CRUD::resource('countries','CountriesCrudController');
    CRUD::resource('departments','DepartmentsCrudController');
    CRUD::resource('cities','CitiesCrudController');
    CRUD::resource('professions','ProfessionsCrudController');
    CRUD::resource('companies','CompaniesCrudController');
    CRUD::resource('educations','Curriculum\EducationCrudController');
    CRUD::resource('languages','Curriculum\LanguageCrudController');
    CRUD::resource('skills','Curriculum\SkillCrudController');
    CRUD::resource('contracts','ContractsCrudController')->with(function(){
        Route::get('contracts/find','ContractsCrudController@find');
        Route::post('contracts/find','ContractsCrudController@findpost');
    });

    CRUD::resource('events','EventsCrudController')->with(function(){
        Route::get('events/{event}/email','EventsCrudController@email');
        Route::post('events/{event}/email','EventsCrudController@sendemail');
    });
    CRUD::resource('eventtypes','EventTypeCrudController');

    CRUD::resource('events/{event}/attendance','AttendanceCrudController')->with(function(){
        Route::post('events/{event}/attendance/import','AttendanceCrudController@import');
        Route::put('events/{event}/attendance/attended','AttendanceCrudController@attended');

    });


    CRUD::resource('tempusers','tempUsersCrudController');
    CRUD::resource('birthdays','Users\birthdaysCrudController')->with(function(){
        Route::get('birthdays/{birthday}/email','Users\birthdaysCrudController@email');
        Route::post('birthdays/{birthday}/email','Users\birthdaysCrudController@sendemail');
    });

});

Route::group(['middleware'=>['auth']],function(){
    Route::get('dashboard', 'DashboardController@index');
    CRUD::resource('profile','Users\ProfileCrudController');
    Route::post('curriculum/media-dropzone', ['uses' => 'CurriculumCrudController@handleDropzoneUpload']);
    CRUD::resource('curriculum','CurriculumCrudController');
    Route::get(config('backpack.base.route_prefix', 'admin').'/curriculum/{id}/export','CurriculumCrudController@export');


    Route::get('/api/city', 'Api\CityController@index');
    Route::get('/api/city/{id}', 'Api\CityController@show');

});


