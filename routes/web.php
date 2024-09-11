<?php

use App\Http\Controllers\Admin\AdminCategoriesController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminCoursesController;
use App\Http\Controllers\Admin\AdminEnrollmentController;
use App\Http\Controllers\Admin\AdminUsersController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GeneralController;
use App\Http\Controllers\Instructor\AnalysisController;
use App\Http\Controllers\Instructor\CourseManageController;
use App\Http\Controllers\Home\IndexController;
use App\Http\Controllers\Instructor\InstructorController;
use App\Http\Controllers\Student\CourseController;
use App\Http\Controllers\Student\StudentController;
use Illuminate\Support\Facades\Route;

/******************************** AUTH ROUTES *******************************/

Route::get('chat', function () {
    return view('chat2');
});

Route::get('/', [IndexController::class, 'index'])->name('home');
Route::post('rate', [IndexController::class, 'rate'])->name('rate');
Route::get('instructors', [IndexController::class, 'for_instructors'])->name('instructors');
Route::get('student/profile/{username}', [StudentController::class, 'profile'])->name('std.profile');
Route::get('instructor/profile/{username}', [InstructorController::class, 'profile'])->name('ins.profile');

Route::get('courses', [IndexController::class, 'courses'])->name('courses.index');

Route::get('course', function (){
    return redirect()->route('courses.index');
});
Route::get('admin', function (){
    return redirect()->route('dashboard');
});

Route::get('course/details/{slug}/{id}', [IndexController::class, 'course_index'])->name('course.index');
Route::get('course/rating/{slug}/{id}', [IndexController::class, 'course_rating'])->name('course.index.rating');
Route::post('course/rating/{slug}/{id}/rate', [IndexController::class, 'course_rating_store'])->name('course.index.rating.store');

Route::get('login', [AuthController::class, 'showLogin'])->name('login');
Route::get('admin-login', [AuthController::class, 'admin_login'])->name('admin.login');

Route::middleware('guest')->group(function () {
    Route::post('admin/make-login', [AuthController::class, 'admin_make_login']);
    Route::post('login', [AuthController::class, 'login']);
    Route::get('register', [AuthController::class, 'showRegistration'])->name('register');
    Route::post('register', [AuthController::class, 'register']);

    Route::post('admin-login', [AuthController::class, 'admin_make_login']);
    Route::post('admin-register', [AuthController::class, 'admin_register'])->name('admin.register');
});


/******************************** ADDITIONAL INFO ROUTES *******************************/

Route::get('profile-type', [AuthController::class, 'profile_type'])
    ->name('profile-type')
    ->middleware('check.registration.stage:role');

Route::post('general-info', [AuthController::class, 'store_basic_info'])
    ->name('store-basic-info')
    ->middleware('check.registration.stage:role');

Route::get('/additional-info', function () {
    return redirect()->route('profile-type');
});

Route::post('store-additional-info', [AuthController::class, 'store_additional_info'])
    ->name('store.additional.info')
    ->middleware('check.registration.stage:additional_info');

Route::get('/additional-info', function () {
    return redirect()->route('profile-type');
});

Route::get('skip-additional-info', [AuthController::class, 'skip_additional_info'])
    ->name('skip-additional-info')
    ->middleware('check.registration.stage:additional_info');

/******************************** -------------- *******************************/
/******************************** GENERAL ROUTES *******************************/
/******************************** -------------- *******************************/

Route::middleware(['auth'])->group(function () {
    Route::get('dashboard', [GeneralController::class, 'dash'])->name('dashboard');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('inbox', [GeneralController::class, 'inbox'])->name('inbox.index');
    Route::post('inbox', [GeneralController::class, 'update_status'])->name('inbox.update');
});

/******************************** -------------- *******************************/
/******************************** STUDENT ROUTES *******************************/
/******************************** -------------- *******************************/

Route::middleware(['auth', 'std'])->group(function () {
    Route::post('student/profile-update/{id}', [StudentController::class, 'profile_update'])->name('std.profile.update');
    Route::get('learning', [CourseController::class, 'learning'])->name('learning');

    /******************************** COURSE ROUTES *******************************/
    Route::post('course/enroll', [CourseController::class, 'course_enroll'])->name('course.enroll');
    Route::get('course/learn/{slug}/{id}/{lecture}', [CourseController::class, 'redirect_to_progress'])->name('course.redirect.progress');
    Route::post('course/done/{slug}/{id}/{lecture}', [CourseController::class, 'lecture_done'])->name('course.lecture.done');

    Route::post('course/{slug}/{id}/next/{lecture}', [CourseController::class, 'progress_next'])->name('course.progress.next');
    Route::post('course/{slug}/{id}/prev/{lecture}', [CourseController::class, 'progress_prev'])->name('course.progress.prev');

    Route::get('course/get-certificate/{id}', [CourseController::class, 'course_done'])->name('course.done');

    Route::post('course/bookmark', [StudentController::class, 'course_bookmark'])->name('course.bookmark');
});


