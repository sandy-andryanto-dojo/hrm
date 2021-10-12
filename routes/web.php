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

Auth::routes();
Route::get('/user/confirm/{token}', 'Auth\RegisterController@confirmation')->name('user.confirm');

Route::get('/', function () {
    return redirect('/home');
});

Route::get('/artisan', function () {
    Artisan::call('config:clear');
    Artisan::call('cache:clear');
    Artisan::call('config:Cache');
    if(isset($_SERVER['HTTP_HOST'])){
        $root=(isset($_SERVER['HTTPS']) ? "https://" : "http://").$_SERVER['HTTP_HOST'];
        $root.= str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);
        return "<script> window.location.href = '".$root."'; </script>";
    }
});


Route::get('/home', function () {
    if(\Auth::check()){
        $dashboard = \Auth::User()->can("view_dashboards");
        $profile = \Auth::User()->can("view_profiles");
        if($dashboard){
            return redirect()->route('dashboards.index');
        }else if($profile){
            return redirect()->route('profiles.index');
        }else{
            \Auth::logout();
            return redirect()->route('login')->with(['warning' => 'Maaf, anda tidak diberikan hak akses oleh administrator']);
        }
    }else{
        return redirect()->route('login');
    }
});

Route::group(['middleware' => ['auth', 'XSS', 'timeout']], function() {

    // Dashboard
    Route::resource('dashboards', '\App\Http\Controllers\Core\DashboardController');

    // Master Data
    Route::group(['prefix' => 'master'], function() {
        Route::resource('banks', '\App\Http\Controllers\Core\BankController');
        Route::resource('contacts', '\App\Http\Controllers\Core\ContactController');
        Route::resource('provinces', '\App\Http\Controllers\Core\ProvinceController');
        Route::resource('regencies', '\App\Http\Controllers\Core\RegencyController');
        Route::resource('annual_types', '\App\Http\Controllers\Core\AnnualTypeController');
        Route::resource('industries', '\App\Http\Controllers\Core\IndustryController');
        Route::resource('identity_types', '\App\Http\Controllers\Core\IdentityTypeController');
        Route::resource('jobs', '\App\Http\Controllers\Core\JobController');
        Route::resource('specializations', '\App\Http\Controllers\Core\SpecializationController');
        Route::resource('attachment_types', '\App\Http\Controllers\Core\AttachmentTypeController');
        Route::resource('allowance_types', '\App\Http\Controllers\Core\AllowanceTypeController');
        Route::resource('loss_types', '\App\Http\Controllers\Core\LossTypeController');
        Route::resource('employee_types', '\App\Http\Controllers\Core\EmployeeTypeController');
        Route::resource('marital_status', '\App\Http\Controllers\Core\MaritalStatusController');
        Route::resource('districts', '\App\Http\Controllers\Core\DistrictController');
        Route::resource('villages', '\App\Http\Controllers\Core\VillageController');
        Route::resource('holidays', '\App\Http\Controllers\Core\HolidayController');
    });

    // Employees
    Route::group(['prefix' => 'employees'], function() {
        Route::resource('workers', '\App\Http\Controllers\Core\EmployeeController');
        Route::resource('employee_allowances', '\App\Http\Controllers\Core\EmployeeAllowanceController');
        Route::resource('employee_cuts', '\App\Http\Controllers\Core\EmployeeCutController');
        Route::resource('employee_absences', '\App\Http\Controllers\Core\EmployeeAbsenceController');
        Route::resource('employee_mutations', '\App\Http\Controllers\Core\EmployeeMutationController');
        Route::resource('employee_promotions', '\App\Http\Controllers\Core\EmployeePromotionController');
        Route::resource('employee_retireds', '\App\Http\Controllers\Core\EmployeeRetiredController');
    });

     // Submission
     Route::group(['prefix' => 'submission'], function() {
        Route::group(['prefix' => 'employee_absences'], function() {
            Route::get('/{month}/{year}', '\App\Http\Controllers\Core\EmployeeAbsenceController@current')->name('employee_absences.current');
            Route::get('/detail/{month}/{year}/{id}', '\App\Http\Controllers\Core\EmployeeAbsenceController@detail')->name('employee_absences.detail');
            Route::get('/modify/{month}/{year}/{id}', '\App\Http\Controllers\Core\EmployeeAbsenceController@modify')->name('employee_absences.modify');
        });
        Route::resource('employee_annuals', '\App\Http\Controllers\Core\EmployeeAnnualController');
        Route::resource('employee_over_times', '\App\Http\Controllers\Core\EmployeeOverTimeController');
        Route::resource('employee_travels', '\App\Http\Controllers\Core\EmployeeTravelController');
        Route::resource('employee_loans', '\App\Http\Controllers\Core\EmployeeLoanController');
     });

     // Payroll
    Route::group(['prefix' => 'payrolls'], function() {
        Route::get('/{month}/{year}', '\App\Http\Controllers\Core\PayrollController@current')->name('payrolls.current');
        Route::get('/detail/{month}/{year}/{id}', '\App\Http\Controllers\Core\PayrollController@detail')->name('payrolls.detail');
        Route::get('/print/{month}/{year}/{id}', '\App\Http\Controllers\Core\PayrollController@printInvoice')->name('payrolls.print');
        Route::post('confirm', '\App\Http\Controllers\Core\PayrollController@confirm')->name('payrolls.confirm');
    });

    // Recruitment
    Route::group(['prefix' => 'recruitment'], function() {
        Route::resource('vacancies', '\App\Http\Controllers\Core\VacancyController');
        Route::resource('candidates', '\App\Http\Controllers\Core\CandidateController');
        Route::resource('acceptances', '\App\Http\Controllers\Core\AcceptanceController');
    });
   
    // Organization
    Route::group(['prefix' => 'organization'], function() {
        Route::resource('positions', '\App\Http\Controllers\Core\PositionController');
        Route::resource('divisions', '\App\Http\Controllers\Core\DivisionController');
    });

    // Report
    Route::resource('reports', '\App\Http\Controllers\Core\ReportController');


    // Setting
    Route::group(['prefix' => 'settings'], function() {
        Route::resource('accounts', '\App\Http\Controllers\Core\AccountController');
        Route::resource('audits', '\App\Http\Controllers\Core\AuditController');
        Route::resource('companies', '\App\Http\Controllers\Core\CompanyController');
        Route::resource('profiles', '\App\Http\Controllers\Core\ProfileController');
        Route::resource('users', '\App\Http\Controllers\Core\PersonController');
        Route::resource('roles', '\App\Http\Controllers\Core\GroupController');
        Route::resource('notifications', '\App\Http\Controllers\Core\NotificationController');
    });


});


