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
Route::get('/client_login', 'ClientLogin@client_login');
Route::get('/clients', 'Clients@clients');
Route::get('/company_profile', 'OrganizationManagement@manage_company');
Route::get('/pick_up_and_delivery', 'OrganizationManagement@manage_pickUp_delivery');
Route::get('/employee_managment', 'Auth\RegisterController@manage_employee');
Route::get('/billing/{id}', 'ManageBilling@billing');
Route::get('/select_customer', 'ClientsForBilling@select_customer');
Route::get('/consignment_booking', 'ConsignmentManagement@consignment_booking');
Route::get('/consignment_booking_client', 'ConsignmentManagement@consignment_booking_client');
Route::get('/consignment_booked', 'ConsignmentManagement@consignment_booked');
Route::get('/complaints_suggestions', 'ComplaintsAndSuggestions@complaints_suggestions');
Route::get('/complaints_list', 'ComplaintsAndSuggestions@complaints_list');
Route::get('/complaints_list_client', 'ComplaintsAndSuggestions@complaints_list_client');
Route::get('/suggestions_list_client', 'ComplaintsAndSuggestions@suggestions_list_client');
Route::get('/suggestions_list', 'ComplaintsAndSuggestions@suggestions_list');

//Save
Route::post('/Client_save', 'Clients@save_client');
Route::post('/Company_save', 'OrganizationManagement@add_company');
Route::post('/PickUp_save', 'OrganizationManagement@add_pickUp');
Route::post('/SaveBilling', 'ManageBilling@save_billing');
Route::post('/client_login_form', 'ClientLogin@client_login_form');
Route::post('/SaveConsignmentClient', 'ConsignmentManagement@SaveConsignmentClient');
Route::post('/saveComplaints', 'ComplaintsAndSuggestions@saveComplaints');
Route::post('/saveSuggestion', 'ComplaintsAndSuggestions@saveSuggestions');

//Get Data to display on page
Route::get('/GetCompaniesList', 'OrganizationManagement@companies_list');
Route::get('/GetPickUpList', 'OrganizationManagement@pickUp_list');
Route::get('/GetCustomersListForBilling', 'ClientsForBilling@GetCustomersListForBilling');
Route::get('/GetCompliantsListClient', 'ComplaintsAndSuggestions@GetCompliantsListClient');
Route::get('/GetSuggestionsListClient', 'ComplaintsAndSuggestions@GetSuggestionsListClient');
Route::get('/GetConsignmentsList', 'ConsignmentManagement@GetConsignmentsList');

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

//Deactive or Active Employee
Route::get('/activate_employee', 'Employee@activate_employee');
Route::get('/deactivate_employee', 'Employee@deactivate_employee');

Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout');
Route::get('/cout', 'Clients@cout');



Route::post('/test-upload', 'ManageBilling@test');
Route::get('/testingRoute/{test}', 'ManageBilling@testUnlink');
