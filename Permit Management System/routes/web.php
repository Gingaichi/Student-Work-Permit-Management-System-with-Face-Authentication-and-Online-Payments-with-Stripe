<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PermitController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StorageController;
use App\Http\Controllers\TemplateController;
use App\Http\Controllers\WorkpermitController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\ImmigrationOfficerController;
use App\Http\Controllers\SlotController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\ReportController;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use App\Models\Receipt;

Route::get('/', function () {
    return view('home');
})->name('home');;

Route::get('/landing', function () {
    return view('landing'); // or the name of your landing view file
})->name('landing');

Route::get('/officerdashboard', [ImmigrationOfficerController::class, 'showDashboard'])->name('officer.dashboard');


Route::get('/register',[UserController::class, 'registerpage'])->name('registerpage');
Route::get('/workregister',[UserController::class, 'workregisterpage'])->name('workregisterpage');
Route::post('/logout', [UserController::class, 'logout'])->name('logout');
Route::post('/login', [UserController::class, 'login'])->name('login');
Route::get('/studentpermit', [UserController::class, 'studentpermit'])->name('studentpermit');
Route::get('/workpermit', [UserController::class, 'workpermit'])->name('workpermit');
Route::post('/register', [UserController::class, 'register'])->name('register');
Route::post('/workregister', [UserController::class, 'workregister'])->name('workregister');
Route::get('/studentpermitinfo', [UserController::class, 'studentpermitinfo'])->name('studentpermitinfo');
Route::get('/studentpermitoptions', [UserController::class, 'studentpermitoptions'])->name('studentpermitoptions');
Route::get('/workpermitinfo', [UserController::class, 'workpermitinfo'])->name('workpermitinfo');
Route::get('/applicantdashboard', [UserController::class, 'applicantdashboard'])->name('applicantdashboard');

Route::get('/permit-success/{reference_number}', [PermitController::class, 'showSuccessPage'])->name('permit.success');

//Immigration Office routes
// View pending applications
Route::get('/officerdashboard/pending-applications', [ImmigrationOfficerController::class, 'viewPendingApplications'])->middleware('auth:immigration');

// Search by institution
Route::get('/officerdashboard/search-applications', [ImmigrationOfficerController::class, 'searchByInstitution'])->middleware('auth:immigration');

//Permit routes
Route::post('/submit-permit', [PermitController::class, 'createPermit'])->name('submit-permit');
Route::post('/submit-workpermit', [PermitController::class, 'createWorkPermit'])->name('submit-work-permit');

Route::get('/applications', [ImmigrationOfficerController::class, 'showApplications'])->name('applications.index');
Route::get('/workpermitapplications', [ImmigrationOfficerController::class, 'showWorkApplications'])->name('workpermits.index');

//to show full applications when click button on table
Route::get('/applications/{id}', [ImmigrationOfficerController::class, 'show'])->name('applications.show');
Route::get('/workpermitapplications/{id}', [ImmigrationOfficerController::class, 'workshow'])->name('workpermit.show');


Route::get("/uploads/{filename}", [StorageController::class,"index"])->name("image.show");

Route::post('/student-permits/{id}/update-status', [ImmigrationOfficerController::class, 'updateStatus'])->name('studentpermits.updateStatus');
Route::post('/work-permits/{id}/update-status', [ImmigrationOfficerController::class, 'updateStatus'])->name('workpermits.updateStatus');


//template routes
Route::get('/home',[TemplateController::class,'index']);

use App\Http\Controllers\StudentPermitController;

Route::get('/student-permit/{id}/edit', [StudentPermitController::class, 'edit'])->name('application.edit');
Route::put('/work-permit/{id}/edit', [WorkpermitController::class, 'edit'])->name('workpermit.edit');
// routes/web.php

Route::put('/workpermit/{id}', [WorkpermitController::class, 'update'])->name('workpermit.update');
Route::put('/student-permit/{id}', [StudentPermitController::class, 'update'])->name('application.update');


Route::get('/workpermit/edit/{id}', [WorkpermitController::class, 'edit'])->name('workpermit.edit');

Route::post('/assign-slot/{applicantId}', [AppointmentController::class, 'assignSlotToApplicant']);
Route::get('/generate-slots', [SlotController::class, 'generateSlots']);
Route::get('/appointments', [AppointmentController::class, 'showAppointmentDetails'])->name('appointments.show');

Route::post('/check-background', [ImageController::class, 'checkBackground']);

//Payment routes
Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
Route::get('/reports/generate', [ReportController::class, 'generate'])->name('reports.generate');
Route::get('/reports/charts', [ReportController::class, 'generateCharts'])->name('reports.charts');
Route::get('/reports/compare/{type}', [ReportController::class, 'compare'])->name('reports.compare');

Route::get('/payment', [StripeController::class, 'index'])->name('stripe.index');
Route::get('/checkout', [StripeController::class, 'checkout'])->name('stripe.checkout');
Route::get('/success', [StripeController::class, 'success'])->name('stripe.success');
Route::get('/cancel', [StripeController::class, 'cancel'])->name('stripe.cancel');

//receipts routes
Route::prefix('receipts')->group(function() {
    Route::get('/receipt', [App\Http\Controllers\Admin\Receipts\IndexController::class, 'index'])->name('admin.receipts.index');
    Route::get('/create', [App\Http\Controllers\Admin\Receipts\CreateController::class, 'create'])->name('admin.receipts.create');
    Route::get('/receipt/{id}/download', function($id){
        $receipt = \App\Models\Receipt::findOrFail($id);
        $pdf = Pdf::loadView('documents.receipt', compact('receipt'));
        $date = \Carbon\Carbon::parse($receipt->payment_date)->toDateString();
        return $pdf->download("receipt_{$date}_#{$id}.pdf");
    })->name('user.receipts.download');

});

// report routes
Route::post('/reports/custom-comparison', [ReportController::class, 'compareCustom'])->name('reports.compareCustom');
Route::get('/reports/custom-comparison', [ReportController::class, 'showCustomComparisonForm'])->name('reports.customComparisonForm');




