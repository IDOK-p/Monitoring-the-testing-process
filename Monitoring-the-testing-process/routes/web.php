<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShowController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\JournalController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\AdminController;

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

// Маршруты для навигации неавторизованного пользователя
Route::get('/', [ShowController::class, 'showHomePage'])->name('home-page');
Route::get('/download', [ShowController::class, 'showDownloadPage'])->name('download-page');
Route::get('/about', [ShowController::class, 'showAboutPage'])->name('about-page');
Route::get('/download/app', [DownloadController::class, 'downloadApp'])->name('download-app');

// Маршруты для авторизации пользователя
Route::get('/login', [LoginController::class, 'showLoginPage'])->name('login-page');
Route::post('/login', [LoginController::class, 'login'])->name('login');

// Маршруты для регистрации пользователя
Route::get('/registration', [RegistrationController::class, 'showRegistrationPage'])->name('registration-page');
Route::post('/register', [RegistrationController::class, 'register'])->name('registration');

// Маршруты для работы с профилем
Route::get('/profile', [ProfileController::class, 'showProfilePage'])->name('profile-page');
Route::get('/profile/edit', [ProfileController::class, 'showEditForm'])->name('edit-profile');
Route::post('/profile/update', [ProfileController::class, 'updateProfile'])->name('update-profile');
Route::post('/profile/delete', [ProfileController::class, 'deleteAccount'])->name('delete-account');
Route::post('/logout', [ProfileController::class, 'logout'])->name('logout');

// Маршруты для работы с классами
Route::get('/classes', [ClassController::class, 'showClassPage'])->name('class-page');
Route::get('/classes/create', [ClassController::class, 'showClassCreate'])->name('showClassCreate');
Route::post('/classes', [ClassController::class, 'store'])->name('storeClass');
Route::get('/classes/{id}', [ClassController::class, 'showClassDetails'])->name('showClassDetails');
Route::delete('/students/{id}', [ClassController::class, 'deleteStudent'])->name('deleteStudent');
Route::delete('/classes/{id}', [ClassController::class, 'deleteClass'])->name('deleteClass');
Route::get('/classes/{class}/add-student', [ClassController::class, 'showAddStudentForm'])->name('addStudentForm');
Route::post('/classes/add-student', [ClassController::class, 'addStudentByEmail'])->name('addStudentByEmail');


// Маршруты для работы с журналами
Route::get('/journal', [JournalController::class, 'showJournal'])->name('journal-page');
Route::post('/journal/filter', [JournalController::class, 'filterJournal'])->name('journal-filter');
Route::get('/journal/student/{student}/details', [JournalController::class, 'showStudentDetails'])->name('student-details');
Route::get('/test/{testId}/statistics', [JournalController::class, 'showTestStatistics'])->name('test-statistics');
Route::get('/journal/export', [JournalController::class, 'export'])->name('journal.export');

// Маршруты для работы с назначением тестов
Route::get('/tests', [TestController::class, 'showTests'])->name('tests-page');
Route::get('/tests/assign/{testId}', [TestController::class, 'assignTest'])->name('assign-test');
Route::get('/students/{classId}', [TestController::class, 'getStudentsByClass']);
Route::post('/assign-test/{testId}', [TestController::class, 'sendTestNotification'])->name('sendTestNotification');

// Маршруты для работы администраторов
Route::get('/admin/profile', [AdminController::class, 'showAdminProfilePage'])->name('admin-profile-page');
Route::get('/admin/edit', [AdminController::class, 'showEditForm'])->name('admin.edit-profile');
Route::post('/admin/update', [AdminController::class, 'updateProfile'])->name('admin.update-profile');
Route::post('/admin/delete', [AdminController::class, 'deleteAccount'])->name('admin.delete-account');
Route::post('/admin/logout', [AdminController::class, 'logout'])->name('admin-logout');

Route::get('/admin/cities', [AdminController::class, 'showCities'])->name('cities-page');
Route::get('/admin/cities/add', [AdminController::class, 'showAddCityForm'])->name('add-city-page');
Route::post('/admin/cities', [AdminController::class, 'storeCity'])->name('store-city');
Route::delete('/cities/{id}', [AdminController::class, 'deleteCity'])->name('delete-city');

Route::get('/admin/schools', [AdminController::class, 'showSchoolsPage'])->name('schools-page');
Route::get('/admin/schools/add/{city}', [AdminController::class, 'showAddSchoolForm'])->name('add-school-form');
Route::post('/admin/schools/add', [AdminController::class, 'storeSchool'])->name('store-school');
Route::delete('/schools/{id}', [AdminController::class, 'deleteSchools'])->name('delete-school');

Route::get('/admins', [AdminController::class, 'showAdminsPage'])->name('admins-page');
Route::delete('/admins/{id}', [AdminController::class, 'deleteAdmin'])->name('delete-admin');
Route::get('/admins/add', [AdminController::class, 'showAddAdminForm'])->name('add-admin-page');
Route::post('/admins/add', [AdminController::class, 'storeAdmin'])->name('store-admin');
Route::get('/admins/{id}/edit', [AdminController::class, 'showEditAdminForm'])->name('edit-admin-page');
Route::put('/admins/{id}', [AdminController::class, 'updateAdmin'])->name('update-admin');

Route::get('/admins/teachers', [AdminController::class, 'showTeachers'])->name('teachers-page');
Route::get('/admins/teachers/add', [AdminController::class, 'showAddTeacherForm'])->name('add-teacher-page');
Route::post('/admins/teachers/add', [AdminController::class, 'storeTeacher'])->name('store-teacher');
Route::delete('/admins/teachers/{id}', [AdminController::class, 'deleteTeacher'])->name('delete-teacher');
Route::get('/admins/teachers/{id}/edit', [AdminController::class, 'showEditTeacherForm'])->name('edit-teacher-page');
Route::put('/admins/teachers/{id}', [AdminController::class, 'updateTeacher'])->name('update-teacher');

Route::get('/admins/students', [AdminController::class, 'showStudents'])->name('students-page');
Route::get('/admins/students/add', [AdminController::class, 'showAddStudentForm'])->name('add-student-page');
Route::post('/admins/students/add', [AdminController::class, 'storeStudent'])->name('store-student');
Route::delete('/admins/students/{id}', [AdminController::class, 'deleteStudent'])->name('delete-student');
Route::get('/admins/students/{id}/edit', [AdminController::class, 'showEditStudentForm'])->name('edit-student-page');
Route::put('/admins/students/{id}', [AdminController::class, 'updateStudent'])->name('update-student');
