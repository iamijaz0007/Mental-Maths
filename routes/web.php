<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\StudentMiddleware;
use App\Http\Middleware\ParentMiddleware;
use App\Http\Middleware\PrincipalMiddleware;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\PrincipalController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ParentController;
use App\Http\Controllers\WorksheetController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\ProgressController;
use App\Http\Controllers\ErrorReportController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PracticeWorksheetController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [AuthenticationController::class, 'index'])->name('login');
Route::get('/logout', [AuthenticationController::class, 'logout'])->name('logout');
Route::post('/authenticate', [AuthenticationController::class, 'authenticate'])->name('authenticate');
Route::get('/profile', [AdminController::class, 'profile'])->name('profile');

Route::get('/register', [AuthenticationController::class, 'register'])->name('register');
Route::post('register-save', [AuthenticationController::class, 'registerSave'])->name('registerSave');

Route::get('forgot-password', [AuthenticationController::class, 'forgotpassword'])->name('forgotpassword');
Route::post('forgot-password', [AuthenticationController::class, 'Postforgotpassword'])->name('Postforgotpassword');
Route::get('password/reset/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.reset');

    Route::get('/profile', [UserController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [UserController::class, 'update'])->name('profile.update');

Route::middleware([AdminMiddleware::class])->group(function(){
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    // for assign parent and assign school
    Route::get('/admin/assign-child', [AdminController::class, 'showAssignChildForm'])->name('admin.assignChildForm');
    Route::post('/admin/assign-child', [AdminController::class, 'assignChild'])->name('admin.assignChild');
    Route::get('/admin/assign-principal', [AdminController::class, 'showAssignPrincipalForm'])->name('admin.assignPrincipalForm');
    Route::post('/admin/assign-principal', [AdminController::class, 'assignPrincipal'])->name('admin.assignPrincipal');

    // for school route
    Route::get('admin/schools-management', [SchoolController::class, 'index'])->name('school.list');
    Route::get('admin/schools-add', [SchoolController::class, 'add'])->name('school.add');
    Route::post('admin/school-save', [SchoolController::class, 'create'])->name('school.create');
    Route::get('admin/school-edit/{id}', [SchoolController::class, 'edit'])->name('school.edit');
    Route::put('admin/school-update/{id}', [SchoolController::class, 'update'])->name('school.update');
    Route::delete('admin/school-delete/{id}', [SchoolController::class, 'delete'])->name('school.delete');
    Route::post('admin/school/update-status/{id}', [SchoolController::class, 'updateStatus'])->name('school.updateStatus');

    // for principal routes
    Route::get('admin/principals', [PrincipalController::class, 'index'])->name('principal.list');
    Route::get('admin/principal-add', [PrincipalController::class, 'add'])->name('principal.add');
    Route::post('admin/principal-save', [PrincipalController::class, 'create'])->name('principal.create');
    Route::get('admin/principal-edit/{id}', [PrincipalController::class, 'edit'])->name('principal.edit');
    Route::put('admin/principal-update/{id}', [PrincipalController::class, 'update'])->name('principal.update');
    Route::delete('admin/principal/delete/{id}', [PrincipalController::class, 'delete'])->name('principal.delete');

//     for student routes
    Route::get('admin/students', [StudentController::class, 'index'])->name('student.list');
    Route::get('admin/student-add', [StudentController::class, 'add'])->name('student.add');
    Route::post('admin/student-save', [StudentController::class, 'create'])->name('student.create');
    Route::get('/students/{id}/edit', [StudentController::class, 'edit'])->name('students.edit');
    Route::put('/students/{id}', [StudentController::class, 'update'])->name('students.update');
    Route::delete('admin/student-delete/{id}', [StudentController::class, 'delete'])->name('student.delete');

    // for parent routes
    Route::get('/parent/students', [ParentController::class, 'listStudents'])->name('parent.students');
    Route::get('admin/parents', [ParentController::class, 'index'])->name('parent.list');
    Route::get('admin/parent-add', [ParentController::class, 'add'])->name('parent.add');
    Route::post('admin/parent-save', [ParentController::class, 'create'])->name('parent.create');
    Route::get('admin/parent-edit/{id}', [ParentController::class, 'edit'])->name('parent.edit');
    Route::put('admin/parent-update/{id}', [ParentController::class, 'update'])->name('parent.update');
    Route::delete('admin/parent-delete/{id}', [ParentController::class, 'delete'])->name('parent.delete');

    // Routes for Worksheets
    Route::get('/admin/worksheets', [WorksheetController::class, 'index'])->name('worksheet.index');
    Route::get('/admin/worksheets/create', [WorksheetController::class, 'add'])->name('worksheet.create');
    Route::post('/admin/worksheets', [WorksheetController::class, 'store'])->name('worksheet.store');
    Route::get('/admin/worksheets/{worksheet}', [WorksheetController::class, 'show'])->name('worksheet.show');
    Route::get('/worksheets/{id}/edit', [WorksheetController::class, 'edit'])->name('worksheet.edit');
    Route::put('/worksheets/{id}', [WorksheetController::class, 'update'])->name('worksheet.update');
    Route::delete('/worksheets/{id}', [WorksheetController::class, 'destroy'])->name('worksheet.destroy');

// Routes for Sections
    Route::get('/admin/worksheets/{worksheet}/sections/create', [SectionController::class, 'create'])->name('sections.create');
    Route::post('/admin/worksheets/{worksheet}/sections', [SectionController::class, 'store'])->name('sections.store');
    Route::get('/admin/sections', [SectionController::class, 'index'])->name('sections.index');
    Route::get('/sections/{id}/edit', [SectionController::class, 'edit'])->name('sections.edit');
    Route::put('/sections/{id}', [SectionController::class, 'update'])->name('sections.update');
    Route::delete('/sections/{id}', [SectionController::class, 'destroy'])->name('sections.destroy');

// Routes for Questions
    Route::get('/admin/sections/{section}/questions/create', [QuestionController::class, 'create'])->name('questions.create');
    Route::post('/admin/sections/{section}/questions', [QuestionController::class, 'store'])->name('questions.store');
    Route::get('/questions/{id}/edit', [QuestionController::class, 'edit'])->name('questions.edit');
    Route::post('/questions/{id}', [QuestionController::class, 'update'])->name('questions.update');
    Route::delete('/questions/{id}', [QuestionController::class, 'destroy'])->name('questions.destroy');
    Route::post('/worksheets/{worksheet}/sections/{section}/questions', [QuestionController::class, 'store'])->name('questions.store');


    // error reports
    Route::get('admin/error-reports', [AdminController::class, 'errorReports'])->name('admin.error_reports');
    Route::get('admin/error-reports/{id}/resolve', [AdminController::class, 'resolveReport'])->name('admin.resolve_report');
    Route::get('admin/error-reports/{id}/not-an-error', [AdminController::class, 'markNotAnError'])->name('admin.not_an_error');

    Route::get('admin/error-reports/{id}/resolve', [AdminController::class, 'resolveReport'])->name('admin.resolve_report');
Route::get('admin/error-reports/{id}/not-an-error', [AdminController::class, 'notAnErrorReport'])->name('admin.not_an_error');

// Show form to resolve the error report
Route::get('/admin/error-report/{id}/resolve', [AdminController::class, 'showResolveForm'])->name('admin.resolve_report');

// Handle the form submission and resolve the report
Route::post('/admin/error-report/{id}/resolve', [AdminController::class, 'submitResolution'])->name('admin.submit_resolution');


});


// for principal middleware
Route::middleware([PrincipalMiddleware::class])->group(function(){
    Route::get('/principal/dashboard', [DashboardController::class, 'index'])->name('principal.dashboard');

    // for student routes
    Route::get('principal/students', [StudentController::class, 'index'])->name('student.list');
    Route::get('principal/student-add', [StudentController::class, 'add'])->name('student.add');
    Route::post('principal/student-save', [StudentController::class, 'create'])->name('student.create');
    Route::get('principal/students/{student}/edit', [StudentController::class, 'edit'])->name('student.edit');
    Route::put('principal/students/{student}', [StudentController::class, 'update'])->name('student.update');
    Route::delete('principal/student-delete/{id}', [StudentController::class, 'delete'])->name('student.delete');

//    show the progress of students
    Route::get('/principal/student-progress', [PrincipalController::class, 'viewStudentProgress'])->name('principal.student.progress');
    Route::get('/principal/student/{studentId}/progress', [PrincipalController::class, 'showStudentProgress'])->name('principal.show-student-progress');

//    parent of students
    Route::get('/school-parents', [PrincipalController::class, 'listSchoolParents'])->name('school.parents');

//    send complain and report
    Route::get('/parent/{id}/report', [ParentController::class, 'sendReport'])->name('parent.report');
    Route::get('/parent/{id}/complain', [ParentController::class, 'sendComplain'])->name('parent.complain');


});


// for student middleware
Route::middleware([StudentMiddleware::class])->group(function() {
    Route::get('/student/dashboard', [DashboardController::class, 'index'])->name('student.dashboard');

    Route::get('/student/student-worksheets', [WorksheetController::class, 'worksheet_list'])->name('worksheet.worksheet_list');
    Route::get('/worksheet/student-worksheets/{worksheet}', [WorksheetController::class, 'student_worksheet'])->name('worksheet.student_worksheet');
    Route::post('/worksheet/pause', [WorksheetController::class, 'pauseWorksheet'])->name('worksheet.pause');
    Route::post('/error/report', [WorksheetController::class, 'reportError'])->name('error.report');
    Route::post('/worksheet/{worksheet}/submit', [WorksheetController::class, 'submit'])->name('worksheet.submit');

    Route::get('/worksheet/start', [WorksheetController::class, 'startWorksheet'])->name('worksheet.start'); // Missing route added

    Route::get('/worksheet/{worksheet}/section/{section?}', [WorksheetController::class, 'student_worksheet'])->name('worksheet.student_worksheet');
    Route::post('/worksheet/{worksheet}/section/{section}/submit', [WorksheetController::class, 'submit_section'])->name('worksheet.submit_section');
    Route::get('/worksheet/{worksheet}/confirm-submission', [WorksheetController::class, 'confirm_submission'])->name('worksheet.confirm_submission');
    Route::post('/worksheet/{worksheet}/submit', [WorksheetController::class, 'submit_worksheet'])->name('worksheet.submit_worksheet');

    // Error report routes
    Route::get('worksheet/{worksheet}/report', [WorksheetController::class, 'showErrorReportForm'])->name('worksheet.report');
    Route::post('worksheet/{worksheet}/report', [WorksheetController::class, 'submitErrorReport'])->name('worksheet.submit_report');
    Route::get('worksheet/{worksheet}/error-report-confirmation', [WorksheetController::class, 'showErrorReportConfirmation'])->name('worksheet.error_report_confirmation');

    Route::get('student/progress', [WorksheetController::class, 'showProgress'])->name('student.progress');

    // Notifications
    Route::get('/student/notifications', [WorksheetController::class, 'getStudentNotifications'])->name('student.notifications');

    // Correction worksheet routes
    Route::get('/worksheet/{worksheet}/correction', [WorksheetController::class, 'showCorrection'])->name('worksheet.correction');
    Route::post('/worksheet/{worksheet}/correction', [WorksheetController::class, 'submitCorrection'])->name('worksheet.submit_correction');

    // for practice-worksheet worksheet
    Route::get('/worksheet/start', [PracticeWorksheetController::class, 'worksheet'])->name('practice-worksheet.start');
    Route::get('/practice-worksheet', [PracticeWorksheetController::class, 'worksheet'])->name('practice-worksheet.worksheet');
    Route::post('/practice-worksheet-submit', [PracticeWorksheetController::class, 'submit'])->name('practice.worksheet.submit');

});



// for student middleware
Route::middleware([ParentMiddleware::class])->group(function(){
    Route::get('/parent/dashboard', [DashboardController::class, 'index'])->name('parent.dashboard');

    Route::get('/parent/child/{childId}/progress', [ParentController::class, 'showChildProgress'])->name('parent.child.progress');


});
