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
});

Route::group(['middleware'=>['auth']],function(){
    CRUD::resource('profile','Users\ProfileCrudController');
    CRUD::resource('curriculum','CurriculumCrudController');

    Route::get('/api/city', 'Api\CityController@index');
    Route::get('/api/city/{id}', 'Api\CityController@show');

});


