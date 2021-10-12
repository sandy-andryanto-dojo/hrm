<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::group(['middleware' => ['api', 'XSS'], 'prefix' => 'auth'], function ($router) {
    Route::post('login', '\App\Http\Controllers\Api\AuthController@login');
    Route::post('logout', '\App\Http\Controllers\Api\AuthController@logout');
    Route::post('refresh', '\App\Http\Controllers\Api\AuthController@refresh');
    Route::post('me', '\App\Http\Controllers\Api\AuthController@me');
});

Route::group(['middleware' => ['auth:api', 'XSS']], function() {

    Route::post('notifications', '\App\Http\Controllers\Api\NotificationController@getNotification');
    Route::post('dashboard', '\App\Http\Controllers\Api\DashboardController@getDashboard');

    Route::group(['prefix' => 'upload'], function() {
        Route::post('profile', '\App\Http\Controllers\Api\UploadController@profileImage')->name('api.upload.profile');
        Route::post('company', '\App\Http\Controllers\Api\UploadController@companyImage')->name('api.upload.company');
        Route::post('temp', '\App\Http\Controllers\Api\UploadController@temp')->name('api.upload.temp');
    });

    // FindByid
    Route::group(['prefix' => 'find'], function() {
        Route::post('employee/{id}', '\App\Http\Controllers\Api\EmployeeController@findEmployee')->name('api.find.employee');
    });

    // Select2 handler
    Route::group(['prefix' => 'select2'], function() {
        Route::post('regencies/{id}', '\App\Http\Controllers\Api\RegencyController@getByProvinceId')->name('api.select2.regencies');
        Route::post('districts/{id}', '\App\Http\Controllers\Api\DistrictController@getByRegencyId')->name('api.select2.districts');
        Route::post('employees', '\App\Http\Controllers\Api\EmployeeController@getEmployee')->name('api.select2.employees');
        Route::post('currencies', '\App\Http\Controllers\Api\CurrencyController@getCurrencies')->name('api.select2.currencies');
    });

    Route::group(['prefix' => 'datatable'], function() {
        // Master
        Route::post('banks', '\App\Http\Controllers\Api\BankController@dataTable');
        Route::post('contacts', '\App\Http\Controllers\Api\ContactController@dataTable');
        Route::post('provinces', '\App\Http\Controllers\Api\ProvinceController@dataTable');
        Route::post('regencies', '\App\Http\Controllers\Api\RegencyController@dataTable');
        Route::post('annual_types', '\App\Http\Controllers\Api\AnnualTypeController@dataTable');
        Route::post('industries', '\App\Http\Controllers\Api\IndustryController@dataTable');
        Route::post('identity_types', '\App\Http\Controllers\Api\IdentityTypeController@dataTable');
        Route::post('jobs', '\App\Http\Controllers\Api\JobController@dataTable');
        Route::post('specializations', '\App\Http\Controllers\Api\SpecializationController@dataTable');
        Route::post('attachment_types', '\App\Http\Controllers\Api\AttachmentTypeController@dataTable');
        Route::post('allowance_types', '\App\Http\Controllers\Api\AllowanceTypeController@dataTable');
        Route::post('loss_types', '\App\Http\Controllers\Api\LossTypeController@dataTable');
        Route::post('employee_types', '\App\Http\Controllers\Api\EmployeeTypeController@dataTable');
        Route::post('marital_status', '\App\Http\Controllers\Api\MaritalStatusController@dataTable');
        Route::post('districts', '\App\Http\Controllers\Api\DistrictController@dataTable');
        Route::post('villages', '\App\Http\Controllers\Api\VillageController@dataTable');
        Route::post('holidays', '\App\Http\Controllers\Api\HolidayController@dataTable');
        // Employees
        Route::post('workers', '\App\Http\Controllers\Api\EmployeeController@dataTable');
        Route::post('employee_mutations', '\App\Http\Controllers\Api\EmployeeMutationController@dataTable');
        Route::post('employee_promotions', '\App\Http\Controllers\Api\EmployeePromotionController@dataTable');
        Route::post('employee_retireds', '\App\Http\Controllers\Api\EmployeeRetiredController@dataTable');
        
        // Submission
        Route::post('employee_absences/{month}/{year}', '\App\Http\Controllers\Api\EmployeeAbsenceController@dataTableByMonthYear');
        Route::post('employee_annuals', '\App\Http\Controllers\Api\EmployeeAnnualController@dataTable');
        Route::post('employee_over_times', '\App\Http\Controllers\Api\EmployeeOverTimeController@dataTable');
        Route::post('employee_travels', '\App\Http\Controllers\Api\EmployeeTravelController@dataTable');
        Route::post('employee_loans', '\App\Http\Controllers\Api\EmployeeLoanController@dataTable');

        // Payroll
        Route::post('payrolls', '\App\Http\Controllers\Api\PayrollController@dataTable');

        // Organizations
        Route::post('positions', '\App\Http\Controllers\Api\PositionController@dataTable');
        Route::post('divisions', '\App\Http\Controllers\Api\DivisionController@dataTable');

        // Recruitment
        Route::post('vacancies', '\App\Http\Controllers\Api\VacancyController@dataTable');
        Route::post('candidates', '\App\Http\Controllers\Api\CandidateController@dataTable');
        Route::post('acceptances', '\App\Http\Controllers\Api\AcceptanceController@dataTable');

        // Setting
        Route::post('audits', '\App\Http\Controllers\Api\AuditController@dataTable');
        Route::post('roles', '\App\Http\Controllers\Api\GroupController@dataTable');
        Route::post('users', '\App\Http\Controllers\Api\PersonController@dataTable');
        Route::post('notifications', '\App\Http\Controllers\Api\NotificationController@dataTable');

    });

    Route::group(['prefix' => 'destroy'], function() {
        // Master
        Route::delete('banks/{id}', '\App\Http\Controllers\Api\BankController@destroy');
        Route::delete('contacts/{id}', '\App\Http\Controllers\Api\ContactController@destroy');
        Route::delete('provinces/{id}', '\App\Http\Controllers\Api\ProvinceController@destroy');
        Route::delete('regencies/{id}', '\App\Http\Controllers\Api\RegencyController@destroy');
        Route::delete('annual_types/{id}', '\App\Http\Controllers\Api\AnnualTypeController@destroy');
        Route::delete('industries/{id}', '\App\Http\Controllers\Api\IndustryController@destroy');
        Route::delete('identity_types/{id}', '\App\Http\Controllers\Api\IdentityTypeController@destroy');
        Route::delete('jobs/{id}', '\App\Http\Controllers\Api\JobController@destroy');
        Route::delete('specializations/{id}', '\App\Http\Controllers\Api\SpecializationController@destroy');
        Route::delete('attachment_types/{id}', '\App\Http\Controllers\Api\AttachmentTypeController@destroy');
        Route::delete('allowance_types/{id}', '\App\Http\Controllers\Api\AllowanceTypeController@destroy');
        Route::delete('loss_types/{id}', '\App\Http\Controllers\Api\LossTypeController@destroy');
        Route::delete('employee_types/{id}', '\App\Http\Controllers\Api\EmployeeTypeController@destroy');
        Route::delete('marital_status/{id}', '\App\Http\Controllers\Api\MaritalStatusController@destroy');
        Route::delete('districts/{id}', '\App\Http\Controllers\Api\DistrictController@destroy');
        Route::delete('villages/{id}', '\App\Http\Controllers\Api\VillageController@destroy');
        Route::delete('holidays/{id}', '\App\Http\Controllers\Api\HolidayController@destroy');
        // Employees
        Route::delete('workers/{id}', '\App\Http\Controllers\Api\EmployeeController@destroy');
        Route::delete('employee_mutations/{id}', '\App\Http\Controllers\Api\EmployeeMutationController@destroy');
        Route::delete('employee_promotions/{id}', '\App\Http\Controllers\Api\EmployeePromotionController@destroy');
        Route::delete('employee_retireds/{id}', '\App\Http\Controllers\Api\EmployeeRetiredController@destroy');
        // Submission
        Route::delete('employee_annuals/{id}', '\App\Http\Controllers\Api\EmployeeAnnualController@destroy');
        Route::delete('employee_over_times/{id}', '\App\Http\Controllers\Api\EmployeeOverTimeController@destroy');
        Route::delete('employee_travels/{id}', '\App\Http\Controllers\Api\EmployeeTravelController@destroy');
        Route::delete('employee_loans/{id}', '\App\Http\Controllers\Api\EmployeeLoanController@destroy');
        // Recruitment
        Route::delete('vacancies/{id}', '\App\Http\Controllers\Api\VacancyController@destroy');
        Route::delete('candidates/{id}', '\App\Http\Controllers\Api\CandidateController@destroy');
        Route::delete('acceptances/{id}', '\App\Http\Controllers\Api\AcceptanceController@destroy');
        // Organizations
        Route::delete('positions/{id}', '\App\Http\Controllers\Api\PositionController@destroy');
        Route::delete('divisions/{id}', '\App\Http\Controllers\Api\DivisionController@destroy');
        // Setting
        Route::delete('users/{id}', '\App\Http\Controllers\Api\PersonController@destroy');
        Route::delete('roles/{id}', '\App\Http\Controllers\Api\GroupController@destroy');
        Route::delete('notifications/{id}', '\App\Http\Controllers\Api\NotificationController@destroy');
    });

});