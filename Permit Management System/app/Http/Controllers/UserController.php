<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Receipt;
use App\Models\Workpermit;
use App\Models\Appointment;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\AvailableSlot;
use App\Models\Studentpermit;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function login(Request $request){
        // Validate the incoming request data
        $incomingFields = $request->validate([
            'email'=> 'required',
            'password'=>'required'
        ]);

        // Attempt authentication for regular users (applicants)
        if(auth()->attempt(['email'=>$incomingFields['email'],'password'=>$incomingFields['password']])) {
            // Regenerate session for security
            $request->session()->regenerate();
            // Redirect to applicant dashboard upon successful login
            return redirect('/applicantdashboard');
        }

        // If regular auth fails, attempt authentication for immigration officers
        if (auth('immigration')->attempt(['email' => $incomingFields['email'], 'password' => $incomingFields['password']])) {
            // Regenerate session for security
            $request->session()->regenerate();
            // Redirect to immigration officer dashboard
            return redirect('/officerdashboard');
        }
        
        // If both authentication attempts fail, redirect to landing page
        return redirect('/');
    }
    public function logout(){
        // Log out the currently authenticated user
        auth()->logout();
        // Redirect to landing page after successful logout
        return redirect('/landing');
    }
    public function applicantdashboard()
    {
        $userId = auth()->id();
        $user = auth()->user(); // Get the authenticated user

        // Get the latest application from both tables
        $studentApplication = Studentpermit::where('user_id', $userId)->latest()->first();
        $workApplication = Workpermit::where('user_id', $userId)->latest()->first();

        // Determine which application is the latest
        if ($studentApplication && $workApplication) {
            $application = $studentApplication->created_at > $workApplication->created_at ? $studentApplication : $workApplication;
        } else {
            $application = $studentApplication ?? $workApplication;
        }

        // Determine the application type
        $applicationType = $application instanceof Studentpermit ? 'student' : 'work';

        // Fetch the notifications for the logged-in user
        $notifications = Notification::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

        // Fetch the latest receipt for proof of payment
        $latestReceipt = Receipt::where('user_id', auth()->id())
            ->latest('payment_date')
            ->first();

        // Pass all data to the view, including the user
        return view('applicantdashboard', compact(
            'user',
            'application',
            'applicationType',
            'notifications',
            'studentApplication',
            'workApplication',
            'latestReceipt'
        ));
    }


    
    public function studentpermit() {
        return view('studentpermit');
    }
    public function workpermit() {
        return view('workpermit');
    }
    public function studentpermitinfo() {
        return view('studentpermitinfo');
    }
    public function studentpermitoptions() {
        return view('permit_options');
    }
    public function workpermitinfo() {
        return view('workpermitinfo');
    }
    public function registerpage() {
        return view('register');
    }
    public function workregisterpage() {
        return view('workregister');
    }


    // In UserController.php

    public function register(Request $request)
    {
       // Validate the form data
    $request->validate([
    'name' => 'required|string|max:255|regex:/^[A-Za-z\s]+$/',
    'email' => 'required|email|unique:users,email',
    'password' => [
    'required',
    'string',
    'min:6',
    'confirmed',
    'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*[\W_]).+$/'
    ],
    ]);

    
        // Create and save the user
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password); // Encrypt the password
        $user->save(); // Save the user to the database

        auth()->login($user);
    
        // Return a success message directly on the same page
        return redirect('/studentpermit')->with('success', 'Registration successful!');
    }
    public function workregister(Request $request)
    {
        // Validate the form data
        $request->validate([
            'name' => 'required|string|max:255|regex:/^[A-Za-z\s]+$/',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:3',
        ]);
    
        // Create and save the user
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password); // Encrypt the password
        $user->save(); // Save the user to the database

        auth()->login($user);
    
        // Return a success message directly on the same page
        return redirect('/workpermit')->with('success', 'Registration successful!');
    }
    

public function showAppointmentDetails(Request $request)
{
    // Retrieve the appointment associated with the authenticated user
    $appointment = Appointment::where('applicant_id', auth()->id())->first();
    
    if (!$appointment) {
        return redirect()->back()->with('error', 'No appointment found.');
    }

    // Access the slot_time and date from the related AvailableSlot model
    $slotTime = $appointment->slot ? Carbon::parse($appointment->slot->slot_time)->format('h:i A') : 'N/A';
    $slotDate = $appointment->slot ? Carbon::parse($appointment->slot->date)->format('F j, Y') : 'N/A';

    return view('appointment_details', compact('appointment', 'slotTime', 'slotDate'));
}


    
public function scheduleAppointment($userId)
{
    // Get date 5 days from now instead of tomorrow
    $futureDate = Carbon::now()->addDays(5)->startOfDay();

    $slot = AvailableSlot::where('is_booked', false)
                         ->where('date', '>=', $futureDate)
                         ->orderBy('date')
                         ->orderBy('slot_time')
                         ->first();

    if (!$slot) {
        return response()->json(['message' => 'No available slots'], 400);
    }

    $slot->update(['is_booked' => true, 'applicant_id' => $userId]);

    Appointment::create([
        'applicant_id' => $userId,
        'slot_id' => $slot->id,
        'status' => 'scheduled',
    ]);

    return response()->json(['message' => 'Appointment scheduled successfully']);
}
}

