<?php

use Illuminate\Support\Facades\Route;

// Controllers SuperAdmin
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SuperAdmin\SuperAdminController;
use App\Http\Controllers\SuperAdmin\SuperPlanController;
use App\Http\Controllers\SuperAdmin\SuperSettingController;
// use App\Http\Controllers\Teacher\TeacherController;
// use App\Http\Controllers\Student\StudentController;
// use App\Http\Controllers\Parent\ParentController;
// use App\Http\Controllers\Accountant\AccountantController;
// use App\Http\Controllers\Driver\DriverController;
use App\Http\Controllers\Hostel\HostelController;
use App\Http\Controllers\Auth\CustomAuthController;

//School Admin
use App\Http\Controllers\SchoolAdmin\SchoolAdminController;
use App\Http\Controllers\SchoolAdmin\SchoolStudentController;
use App\Http\Controllers\SchoolAdmin\SchoolTeacherController;
use App\Http\Controllers\SchoolAdmin\SchoolNoticeController;
use App\Http\Controllers\SchoolAdmin\SchoolGalleryController;
use App\Http\Controllers\SchoolAdmin\SchoolAdmissionController;
use App\Http\Controllers\SchoolSite\SiteAdmissionController;
use App\Http\Controllers\SchoolAdmin\SchoolClassController;
use App\Http\Controllers\SchoolAdmin\SectionController;
use App\Http\Controllers\SchoolAdmin\SchoolAttendanceController;
use App\Http\Controllers\SchoolAdmin\SchoolResultController;
use App\Http\Controllers\SchoolAdmin\SchoolSubjectController;
use App\Http\Controllers\SchoolAdmin\RoleController;
use App\Http\Controllers\SchoolAdmin\SchoolAccountantController;
use App\Http\Controllers\SchoolAdmin\SchoolHostelSuperController;
use App\Http\Controllers\SchoolAdmin\SchoolTransportController;
use App\Http\Controllers\SchoolAdmin\SchoolDriverAssignController;
use App\Http\Controllers\SchoolAdmin\SchoolVehicleController;
use App\Http\Controllers\SchoolAdmin\SchoolRouteController;
use App\Http\Controllers\SchoolAdmin\SchoolStaffLeaveController;
use App\Http\Controllers\SchoolAdmin\SchoolStaffAttendanceController;
use App\Http\Controllers\SchoolAdmin\SchoolUserController;
use App\Http\Controllers\SchoolAdmin\SchoolFeeController;
use App\Http\Controllers\SchoolAdmin\SchoolFeesReportController;
use App\Http\Controllers\SchoolAdmin\SchoolAdminProfileController;
use App\Http\Controllers\SchoolSite\SitePlanController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Teacher\TeacherResultController;
use App\Http\Controllers\Teacher\TeacherHomeworkController;

//Teacher Admin
use App\Http\Controllers\Teacher\TeacherDashboardController;
use App\Http\Controllers\Teacher\TeacherSubjectController;
use App\Http\Controllers\Teacher\TeacherStudentController;
use App\Http\Controllers\Teacher\TeacherStudentAttendanceController;
use App\Http\Controllers\Teacher\TeacherAttendanceController;
use App\Http\Controllers\Teacher\TeacherLeaveController;

//Student Admin
use App\Http\Controllers\Student\StudentDashboardController;
use App\Http\Controllers\Student\StudentSubjectController;
use App\Http\Controllers\Student\StudentAttendanceController;
use App\Http\Controllers\Student\StudentResultController;
use App\Http\Controllers\Student\StudentHomeworkController;

//Parent Admin
use App\Http\Controllers\Parent\ParentDashboardController;
use App\Http\Controllers\Parent\ParentController;

//Accountant Admin
use App\Http\Controllers\Accountant\AccountantDashboardController;
use App\Http\Controllers\Accountant\AccountantExpenseController;
use App\Http\Controllers\Accountant\AccountantFeeController;
use App\Http\Controllers\Accountant\AccountantReportController;

