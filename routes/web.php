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
    CRUD::resource('curriculums','CurriculumCrudController');
    CRUD::resource('admins','AdminsCrudController');
    CRUD::resource('countries','CountriesCrudController');
    CRUD::resource('departments','DepartmentsCrudController');
    CRUD::resource('cities','CitiesCrudController');
    CRUD::resource('towns','TownsCrudController');
    CRUD::resource('neighborhoods','NeighborhoodsCrudController');
    CRUD::resource('professions','ProfessionsCrudController');
    CRUD::resource('companies','CompaniesCrudController');
    CRUD::resource('educations','Curriculum\EducationCrudController');
    CRUD::resource('languages','Curriculum\LanguageCrudController');
    CRUD::resource('skills','Curriculum\SkillCrudController');
    CRUD::resource('contracts','ContractsCrudController')->with(function(){
        Route::get('contracts/find','ContractsCrudController@find');
        Route::post('contracts/find','ContractsCrudController@findpost');
        Route::get('contracts/search/export','ContractsCrudController@export');
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

    CRUD::resource('visits','visitsCrudController');
    CRUD::resource('visit-subjects','Visits\SubjectCrudController');
    Route::post('visit/media-dropzone', ['uses' => 'visitsCrudController@handleDropzoneUpload']);
    CRUD::resource('electiontypes','ElectionTypeCrudController');
    CRUD::resource('elections','ElectionCrudController');
    CRUD::resource('candidates','CandidatesCrudController');
    CRUD::resource('candidacies','CandidaciesCrudController');
    CRUD::resource('election-support-types','ElectionSupportTypeCrudController');
    CRUD::resource('election-supports','ElectionSupportCrudController');
    CRUD::resource('election-city-results','ElectionCityCrudController');
    CRUD::resource('educational-institutions','EducationalInstitutionCrudController');
    CRUD::resource('levels','LevelCrudController');
});

Route::group(['middleware'=>['auth']],function(){
    Route::get('dashboard', 'DashboardController@index');
    CRUD::resource('profile','Users\ProfileCrudController');
    Route::post('curriculums/media-dropzone', ['uses' => 'CurriculumCrudController@handleDropzoneUpload']);
    Route::get('curriculums/{curriculum}/attachments','CurriculumCrudController@attachments');
    CRUD::resource('curriculum','UserCurriculumCrudController');
    Route::get(config('backpack.base.route_prefix', 'admin').'/curriculums/{id}/export','CurriculumCrudController@export');

    Route::get('/api/city', 'Api\CityController@index');
    Route::get('/api/city/{id}', 'Api\CityController@show');

    Route::get('/api/towns', 'Api\CityController@towns');
    Route::get('/api/neighborhoods', 'Api\CityController@neighborhoods');


});

Route::group(['middleware'=>['auth'],'prefix'=>'ajax','namespace'=>'Api'],function (){
    Route::get('user/{user}/visits','UserDashboardController@visit_attendance')->name('api.user.visits');
    Route::get('user/{user}/events/attendance','UserDashboardController@event_attendance')->name('api.user.events.asistance');

    Route::get('election/candidate', 'ElectionController@index');
    Route::get('elections', 'ElectionController@elections');

    Route::get('election/results/city', 'ElectionController@resultsCity')->name('api.election.results.city');
    Route::get('election/results/leader', 'ElectionController@resultsLeader')->name('api.election.results.leader');
    Route::get('election/results/candidate', 'ElectionController@resultsCandidate')->name('api.election.results.candidate');

    Route::get('users','UsersController@users');

});


