<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    if(Auth::user())
        return redirect()->route('home');
    else
        return view('auth.login');
});

Auth::routes();

Route::resources([
    'millerregister' => 'MillerRegisterController',
]);

Route::group(['middleware' => 'auth'], function()
{
    Route::resources([
        'activity' => 'ActivityController',
        'divisions' => 'DivisionController',
        'areasandpowers' => 'AreasAndPowerController',
        'autometicmillers' => 'AutometicMillerController',
        'chaltypes' => 'ChalTypeController',
        'millerInactiveReasons' => 'MillerInactiveReasonsController',
        'chataldetails' => 'ChatalDetailController',
        'districts' => 'DistrictController',
        'events' => 'EventController',
        'eventPermissionTimes' => 'EventPermissionTimeController',
        'inspection_periods' => 'Inspection_periodController',
        'registration_permission_times' => 'Registration_permission_timeController',
        'godowndetails' => 'GodownDetailController',
        'millers' => 'MillerController',
        'milltypes' => 'MillTypeController',
        'millingunitmachineries' => 'MillingUnitMachineryController',
        'motordetails' => 'MotorDetailController',
        'motorpowers' => 'MotorPowerController',
        'steepinghousedetails' => 'SteepingHouseDetailController',
        'upazillas' => 'UpazillaController',
        'users' => 'UserController',
        'userevents' => 'UserEventController',
        'reports' => 'ReportController',
        'todo' => 'ToDoController',
        'office_types' => 'Office_typeController',
        'offices' => 'OfficeController',
        'inspections' => 'InspectionController',
        'usertypes' => 'UserTypeController',
        'menus' => 'MenuController',
        'menupermissions' => 'MenuPermissionController',
        'license_types' => 'LicenseTypeController',
        'license_fees' => 'LicenseFeeController',
        'corporate_institutes' => 'CorporateInstituteController',
    ]);
});

//Route::resource('/todo', 'TodoController');
Route::put('/todos/{todo}/complete', 'TodoController@complete')->name('todo.complete');
Route::delete('/todos/{todo}/incomplete', 'TodoController@incomplete')->name('todo.incomplete');

Route::get('/user', 'UserController@index')->middleware('auth');

Route::post('/upload', 'UserController@uploadAvatar');

Route::get('/home', 'HomeController@index')->name('home')->middleware('auth');
//Route::get('/home', 'ReportController@summary')->name('home')->middleware('auth');

Route::get('/configuration', function () {
    return view('configuration.index');
})->middleware('auth');

Route::get('/manageusers', 'UserController@userindex')->middleware('auth');

Route::get('/myprofile', function () {
    return view('users.myprofile');
})->middleware('auth');

Route::get('changepassword', 'UserController@changepassword')->name('changepassword')->middleware('auth');
Route::post('changeuserpassword', 'UserController@changeuserpassword')->name('changeuserpassword');

Route::get('loginchangepassword', 'UserController@loginchangepassword')->name('loginchangepassword');
Route::post('loginchangeuserpassword', 'UserController@loginchangeuserpassword')->name('loginchangeuserpassword');

Route::get('changeotherpassword/{id}', 'UserController@changeotherpassword')->name('changeotherpassword');
Route::post('changeotheruserpassword/{id}', 'UserController@changeotheruserpassword')->name('changeotheruserpassword');

Route::post('districts/getDistrictListByDivId', 'DistrictController@getDistrictListByDivId')->name('districts.getDistrictListByDivId');
Route::post('districts/getAllDistrict', 'DistrictController@getAllDistrict')->name('districts.getAllDistrict');
Route::post('upazillas/getUpazillaListByDistId', 'UpazillaController@getUpazillaListByDistId')->name('upazillas.getUpazillaListByDistId');
Route::post('users/getUserListByDivId', 'UserController@getUserListByDivId')->name('users.getUserListByDivId');
Route::post('users/getUserListByDistId', 'UserController@getUserListByDistId')->name('users.getUserListByDistId');
Route::post('users/getUserListByUpzId', 'UserController@getUserListByUpzId')->name('users.getUserListByUpzId');
Route::post('users/getOfficeListByDivId', 'UserController@getOfficeListByDivId')->name('users.getOfficeListByDivId');
Route::post('users/getOfficeListByDistId', 'UserController@getOfficeListByDistId')->name('users.getOfficeListByDistId');
Route::post('users/getOfficeListByUpzId', 'UserController@getOfficeListByUpzId')->name('users.getOfficeListByUpzId');
Route::post('users/getOfficeListByDistId', 'UserController@getOfficeListByDistId')->name('users.getOfficeListByDistId');
Route::post('users/getOfficeListByLSD', 'UserController@getOfficeListByLSD')->name('users.getOfficeListByLSD');