//Driver Admin
use App\Http\Controllers\Driver\DriverController;

/*
|--------------------------------------------------------------------------
| 🌐 Public
|--------------------------------------------------------------------------
*/
// Route::get('/', fn () => view('welcome'));
// PUBLIC PRICING
Route::get('/pricing', [SitePlanController::class,'pricing'])->name('pricing');

// BUY PLAN (school admin only)
Route::middleware(['auth'])->group(function () {
    Route::post('/buy-plan/{id}', [SubscriptionController::class,'buy'])
        ->name('subscription.buy');
});
Route::post('/pay/{plan}', [PaymentController::class,'pay'])
    ->name('payment.pay');

Route::post('/payment-success', [PaymentController::class,'success'])
    ->name('payment.success');
/*
|--------------------------------------------------------------------------
| 🔐 AUTH (Tenant Based)
|--------------------------------------------------------------------------
*/

/*
|--------------------------------------------------------------------------
| SUBDOMAIN (SCHOOL SaaS) 🔥 FIRST
|--------------------------------------------------------------------------
*/

Route::domain('{school}.localhost')
    ->middleware(['tenant'])
    ->name('school.') // 🔥 IMPORTANT (prefix for all routes)
    ->group(function () {

    // 🏠 HOME
    Route::get('/', fn() => view('school_site.home'))->name('home');

    // 🔐 AUTH
    Route::get('/login', [CustomAuthController::class,'login'])->name('login');
    Route::post('/login', [CustomAuthController::class,'loginStore'])->name('login.store');

    Route::post('/logout', [CustomAuthController::class,'logout'])->name('logout');

    // 🎓 ADMISSION
    Route::prefix('admission')->name('admission.')->group(function () {
        Route::get('/', [SiteAdmissionController::class, 'form'])->name('form');
        Route::post('/', [SiteAdmissionController::class, 'submit'])->name('store');
    });

    // 🌐 STATIC PAGES
    Route::view('/about', 'school_site.about')->name('about');
    Route::view('/features', 'school_site.features')->name('features');
    Route::view('/gallery', 'school_site.gallery')->name('gallery');
    Route::view('/contact', 'school_site.contact')->name('contact');

});


/*
|--------------------------------------------------------------------------
| MAIN DOMAIN (SUPER ADMIN) 🔥 AFTER
|--------------------------------------------------------------------------
*/

// MAIN DOMAIN
Route::get('/', function () {
    return view('welcome');
})->name('main.home');

// SUPER ADMIN LOGIN
Route::get('/login', [CustomAuthController::class,'login'])->name('admin.login');

// ✅ ADD THIS (IMPORTANT)
Route::get('/login', [CustomAuthController::class,'login'])->name('login');

Route::post('/login', [CustomAuthController::class,'loginStore']);

// LOGOUT
Route::post('/logout', [CustomAuthController::class,'logout'])
    ->name('admin.logout');
