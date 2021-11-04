<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TransController;
use App\Http\Controllers\CsvController;
use App\Http\Controllers\CalenderController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\WebPushController;
use App\Http\Controllers\SampleController;


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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/', [AdminController::class, 'index'])->name('home');

Route::post('/sum_change', [AdminController::class, 'sum_change'])->name('sum_change');

Route::get('/expensenform', [AdminController::class, 'expensenForm'])->name('expensenForm');
Route::post('/expensen_input', [AdminController::class, 'expensen_input'])->name('expensen_input');

Route::get('/admin/trans/user_id={id}&month={ym}', [AdminController::class, 'admintrans']);
Route::post('/admin/trans/csvexp', [AdminController::class, 'csvexp'])->name('admin.csvexp');
Route::get('/admin/other/user_id={id}&month={ym}', [AdminController::class, 'adminother']);
Route::post('/admin/other_change', [AdminController::class, 'other_change']);

Route::post('/admin/updateItems', [AdminController::class, 'updateItems'])->name('admin.updateItems');

Route::get('/usernew', [AdminController::class, 'usernew'])->name('usernew');
Route::get('/user_search', [AdminController::class, 'user_search'])->name('user_search');
Route::post('/user_input', [AdminController::class, 'user_input'])->name('user_input');
Route::get('/user/user_id={id}', [AdminController::class, 'userdetail'])->name('userdetail');
Route::post('/usercreate', [AdminController::class, 'usercreate'])->name('usercreate');
Route::get('/userlist', [AdminController::class, 'userlist'])->name('userlist');

Route::get('/company_new', [AdminController::class, 'company_new'])->name('company_new');
Route::post('/company_input', [AdminController::class, 'company_input'])->name('company_input');
Route::get('/company_detail/id={id}', [AdminController::class, 'company_detail'])->name('company_detail');
Route::get('/companylist', [AdminController::class, 'companylist'])->name('companylist');

Route::get('/calendar', [CalenderController::class, 'index'])->name('calendar');
Route::get('/caldender_detail/{ymd}', [CalenderController::class, 'caldender_detail']);
Route::get('/caldender_other_detail/{ymd}', [CalenderController::class, 'caldender_other_detail']);
Route::post('/applicant', [CalenderController::class, 'applicant'])->name('applicant');
Route::post('/admin_app_no', [CalenderController::class, 'admin_app_no'])->name('admin_app_no');
Route::post('/admin_app_ok', [CalenderController::class, 'admin_app_ok'])->name('admin_app_ok');

Route::get('/caldender_delete/{id}', [CalenderController::class, 'caldender_delete'])->name('caldender_delete');
Route::get('/caldender_relation_delete/{id}', [CalenderController::class, 'caldender_relation_delete'])->name('caldender_relation_delete');
Route::post('/calendar_detail_create', [CalenderController::class, 'calendar_detail_create'])->name('calendar_detail_create');
Route::get('/calendar_other', [CalenderController::class, 'calendar_other'])->name('calendar_other');


Route::get('/pitapa', [CsvController::class, 'index'])->name('pitapa.index');
Route::post('/pitapacsvup', [CsvController::class, 'pitapacsvup'])->name('import');
Route::get('/pitapa_complete/start={ymd1}&end={ymd2}', [CsvController::class, 'pitapacomplete']);
Route::post('/csv_appli', [CsvController::class, 'csv_appli'])->name('csv_appli');
Route::post('/create', [CsvController::class, 'create'])->name('create');

Route::get('/trans_new', [TransController::class, 'form'])->name('trans_new');
Route::post('/trans_input', [TransController::class, 'input'])->name('trans_input');
Route::get('/other_new', [TransController::class, 'other_form'])->name('other_new');
Route::post('/other_input', [TransController::class, 'other_input'])->name('other_input');
Route::post('/form_change', [TransController::class, 'form_change']);

Route::get('/userset/md5={md5}', [ForgotPasswordController::class, 'userset']);
Route::get('/passreset', [ForgotPasswordController::class, 'passreset'])->name('passreset');
Route::post('/reset', [ForgotPasswordController::class, 'reset'])->name('reset');
Route::get('/userreset/md5={md5}', [ForgotPasswordController::class, 'userreset']);
Route::post('/passset', [ForgotPasswordController::class, 'passset'])->name('passset');

Route::get('/myprofile', [AdminController::class, 'myprofile'])->name('myprofile');
Route::get('/user_profile/{id}', [AdminController::class, 'admin_myprofile'])->name('admin.userprofile');
Route::post('/profimage', [AdminController::class, 'profimage'])->name('profImage');

Route::get('/sample', [SampleController::class, 'sample']);
