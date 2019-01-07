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

Route::get('/', function () {
    return redirect('/home');
});

Auth::routes();
Route::Resource('/Customer', 'Customer');

Route::Resource('/ProspectCustomers', 'ProspectCustomers');

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/GetCustomersList', 'Customer@CustomersList');
Route::get('/GetClientsList', 'Clients@ClientsList');

Route::get('/EmployeesList', 'Auth\RegisterController@EmployeesList');
Route::post('/UploadUserImage', 'Auth\RegisterController@UploadUserImage');
Route::get('/Employee/{id}', 'Employee@GetEmployeeInfo');
Route::post('/UpdateEmployee/{id}', 'Employee@UpdateEmployee');
Route::get('/CustomerTypes', 'CustomerTypes@index');
Route::post('/SaveCustomerType', 'CustomerTypes@store');
Route::get('/GetCustomerTypes', 'CustomerTypes@customerTypesList');
Route::delete('/DeleteCustomerType/{typeId}', 'CustomerTypes@deleteCustomerType');
Route::get('/GetCustomerTypeInfo/{typeId}', 'CustomerTypes@getCustomerTypeInfo');
Route::post('/UpdateCustomerType/{typeId}', 'CustomerTypes@update');
Route::get('/CustomerProfile/{customerId}', 'Customer@viewProfile');


//Views
Route::get('/clients', 'Clients@clients');
Route::get('/company_profile', 'OrganizationManagement@manage_company');
Route::get('/pick_up_and_delivery', 'OrganizationManagement@manage_pickUp_delivery');
Route::get('/employee_managment', 'Auth\RegisterController@manage_employee');

//Save
Route::post('/Client_save', 'Clients@save_client');
Route::post('/Company_save', 'OrganizationManagement@add_company');
Route::post('/PickUp_save', 'OrganizationManagement@add_pickUp');

//Get Data to display on page
Route::get('/GetCompaniesList', 'OrganizationManagement@companies_list');
Route::get('/GetPickUpList', 'OrganizationManagement@pickUp_list');

//Get data to show on update page
Route::get('/company_data/{id}', 'OrganizationManagement@get_company_data');
Route::get('/pickUp_data/{id}', 'OrganizationManagement@get_pickUp_data');
Route::get('/client_data/{id}', 'Clients@get_client_data');

//Update
Route::post('/company_update', 'OrganizationManagement@update_company');
Route::post('/pickUp_update', 'OrganizationManagement@update_pickUp');
Route::post('/client_update', 'Clients@update_client');

//Delete
Route::get('/DeleteCompany', 'OrganizationManagement@delete_company_entry');
Route::get('/DeletepickUp', 'OrganizationManagement@delete_pickUp_entry');
Route::get('/DeleteClient', 'Clients@delete_client_entry');

Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout');