/*
|--------------------------------------------------------------------------
| 🧑 Profile
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});

/*
|--------------------------------------------------------------------------
| 🔥 Super Admin
|--------------------------------------------------------------------------
*/
Route::middleware(['auth','active','role:super_admin'])
    ->prefix('super-admin')
    ->name('super_admin.')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [SuperAdminController::class, 'index'])->name('dashboard');
        
        // Schools
        Route::get('/schools', [SuperAdminController::class, 'schools'])->name('schools');
        Route::get('/schools/create', [SuperAdminController::class, 'createSchool'])->name('schools.create');
        Route::post('/schools', [SuperAdminController::class, 'storeSchool'])->name('schools.store');
        Route::get('/schools/{id}/edit', [SuperAdminController::class, 'editSchool'])->name('schools.edit');
        Route::put('/schools/{id}', [SuperAdminController::class, 'updateSchool'])->name('schools.update');
        Route::delete('/schools/{id}', [SuperAdminController::class, 'deleteSchool'])->name('schools.delete');
        Route::get('/schools/{id}/view', [SuperAdminController::class, 'viewSchool'])->name('schools.view');

        // Activate / Suspend
        Route::post('/schools/{id}/toggle', [SuperAdminController::class, 'toggleSchool'])->name('schools.toggle');

        // Subscription
        Route::get('/schools/{id}/subscribe', [SuperAdminController::class, 'showSubscribe'])->name('schools.subscribe');
        Route::post('/schools/{id}/subscribe', [SuperAdminController::class, 'assignSubscription'])->name('schools.subscribe.store');

        // Plans
        Route::get('/plans', [SuperPlanController::class, 'index'])->name('plans');
        Route::get('/plans/create', [SuperPlanController::class, 'create'])->name('plans.create');
        Route::post('/plans/store', [SuperPlanController::class, 'store'])->name('plans.store');
        Route::get('/plans/edit/{id}', [SuperPlanController::class, 'edit'])->name('plans.edit');
        Route::put('/plans/update/{id}', [SuperPlanController::class, 'update'])->name('plans.update');
        Route::delete('/plans/delete/{id}', [SuperPlanController::class, 'destroy'])->name('plans.delete');

        // Users
        Route::get('/users', [\App\Http\Controllers\SuperAdmin\SuperUserController::class, 'index'])->name('users');

        // Security
        Route::post('/users/{id}/toggle', [\App\Http\Controllers\SuperAdmin\SuperUserController::class,'toggleStatus'])->name('users.toggle');
        Route::post('/users/{id}/reset-password', [\App\Http\Controllers\SuperAdmin\SuperUserController::class,'resetPassword'])->name('users.reset');
        Route::get('/users/{id}/logs', [\App\Http\Controllers\SuperAdmin\SuperUserController::class,'logs'])->name('users.logs');

        // Settings
        Route::get('/settings', [SuperSettingController::class, 'index'])->name('settings');
        Route::post('/settings', [SuperSettingController::class, 'update'])->name('settings.update');
        
        //Profile
        Route::get('/profile', [\App\Http\Controllers\SuperAdmin\SuperProfileController::class,'index'])->name('profile');
        Route::post('/profile', [\App\Http\Controllers\SuperAdmin\SuperProfileController::class,'update'])->name('profile.update');
});
    

