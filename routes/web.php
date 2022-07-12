<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\QrSessionController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SocialiteController;
use App\Http\Controllers\StudentAuthController;
use App\Http\Resources\AttendanceResource;
use App\Models\QrSession;
use App\Models\User;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    return redirect('admin/login');
});

Route::get('/student/login', [StudentAuthController::class, 'loginForm'])->name('student.login');
Route::get('/qr/login', [StudentAuthController::class, 'loginFormQr'])->name('student.login.qr');
Route::post('/student/login', [StudentAuthController::class, 'login']);
Route::get('/student/register', [StudentAuthController::class, 'registrationForm'])->name('student.register');
Route::post('/student/register', [StudentAuthController::class, 'register']);

Route::post('/classes/inv/mail', [InvitationController::class, 'sendMail']);
Route::get('/classes/{subject}/{section}/inv/m/{token}', [InvitationController::class, 'handleMailCallback']);
Route::get('/classes/{subject}/{section}/inv/l/{token}', [InvitationController::class, 'handleLinkCallback']);

Route::get('/qr/sub/{subject}/sec/{section}/{token}', [AttendanceController::class, 'handleQrCallback']);

Route::prefix('admin')->group(function () {

    Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'registrationForm']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::middleware('auth')->group(function () {
    
        Route::get('/classes', [GroupController::class, 'index']);
        Route::get('/classes/{subject}/{section}', [GroupController::class, 'show']);
        Route::post('/classes', [GroupController::class, 'store']);
    
        Route::get('/report', [ReportController::class, 'index']);
    
        Route::get('/qr-code', [QrSessionController::class, 'index']);
        Route::post('/qr-code', [QrSessionController::class, 'store']);

        Route::delete('/registrations/{registration}', [RegistrationController::class, 'destroy']);
    });
});

// Route::get('test/', function () {

//     $attendanceData = new AttendanceResource(
//         User::find(1)->groups()
//         ->with(['registrations' => function($query) {
//             $query->with(['student' => function($query) {
//                 $query->with(['attendances' => function($query) {
//                     $query->filter(request(['week']));
//                 }]);
//             }])
//             ->filter(request(['search']));
//         }])
//         ->filter(request(['subject', 'section']))
//         ->first()
//     );

//     return $attendanceData;
// });

require __DIR__.'/auth.php';