/******************************** ----------------- *******************************/
/******************************** INSTRUCTOR ROUTES *******************************/
/******************************** ----------------- *******************************/

Route::middleware(['auth', 'ins'])->group(function () {

    Route::post('instructor/profile-update/{id}', [InstructorController::class, 'profile_update'])->name('ins.profile.update');

    /******************************** COURSES ROUTES *******************************/
    Route::get('instructor', function () { return redirect()->route('dashboard'); });
    Route::get('instructor/courses', [CourseManageController::class, 'index'])->name('ins.courses');
    Route::get('instructor/analysis', [AnalysisController::class, 'index'])->name('ins.analysis');

    Route::post('instructor/courses/create/basic', [CourseManageController::class, 'create_basic'])->name('courses.create.basic');
    Route::post('instructor/courses/create/complete', [CourseManageController::class, 'create_complete'])->name('courses.create.complete');
    Route::post('instructor/courses/create/back', [CourseManageController::class, 'create_back'])->name('courses.create.back');
    Route::post('instructor/courses/create', [CourseManageController::class, 'create'])->name('courses.create');
    Route::get('instructor/courses/edit/{id}', [CourseManageController::class, 'edit_draft'])->name('courses.edit.version');
    Route::get('instructor/courses/edit-version/{id}', [CourseManageController::class, 'edit_draft_new'])->name('courses.edit.version.new');
    Route::get('instructor/courses/reedit/{id}', [CourseManageController::class, 'reedit_draft'])->name('courses.reedit.version');

    Route::post('instructor/courses/save', [CourseManageController::class, 'save_draft'])->name('courses.save.draft');
    Route::post('instructor/courses/check', [CourseManageController::class, 'check_draft'])->name('courses.check.draft');
    Route::post('instructor/courses/checkdraft', [CourseManageController::class, 'check_draft_2'])->name('courses.check2.draft');
    Route::get('instructor/courses/track-review/{id}', [CourseManageController::class, 'track_review'])->name('courses.track.review');
    Route::get('instructor/courses/cancelreview/{id}', [CourseManageController::class, 'cancel_review'])->name('courses.cancel.review');
    Route::get('instructor/courses/delete-draft/{id}', [CourseManageController::class, 'check_delete'])->name('courses.delete.draft');
    Route::post('instructor/courses/confirm', [CourseManageController::class, 'confirm_draft'])->name('courses.confirm.draft');
    Route::get('instructor/courses/view-draft/{id}', [CourseManageController::class, 'view_draft_content'])->name('courses.view.draft');
    Route::get('instructor/courses/publish/{id}', [CourseManageController::class, 'publish_First_version'])->name('courses.publish.version');
    Route::get('instructor/courses/unpublish/{id}', [CourseManageController::class, 'unpublish_version'])->name('courses.unpublish.version');
    Route::get('instructor/courses/republish/{id}', [CourseManageController::class, 'republish_version'])->name('courses.republish.version');
    Route::get('instructor/courses/delete/{id}', [CourseManageController::class, 'delete_course'])->name('courses.delete.course');
    Route::get('instructor/courses/view-content/{id}', [CourseManageController::class, 'view_published_content'])->name('courses.view.published');
    Route::get('instructor/courses/replace/{id}/{version}', [CourseManageController::class, 'replace_version'])->name('courses.replace.version');
    Route::get('instructor/courses/history/{id}', [CourseManageController::class, 'course_history'])->name('ins.courses.history');

    Route::post('instructor/courses/create/version/{id}', [CourseManageController::class, 'create_version'])->name('courses.create.version');
});