/*
|--------------------------------------------------------------------------
| 🏫 School Admin
|--------------------------------------------------------------------------
*/
Route::middleware(['auth','role:school_admin','subscription'])
    ->prefix('school-admin')
    ->name('school_admin.')
    ->group(function () {

    // ================= DASHBOARD =================
    Route::get('/dashboard', [SchoolAdminController::class,'index'])->name('dashboard');
   
    
    // ================= ACCOUNTANT =================

    Route::resource('accountants', \App\Http\Controllers\SchoolAdmin\SchoolAccountantController::class);
    Route::get('accountants-export', [SchoolAccountantController::class,'export'])
        ->name('accountants.export');
    Route::resource('accountants', SchoolAccountantController::class);
    Route::post('accountants/toggle/{id}', 
    [SchoolAccountantController::class,'toggleStatus']
    )->name('accountants.toggle');


   // ================= HOSTEL =================
    
Route::prefix('hostel-super')->name('hostel_super.')->group(function(){

    Route::get('/', [SchoolHostelSuperController::class,'index'])->name('index');

    Route::get('/create', [SchoolHostelSuperController::class,'create'])->name('create');
    Route::post('/store', [SchoolHostelSuperController::class,'store'])->name('store');

    Route::get('/view/{id}', [SchoolHostelSuperController::class,'view'])->name('view');

    Route::get('/edit/{id}', [SchoolHostelSuperController::class,'edit'])->name('edit');
    Route::put('/update/{id}', [SchoolHostelSuperController::class,'update'])->name('update');

    Route::delete('/delete/{id}', [SchoolHostelSuperController::class,'destroy'])->name('delete');

    Route::post('/toggle/{id}', [SchoolHostelSuperController::class,'toggle'])->name('toggle');

    Route::get('/export', [SchoolHostelSuperController::class,'export'])->name('export');

});

    // ================= TRANSPORT =================
    
    Route::prefix('transport')->name('transport.')->group(function(){

    Route::get('/', [SchoolTransportController::class,'index'])->name('index');

    Route::get('/create', [SchoolTransportController::class,'create'])->name('create');
    Route::post('/store', [SchoolTransportController::class,'store'])->name('store');

    Route::get('/view/{id}', [SchoolTransportController::class,'view'])->name('view');

    Route::get('/edit/{id}', [SchoolTransportController::class,'edit'])->name('edit');
    Route::put('/update/{id}', [SchoolTransportController::class,'update'])->name('update');

    Route::delete('/delete/{id}', [SchoolTransportController::class,'destroy'])->name('delete');

    Route::post('/toggle/{id}', [SchoolTransportController::class,'toggle'])->name('toggle');

    // 🔥 EXPORT
    Route::get('/export', [SchoolTransportController::class,'export'])->name('export');

});
   Route::prefix('transport')->name('transport.')->group(function(){

    // ================= VEHICLE =================
    Route::prefix('vehicle')->name('vehicle.')->group(function () {
        Route::get('/', [SchoolVehicleController::class,'index'])->name('index');
        Route::get('/create', [SchoolVehicleController::class,'create'])->name('create');
        Route::post('/store', [SchoolVehicleController::class,'store'])->name('store');
        Route::get('/edit/{id}', [SchoolVehicleController::class,'edit'])->name('edit');
        Route::put('/update/{id}', [SchoolVehicleController::class,'update'])->name('update');
        Route::delete('/delete/{id}', [SchoolVehicleController::class,'destroy'])->name('delete');
        Route::get('/export', [SchoolVehicleController::class,'export'])->name('export');
    });

    // ================= ROUTE =================
    Route::prefix('route')->name('route.')->group(function () {
        Route::get('/', [SchoolRouteController::class,'index'])->name('index');
        Route::get('/create', [SchoolRouteController::class,'create'])->name('create');
        Route::post('/store', [SchoolRouteController::class,'store'])->name('store');
        Route::get('/edit/{id}', [SchoolRouteController::class,'edit'])->name('edit');
        Route::put('/update/{id}', [SchoolRouteController::class,'update'])->name('update');
        Route::delete('/delete/{id}', [SchoolRouteController::class,'destroy'])->name('delete');
        Route::get('/export', [SchoolRouteController::class,'export'])->name('export');
    });

    // ================= ASSIGN =================
    Route::prefix('assign')->name('assign.')->group(function(){
        Route::get('/', [SchoolDriverAssignController::class,'index'])->name('index');
        Route::get('/create', [SchoolDriverAssignController::class,'create'])->name('create');
        Route::post('/store', [SchoolDriverAssignController::class,'store'])->name('store');
        Route::get('/edit/{id}', [SchoolDriverAssignController::class,'edit'])->name('edit');
        Route::put('/update/{id}', [SchoolDriverAssignController::class,'update'])->name('update');
        Route::delete('/delete/{id}', [SchoolDriverAssignController::class,'destroy'])->name('delete');
    });

});
     // ================= STAFF LEAVE =================
     Route::prefix('staff-leave')->name('staff_leave.')->group(function(){

    Route::get('/', [SchoolStaffLeaveController::class,'index'])->name('index');

    Route::get('/approve/{id}', [SchoolStaffLeaveController::class,'approve'])->name('approve');
    Route::get('/reject/{id}', [SchoolStaffLeaveController::class,'reject'])->name('reject');

    Route::delete('/delete/{id}', [SchoolStaffLeaveController::class,'destroy'])->name('delete');

});
    // ================= STAFF ATTENDANCE =================
    Route::prefix('staff-attendance')->name('staff_attendance.')->group(function(){

    Route::get('/', [SchoolStaffAttendanceController::class,'index'])->name('index');

    Route::get('/view/{id}', [SchoolStaffAttendanceController::class,'show'])->name('show');

    Route::delete('/delete/{id}', [SchoolStaffAttendanceController::class,'destroy'])->name('delete');

    Route::get('/export', [SchoolStaffAttendanceController::class,'export'])->name('export');

});
   // ================= FEES =================
    Route::prefix('fees')->name('fees.')->group(function () {

    Route::get('/', [SchoolFeeController::class,'index'])->name('index');

    Route::get('/invoice/{id}', [SchoolFeeController::class,'invoice'])->name('invoice');

    // ✅ REPORT
    Route::get('/report', [SchoolFeesReportController::class,'report'])->name('report');
    Route::get('/report/export', [SchoolFeesReportController::class,'exportPdf'])->name('report.export');

});
    // ================= ATTENDANCE =================
    Route::get('/attendance', [SchoolAttendanceController::class,'view'])
        ->middleware('feature:attendance')
        ->name('attendance.view');

    Route::get('/attendance/export', [SchoolAttendanceController::class,'export'])
        ->middleware('feature:attendance')
        ->name('attendance.export');

    Route::get('/attendance/chart', [SchoolAttendanceController::class,'chart'])
        ->middleware('feature:attendance')
        ->name('attendance.chart');

    // ================= RESULTS =================
    Route::get('/results', [SchoolResultController::class,'index'])
        ->middleware('feature:results')
        ->name('results.index');

    Route::get('/results/{id}', [SchoolResultController::class,'show'])
        ->middleware('feature:results')
        ->name('results.show');

    Route::get('/get-sections/{id}', [SectionController::class,'getByClass'])
        ->name('get.sections');

    // ================= SUBJECT =================
    Route::resource('subjects', SchoolSubjectController::class)
         ->middleware('feature:subjects');

    Route::get('subjects/{id}/assign', [SchoolSubjectController::class,'assign'])
         ->middleware('feature:subjects')
        ->name('subjects.assign');

    Route::post('subjects/{id}/assign', [SchoolSubjectController::class,'assignStore'])
         ->middleware('feature:subjects')
        ->name('subjects.assign.store');

    // ================= STUDENTS EXTRA =================
    Route::get('/students/template', [SchoolStudentController::class, 'template'])->name('students.template');
    Route::get('/students/export', [SchoolStudentController::class,'export'])->name('students.export');
    Route::post('/students/import', [SchoolStudentController::class,'import'])->name('students.import');

    // ================= CLASS & SECTION =================
    Route::resource('classes', SchoolClassController::class);
    Route::resource('sections', SectionController::class);

    Route::get('/get-sections/{id}', [SectionController::class, 'getByClass'])
        ->name('get.sections');

    Route::get('/something', [RoleController::class, 'index']);

    // ================= STUDENTS =================
    Route::prefix('students')->name('students.')->group(function () {

        Route::get('/', [SchoolStudentController::class,'index'])->name('index');
        Route::get('/create', [SchoolStudentController::class,'create'])->name('create');
        Route::post('/store', [SchoolStudentController::class,'store'])->name('store');

        Route::get('/view/{id}', [SchoolStudentController::class,'show'])->name('view');
        Route::get('/edit/{id}', [SchoolStudentController::class,'edit'])->name('edit');
        Route::put('/update/{id}', [SchoolStudentController::class,'update'])->name('update');
        Route::delete('/delete/{id}', [SchoolStudentController::class,'destroy'])->name('delete');

        Route::post('/toggle/{id}', [SchoolStudentController::class,'toggleStatus'])->name('toggle');
    });

    // ================= TEACHERS =================
    Route::prefix('teachers')->name('teachers.')->group(function () {
    
    // ================= BASIC =================
    Route::get('/', [SchoolTeacherController::class,'index'])->name('index');
    Route::get('/create', [SchoolTeacherController::class,'create'])->name('create');
    Route::post('/store', [SchoolTeacherController::class,'store'])->name('store');

    Route::get('/edit/{id}', [SchoolTeacherController::class,'edit'])->name('edit');
    Route::put('/update/{id}', [SchoolTeacherController::class,'update'])->name('update');
    Route::delete('/delete/{id}', [SchoolTeacherController::class,'destroy'])->name('delete');

    Route::post('/toggle/{id}', [SchoolTeacherController::class,'toggleStatus'])->name('toggle');
    Route::get('/view/{id}', [SchoolTeacherController::class,'show'])->name('view');

    // ================= EXTRA =================
    Route::get('/export', [SchoolTeacherController::class,'export'])->name('export');

    Route::get('/template', [SchoolTeacherController::class,'template'])
        ->name('template');

    Route::post('/import', [SchoolTeacherController::class,'import'])->name('import');

});

    // ================= ROLES =================
    Route::resource('roles', RoleController::class);

    // ================= NOTICES =================
    Route::prefix('notices')->name('notices.')->group(function () {

        Route::get('/', [SchoolNoticeController::class, 'index'])->name('index');
        Route::get('/create', [SchoolNoticeController::class, 'create'])->name('create');
        Route::post('/store', [SchoolNoticeController::class, 'store'])->name('store');
        Route::delete('/delete/{id}', [SchoolNoticeController::class, 'delete'])->name('delete');
    });

    // ================= GALLERY =================
    Route::prefix('gallery')->name('gallery.')->group(function () {

        Route::get('/', [SchoolGalleryController::class, 'index'])->name('index');
        Route::get('/create', [SchoolGalleryController::class, 'create'])->name('create');
        Route::post('/store', [SchoolGalleryController::class, 'store'])->name('store');
        Route::delete('/delete/{id}', [SchoolGalleryController::class, 'delete'])->name('delete');
    });

    // ================= ADMISSIONS =================
    Route::prefix('admissions')->name('admissions.')->group(function () {

        Route::get('/', [SchoolAdmissionController::class, 'index'])->name('index');
        Route::get('/approve/{id}', [SchoolAdmissionController::class, 'approve'])->name('approve');
        Route::get('/reject/{id}', [SchoolAdmissionController::class, 'reject'])->name('reject');
    });

});
Route::prefix('school-admin')->name('school_admin.')->middleware(['auth','role:school_admin'])->group(function () {
    Route::get('/profile', [SchoolAdminProfileController::class,'index'])->name('profile');
    Route::post('/profile', [SchoolAdminProfileController::class,'update'])->name('profile.update');

    Route::get('/users', [SchoolUserController::class,'index'])->name('users.index');
    Route::post('/users/reset/{id}', [SchoolUserController::class,'resetPassword'])->name('users.reset');
    Route::post('/users/toggle/{id}', [SchoolUserController::class,'toggle'])->name('users.toggle');

});