Route::get('infowise', 'ReportController@infowise')->name('infowise')->middleware('auth');
Route::get('regionwise', 'ReportController@regionwise')->name('regionwise')->middleware('auth');
Route::get('typewise', 'ReportController@typewise')->name('typewise')->middleware('auth');
Route::post('printinfowise', 'ReportController@printinfowise')->name('printinfowise');
Route::post('printregionwise', 'ReportController@printregionwise')->name('printregionwise');
Route::post('printtypewise', 'ReportController@printtypewise')->name('printtypewise');

Route::get('summary/{chal_type_id}', 'ReportController@summary')->name('summary')->middleware('auth');
Route::get('/summarywithdivision/{id}/{chal_type_id}', 'ReportController@summarywithdivision')->name('summarywithdivision')->middleware('auth');
Route::get('/summarywithdistrict/{id}/{chal_type_id}', 'ReportController@summarywithdistrict')->name('summarywithdistrict')->middleware('auth');
Route::get('/summarywithupazilla/{id}/{chal_type_id}', 'ReportController@summarywithupazilla')->name('summarywithupazilla')->middleware('auth');

//Summary Corporate (আতপ - সিদ্ধ)

Route::get('summarycorporate/{chal_type_id}', 'ReportController@summarycorporate')->name('summarycorporate')->middleware('auth');
Route::get('/summarycorporatewithdivision/{id}/{chal_type_id}', 'ReportController@summarycorporatewithdivision')->name('summarycorporatewithdivision')->middleware('auth');
Route::get('/summarycorporatewithdistrict/{id}/{chal_type_id}', 'ReportController@summarycorporatewithdistrict')->name('summarycorporatewithdistrict')->middleware('auth');
Route::get('/summarycorporatewithupazilla/{id}/{chal_type_id}', 'ReportController@summarycorporatewithupazilla')->name('summarycorporatewithupazilla')->middleware('auth');

Route::patch('users.update3', 'UserController@update3')->name('users.update3');
Route::patch('users.updatedgfuser', 'UserController@updatedgfuser')->name('users.updatedgfuser');
Route::patch('users.updatelsduser', 'UserController@updatelsduser')->name('users.updatelsduser');
Route::patch('users.update6', 'UserController@update6')->name('users.update6');

Route::post('filterOffices', 'OfficeController@filterOffices')->name('filterOffices');
Route::post('searchSubmitMiller', 'MillerRegisterController@searchSubmitMiller')->name('searchSubmitMiller');

//Route::get('loginchangepassword', 'MillerRegisterController@loginchangepassword')->name('loginchangepassword');
//Route::post('loginchangeuserpassword', 'MillerRegisterController@loginchangeuserpassword')->name('loginchangeuserpassword');

Route::get('searchPasscode', 'MillerController@searchPasscode')->name('searchPasscode')->middleware('auth');

Route::get('deleteindex', 'UserController@deleteindex')->name('deleteindex')->middleware('auth');
Route::post('filterdeleteindex', 'UserController@filterdeleteindex')->name('filterdeleteindex');

Route::post('generate_pass_code', 'MillerController@generate_pass_code')->name('generate_pass_code')->middleware('auth');
Route::get('millers.fpshotfix', 'MillerController@fpshotfix')->name('millers.fpshotfix')->middleware('auth');
Route::post('inactiveMiller', 'MillerController@inactiveMiller')->name('inactiveMiller');
Route::get('millers.list', 'MillerController@list')->name('millers.list')->middleware('auth');
Route::get('millerListFPSStatus', 'MillerController@millerListFPSStatus')->name('millerListFPSStatus')->middleware('auth');
Route::get('millers.sendtofps', 'MillerController@sendtofps')->name('millers.sendtofps')->middleware('auth');
Route::get('millers.send2fps', 'MillerController@send2fps')->name('millers.send2fps')->middleware('auth');
Route::get('millers.approve', 'MillerController@approve')->name('millers.approve')->middleware('auth');
Route::get('millers.moveToHalnagadAutometic', 'MillerController@moveToHalnagadAutometic')->name('millers.moveToHalnagadAutometic');