/******************************** ------------ *******************************/
/******************************** ADMIN ROUTES *******************************/
/******************************** ------------ *******************************/

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('admin/settings', [AdminController::class, 'settings'])->name('admin.settings');
    Route::post('admin/settings-update', [AdminController::class, 'settings_update'])->name('admin.settings.update');
    Route::get('admin/profile/{username}', [AdminController::class, 'profile'])->name('admin.profile');

    /******************************** ADMIN USERS ROUTES *******************************/
    Route::get('admin/users', [AdminUsersController::class, 'index'])->name('admin.users');
    Route::get('admin/users/instructor', [AdminUsersController::class, 'instructor'])->name('admin.users.instructor');
    Route::get('admin/users/student', [AdminUsersController::class, 'student'])->name('admin.users.student');
    Route::post('admin/users/create', [AdminUsersController::class, 'create'])->name('admin.users.create');
    Route::get('admin/users/edit/{id}', [AdminUsersController::class, 'edit'])->name('admin.users.edit');
    Route::post('admin/users/update-basic/{id}', [AdminUsersController::class, 'update_basic'])->name('admin.users.update.basic');
    Route::post('admin/users/update-ins/{id}', [AdminUsersController::class, 'update_ins'])->name('admin.users.update.ins');
    Route::post('admin/users/update-std/{id}', [AdminUsersController::class, 'update_std'])->name('admin.users.update.std');
    Route::post('admin/users/update-password/{id}', [AdminUsersController::class, 'update_password'])->name('admin.users.update.password');
    Route::get('admin/users/delete/{id}', [AdminUsersController::class, 'destroy'])->name('admin.users.delete');

    /******************************** ADMIN COURSES ROUTES *******************************/
    Route::get('admin/courses', [AdminCoursesController::class, 'index'])->name('admin.courses');
    Route::get('admin/courses/show/{id}', [AdminCoursesController::class, 'show_course'])->name('admin.courses.show');
    Route::get('admin/courses/preview-redirect/{id}', [AdminCoursesController::class, 'preview_redirect'])->name('admin.courses.preview.redirect');
    Route::get('admin/courses/preview/{id}/{lecture}', [AdminCoursesController::class, 'preview_course'])->name('admin.courses.preview');
    Route::get('admin/courses/preview-next/{id}/{lecture}', [AdminCoursesController::class, 'preview_redirect_next'])->name('admin.courses.preview.next');
    Route::get('admin/courses/preview-prev/{id}/{lecture}', [AdminCoursesController::class, 'preview_redirect_prev'])->name('admin.courses.preview.prev');

    /******************************** ADMIN VERSIONS ROUTES *******************************/
    Route::get('admin/courses/versions', [AdminCoursesController::class, 'versions'])->name('admin.courses.versions');
    Route::get('admin/courses/version-show/{id}', [AdminCoursesController::class, 'show_version'])->name('admin.courses.show.version');
    Route::get('admin/courses/version-redirect/{id}', [AdminCoursesController::class, 'preview_version_redirect'])->name('admin.courses.version.redirect');
    Route::get('admin/courses/version/{id}/{lecture}', [AdminCoursesController::class, 'preview_version'])->name('admin.courses.preview.version');
    Route::get('admin/courses/version-next/{id}/{lecture}', [AdminCoursesController::class, 'preview_redirect_version_next'])->name('admin.courses.version.next');
    Route::get('admin/courses/version-prev/{id}/{lecture}', [AdminCoursesController::class, 'preview_redirect_version_prev'])->name('admin.courses.version.prev');
    Route::post('admin/courses/version/reject', [AdminCoursesController::class, 'version_reject'])->name('admin.courses.version.reject');
    Route::post('admin/courses/version/accept', [AdminCoursesController::class, 'version_accept'])->name('admin.courses.version.accept');

    /******************************** ADMIN REVIEWS ROUTES *******************************/
    Route::get('admin/courses/pendings', [AdminCoursesController::class, 'pendings'])->name('admin.courses.pendings');
    Route::get('admin/courses/start-review/{id}', [AdminCoursesController::class, 'start_review'])->name('admin.courses.start.review');

    /******************************** ADMIN ENROLLMENTS ROUTES *******************************/
    Route::get('admin/enrollments', [AdminEnrollmentController::class, 'enrollments'])->name('admin.enrollments');
    Route::get('admin/enrollments/show/{id}', [AdminEnrollmentController::class, 'enrollment_show'])->name('admin.enrollments.show');
    Route::post('admin/enrollments/suspend', [AdminEnrollmentController::class, 'suspend'])->name('admin.enrollments.suspend');
    Route::post('admin/enrollments/reactivate', [AdminEnrollmentController::class, 'reactivate'])->name('admin.enrollments.reactivate');

    /******************************** ADMIN CATEGORIES ROUTES *******************************/
    Route::get('admin/categories', [AdminCategoriesController::class, 'index'])->name('admin.categories');
    Route::post('admin/categories/create', [AdminCategoriesController::class, 'create'])->name('admin.categories.create');
    Route::get('admin/categories/edit/{id}', [AdminCategoriesController::class, 'edit'])->name('admin.categories.edit');
    Route::post('admin/categories/update', [AdminCategoriesController::class, 'update'])->name('admin.categories.update');
    Route::post('admin/categories/enable', [AdminCategoriesController::class, 'enable'])->name('admin.categories.enable');
    Route::post('admin/categories/disable', [AdminCategoriesController::class, 'disable'])->name('admin.categories.disable');
});