/*
|--------------------------------------------------------------------------
| 🏫 Teacher Admin
|--------------------------------------------------------------------------
*/
Route::middleware(['auth','role:teacher'])
    ->prefix('teacher')
    ->name('teacher.')
    ->group(function () {

    // 📊 Dashboard
    Route::get('/dashboard', [TeacherDashboardController::class,'index'])
        ->name('dashboard');

    // 📚 Subjects
    Route::get('/subjects', [TeacherSubjectController::class,'index'])
        ->name('subjects');

    // 👁 Subject Details
    Route::get('/subjects/{id}', [TeacherSubjectController::class,'show'])
        ->name('subjects.show');

    // 🧑‍🎓 Students (temporary)
    Route::get('/students', [TeacherStudentController::class,'index'])->name('students');
    Route::get('/students/{id}', [TeacherStudentController::class,'show'])->name('students.show');

    // 📅 Attendance (temporary)
    Route::get('/attendance', [TeacherAttendanceController::class,'index'])
        ->name('attendance'); // ✅ IMPORTANT
    Route::post('/attendance/mark', [TeacherAttendanceController::class,'mark'])
       ->name('attendance.mark');
    Route::post('/attendance/checkout', [TeacherAttendanceController::class, 'checkout'])
    ->name('attendance.checkout');   
    Route::get('/student-attendance', [TeacherStudentAttendanceController::class,'index'])
        ->name('student.attendance');

    Route::post('/student-attendance/store', [TeacherStudentAttendanceController::class,'store'])
        ->name('student.attendance.store');

    // 📝 Leave (temporary)
    Route::get('/leave', fn() => 'Leave')->name('leave');
    // 📄 Leave Page
    Route::get('/leave', [TeacherLeaveController::class,'index'])
        ->name('leave');

    // 💾 Apply Leave
    Route::post('/leave/store', [TeacherLeaveController::class,'store'])
        ->name('leave.store');
    
    // 📊 Result
    Route::get('/results', [TeacherResultController::class,'index'])->name('results');
    Route::get('/results/create/{id}', [TeacherResultController::class,'create'])->name('results.create');
    Route::post('/results/store', [TeacherResultController::class,'store'])->name('results.store');

    // 📝 Homework
//     Route::get('/homework', [TeacherHomeworkController::class,'index'])->name('homework');
//     Route::get('/homework/create', [TeacherHomeworkController::class,'create'])->name('homework.create');
//     Route::get('/teacher/get-sections/{class_id}', [TeacherHomeworkController::class, 'getSections']);
// Route::get('/teacher/get-subjects/{class_id}', [TeacherHomeworkController::class, 'getSubjects']);
    
//     Route::post('/homework/store', [TeacherHomeworkController::class,'store'])->name('homework.store');     
});
Route::prefix('teacher')->name('teacher.')->group(function () {

    Route::get('/homework', [TeacherHomeworkController::class,'index'])->name('homework');
    Route::get('/homework/create', [TeacherHomeworkController::class,'create'])->name('homework.create');
    Route::post('/homework/store', [TeacherHomeworkController::class,'store'])->name('homework.store');

    // ✅ AJAX
    Route::get('/get-sections/{class_id}', [TeacherHomeworkController::class, 'getSections']);
    Route::get('/get-subjects/{class_id}', [TeacherHomeworkController::class, 'getSubjects']);
});

