<?php
namespace App\Http\Controllers;

use App\Models\Reject;
use App\Models\Workpermit;
use App\Mail\StatusUpdated;
use App\Models\Appointment;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\AvailableSlot;
use App\Models\Studentpermit;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class ImmigrationOfficerController extends Controller
{
    // Show Dashboard
    public function showDashboard()
    {
         // Count the different statuses of the applications
    $newApplications = Studentpermit::where('status', 'new')->count();
    $pendingReviews = Studentpermit::where('status', 'pending')->count();
    $approvedApplications = Studentpermit::where('status', 'approved')->count();
    

    // Fetch the most recent student permit applications (latest first)
    $recentPermits = Studentpermit::where('status', '!=', 'rejected')
    ->orderBy('created_at', 'desc')
    ->take(7)
    ->get();

    $recentworkPermits = Workpermit::where('status', '!=', 'rejected')
    ->orderBy('created_at', 'desc')
    ->take(7)
    ->get();


    // Count the total number of student permits
    $totalStudentPermits = Studentpermit::count();

    // Count the total number of work permits
    $totalWorkPermits = Workpermit::count();

    // Pass the application statistics to the view
    return view('officerdashboard', compact('newApplications', 'pendingReviews', 'approvedApplications','recentPermits','totalStudentPermits','totalWorkPermits','recentworkPermits'));
    }

    // View Pending Applications
    public function viewPendingApplications()
    {
        // Get all pending student permits
        $pendingApplications = StudentPermit::where('status', 'pending')->get();
        
        return view('pending_applications', compact('pendingApplications'));
    }

    public function showApplications(Request $request)
    {
        // Initialize the query for fetching applications
        $query = Studentpermit::query();

        // Filter by status if provided in the request
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by name (combining firstname and surname)
        if ($request->filled('firstname') || $request->filled('surname')) {
            $query->where(function($q) use ($request) {
                if ($request->filled('firstname')) {
                    $q->where('name', 'like', '%' . $request->firstname . '%');
                }
                if ($request->filled('surname')) {
                    $q->where('name', 'like', '%' . $request->surname . '%');
                }
            });
        }

        // Filter by reference number
        if ($request->filled('reference_number')) {
            $query->where('reference_number', 'like', '%' . $request->reference_number . '%');
        }

        // Filter by ID/passport number
        if ($request->filled('id_number')) {
            $query->where('id_number', 'like', '%' . $request->id_number . '%');
        }

        // Filter by institution if provided
        if ($request->filled('institution')) {
            $query->where('institution', 'like', '%' . $request->institution . '%');
        }

        // Filter by course if provided
        if ($request->filled('course')) {
            $query->where('course', 'like', '%' . $request->course . '%');
        }

        // Filter by email if provided
        if ($request->filled('email')) {
            $query->where('email', 'like', '%' . $request->email . '%');
        }

        // Get all the applications with the applied filters
        $applications = $query->get();

        // Pass the applications to the view
        return view('applications', compact('applications'));
    }

public function showWorkApplications(Request $request)
{
    // Initialize the query for fetching applications
    $query = Workpermit::query();

    // Filter by status if provided in the request
    if ($request->has('status') && in_array($request->status, ['new', 'pending', 'approved'])) {
        $query->where('status', $request->status);
    }

    // Filter by institution if provided in the request
    if ($request->has('institution')) {
        $query->where('institution', 'like', '%' . $request->institution . '%');
    }

    // Filter by course if provided in the request
    if ($request->has('course')) {
        $query->where('course', 'like', '%' . $request->course . '%');
    }

    // Get all the applications with the applied filters
    $workpermitapplications = $query->get();

    // Pass the applications to the view
    return view('workpermitapplications', compact('workpermitapplications'));
}
public function show($id)
{
    // Find the application by id
    $application = Studentpermit::findOrFail($id);

    // Return the view and pass the application data
    return view('applications.show', compact('application'));
}

public function workshow($id)
{
    // Find the application by id
    $application = Workpermit::findOrFail($id);

    // Return the view and pass the application data
    return view('workpermit.show', compact('application'));
}

public function updateStatus(Request $request, $id)
{
    // Find the permit application
    $studentPermit = Studentpermit::find($id);
    if (!$studentPermit) {
        $studentPermit = Workpermit::findOrFail($id);
    }

    $oldStatus = $studentPermit->status;
    $newStatus = $request->input('status');

    // Update the status
    $studentPermit->status = $newStatus;
    $studentPermit->save();

    $user = $studentPermit->user;

    // Create notification message based on status
    $notificationMessage = "";
    if ($newStatus === 'rejected') {
        $rejectionReason = $request->input('rejection_reason');
        $notificationMessage = "Your permit application has been rejected. Reason: $rejectionReason";
        
        // Create rejection record
        Reject::create([
            'studentpermit_id' => $studentPermit->id,
            'officer_id' => auth()->id(),
            'reason' => $rejectionReason,
        ]);
    } else {
        $notificationMessage = "The status of your permit has been updated from $oldStatus to: $newStatus";
    }

    // Create notification
    Notification::create([
        'user_id' => $user->id,
        'type' => 'system',
        'title' => 'Permit Status Updated',
        'message' => $notificationMessage,
        'read' => false,
    ]);

    // Handle appointment scheduling if approved
    if ($newStatus === 'approved') {
        // Get date 5 days from now instead of tomorrow
        $futureDate = Carbon::now()->addDays(5)->startOfDay();

        $slot = AvailableSlot::where('is_booked', false)
                             ->where('date', '>=', $futureDate)
                             ->orderBy('date')
                             ->orderBy('slot_time')
                             ->first();

        if ($slot) {
            $slot->update([
                'is_booked' => true,
                'applicant_id' => $studentPermit->user_id,
            ]);

            Appointment::create([
                'applicant_id' => $studentPermit->user_id,
                'slot_id' => $slot->id,
                'status' => 'scheduled',
            ]);
        } else {
            return response()->json(['message' => 'No available slots for scheduling appointment'], 400);
        }
    }

    return response()->json([
        'message' => 'Permit status updated successfully',
    ]);
}

}
?>