Route::get('createuser', 'UserController@create')->middleware('auth');
Route::get('createuser1', 'UserController@create1')->middleware('auth');
Route::get('createuser2', 'UserController@create2')->middleware('auth');
Route::get('createuser3', 'UserController@create3')->middleware('auth');
Route::get('createuser4', 'UserController@create4')->middleware('auth');
Route::get('createuser5', 'UserController@create5')->middleware('auth');
Route::get('createuser6', 'UserController@create6')->middleware('auth');
Route::post('createuser', 'UserController@store');
Route::post('createuser1', 'UserController@store1');
Route::post('createuser2', 'UserController@store2');
Route::post('createuser3', 'UserController@store3');
Route::post('createuser4', 'UserController@store4');
Route::post('createuser5', 'UserController@store5');
Route::post('createuser6', 'UserController@store6');

Route::get('showpermission', 'UserEventController@showpermission')->name('showpermission')->middleware('auth');
Route::get('userpermissionlist', 'UserEventController@userpermissionlist')->name('userpermissionlist')->middleware('auth');

Route::get('editdivisionindex', 'UserController@editdivisionindex')->name('editdivisionindex')->middleware('auth');
Route::post('editdivisionuserlist', 'UserController@editdivisionuserlist')->name('editdivisionuserlist');
Route::get('editdisupzindex', 'UserController@editdisupzindex')->name('editdisupzindex')->middleware('auth');
Route::post('editdisupzuserlist', 'UserController@editdisupzuserlist')->name('editdisupzuserlist');
Route::get('editdgfindex', 'UserController@editdgfindex')->name('editdgfindex')->middleware('auth');
Route::post('editdgflist', 'UserController@editdgflist')->name('editdgflist');
Route::get('editlsdindex', 'UserController@editlsdindex')->name('editlsdindex')->middleware('auth');
Route::post('editlsdlist', 'UserController@editlsdlist')->name('editlsdlist');
Route::get('editsailoindex', 'UserController@editsailoindex')->name('editsailoindex')->middleware('auth');
Route::post('editsailolist', 'UserController@editsailolist')->name('editsailolist');
Route::get('newRegisterMiller', 'MillerController@newRegisterMiller')->name('newRegisterMiller')->middleware('auth');
Route::get('invalidLicence', 'MillerController@invalidLicence')->name('invalidLicence')->middleware('auth');
Route::get('validLicence', 'MillerController@validLicence')->name('validLicence')->middleware('auth');
Route::get('newLicence', 'MillerController@newLicence')->name('newLicence')->middleware('auth');
Route::get('duplicateLicence', 'MillerController@duplicateLicence')->name('duplicateLicence')->middleware('auth');

Route::post('menupermissionsupdate', 'MenuPermissionController@menupermissionsupdate')->name('menupermissionsupdate');

Route::post('exportusers', 'UserController@exportusers')->name('exportusers');

Route::post('exportpasscode', 'ReportController@exportpasscode')->name('exportpasscode');

Route::post('exportinfowise', 'ReportController@exportinfowise')->name('exportinfowise');
Route::post('exportregionwise', 'ReportController@exportregionwise')->name('exportregionwise');
Route::post('exporttypewise', 'ReportController@exporttypewise')->name('exporttypewise');

Route::get('exportdivision', 'DivisionController@export')->middleware('auth');

Route::get('nopermission', function () {
    return view('nopermission');
})->middleware('auth');

Route::post('verifyNID', 'MillerController@verifyNID')->name('verifyNID');
Route::post('activateMiller', 'MillerController@activateMiller')->name('activateMiller');
Route::post('activateMill', 'MillerController@activateMill')->name('activateMill');
Route::post('getMillerByNID', 'MillerController@getMillerByNID')->name('getMillerByNID');
Route::post('getSelectedForms', 'MillerController@getSelectedForms')->name('getSelectedForms');
Route::post('getSelectedLicenseForms', 'MillerController@getSelectedLicenseForms')->name('getSelectedLicenseForms');
Route::post('getSelectedLicenseHistory', 'MillerController@getSelectedLicenseHistory')->name('getSelectedLicenseHistory');

Route::get('api-test', 'ApiTestController@index')->middleware('auth');