/*
|--------------------------------------------------------------------------
| 🏫 Student Admin
|--------------------------------------------------------------------------
*/
Route::middleware(['auth','role:student'])
    ->prefix('student')
    ->name('student.')
    ->group(function () {

    // ================= DASHBOARD =================
    Route::get('/dashboard', [StudentDashboardController::class,'index'])
        ->name('dashboard');

    // ================= SUBJECTS =================
    Route::get('/subjects', [StudentSubjectController::class,'index'])
        ->name('subjects');

    // ================= ATTENDANCE =================
    Route::get('/attendance', [StudentAttendanceController::class,'index'])
        ->name('attendance');

    // ================= RESULTS =================
    Route::get('/results', [StudentResultController::class,'index'])
        ->name('results');
    // ================= HOMEWORK =================
    Route::get('/homework', [StudentHomeworkController::class,'index'])->name('homework');
});

/*
|--------------------------------------------------------------------------
| 🏫 Parent Admin
|--------------------------------------------------------------------------
*/
Route::middleware(['auth','role:parent'])
    ->prefix('parent')
    ->name('parent.')
    ->group(function () {

    // ================= DASHBOARD =================
    Route::get('/dashboard', [ParentDashboardController::class,'index'])
        ->name('dashboard');

    // ================= CHILDREN =================
    Route::get('/children', [ParentController::class,'children'])
        ->name('children');

    // ================= ATTENDANCE =================
    Route::get('/attendance/{student_id}', [ParentController::class,'attendance'])
        ->name('attendance');

    // ================= RESULTS =================
    Route::get('/results/{student_id}', [ParentController::class,'results'])
        ->name('results');

    // ================= HOMEWORK (OPTIONAL BUT IMPORTANT) =================
    Route::get('/homework/{student_id}', [ParentController::class,'homework'])
        ->name('homework');

});

/*
|--------------------------------------------------------------------------
| 🏫 Accountant Admin
|--------------------------------------------------------------------------
*/
Route::middleware(['auth','role:accountant'])
    ->prefix('accountant')
    ->name('accountant.')
    ->group(function () {

    // Dashboard
    Route::get('/dashboard',[AccountantDashboardController::class,'index'])
        ->name('dashboard');

    // 🔥 FEES (FULL CRUD)
    Route::resource('fees', AccountantFeeController::class);

    // 🔥 EXPENSES (FULL CRUD)
    Route::resource('expenses', AccountantExpenseController::class);
    Route::put('/expenses/{id}', [AccountantExpenseController::class, 'update'])
    ->name('expenses.update');

    // Reports
    Route::get('/reports',[AccountantReportController::class,'index'])
        ->name('reports');

    Route::get('/reports/chart',[AccountantReportController::class,'chart'])
        ->name('reports.chart');

});

/*
|--------------------------------------------------------------------------
| 🏫 Driver Admin
|--------------------------------------------------------------------------
*/
Route::middleware(['auth','role:driver'])
    ->prefix('driver')
    ->name('driver.')
    ->group(function () {

    Route::get('/dashboard', [DriverController::class,'dashboard'])->name('dashboard');
    Route::get('/route', [DriverController::class,'route'])->name('route');
    Route::get('/students', [DriverController::class,'students'])->name('students');
    Route::post('/pickup/{id}', [DriverController::class,'pickup'])->name('pickup');
    Route::post('/reset-pickup', [DriverController::class,'resetPickup'])->name('resetPickup');
});

/*
|--------------------------------------------------------------------------
| 👨‍🏫 Other Roles
|--------------------------------------------------------------------------
*/

// Teacher
Route::middleware(['auth','role:teacher'])
    ->prefix('teacher')
    ->name('teacher.')
    ->group(fn () =>
        Route::get('/dashboard', [TeacherDashboardController::class, 'index'])->name('dashboard')
    );

// Student
Route::middleware(['auth','role:student'])
    ->prefix('student')
    ->name('student.')
    ->group(fn () =>
        Route::get('/dashboard', [StudentDashboardController::class, 'index'])->name('dashboard')
    );

// Parent
Route::middleware(['auth','role:parent'])
    ->prefix('parent')
    ->name('parent.')
    ->group(fn () =>
        Route::get('/dashboard', [ParentDashboardController::class, 'index'])->name('dashboard')
    );

// Accountant
Route::middleware(['auth','role:accountant'])
    ->prefix('accountant')
    ->name('accountant.')
    ->group(fn () =>
        Route::get('/dashboard', [AccountantDashboardController::class, 'index'])->name('dashboard')
    );

// Driver
// Route::middleware(['auth','role:driver'])
//     ->prefix('driver')
//     ->name('driver.')
//     ->group(fn () =>
//         // Route::get('/dashboard', [DriverController::class, 'index'])->name('dashboard')
//     );

// Hostel
Route::middleware(['auth','role:hostel_super'])
    ->prefix('hostel')
    ->name('hostel.')
    ->group(fn () =>
        Route::get('/dashboard', [HostelController::class, 'index'])->name('dashboard')
    );

/*
|--------------------------------------------------------------------------
| ❌ Subscription Expired
|--------------------------------------------------------------------------
*/
Route::get('/subscription-expired', function () {
    return view('subscription.expired');
})->name('subscription.expired');
