<?php

namespace App\Http\Controllers;

use App\Models\Workpermit;
use Illuminate\Http\Request;
use App\Models\Studentpermit;
use Illuminate\Support\Facades\Storage;

class PermitController extends Controller
{
    

public function createWorkPermit(Request $request) {

   //dd('Request is reaching createWorkPermit method');
    
    $incomingFields = $request->validate([
        'name' => 'required|string|max:255|regex:/^[A-Za-z\s]+$/',               // Full Name
        'email' => 'required|email|unique:workpermits,email',             // Email Address
        'phone' => 'required',              // Phone Number
        'dob' => 'required',                // Date of Birth
        'nationality' => 'required',       // Nationality
        'passport_number' => 'required',         // Identification Number
        'job_title' => 'required',       // jobtitle Name
        'employer' => 'required',   // employer
        'workplace_address' => 'required',          // workplace_address of Stay
        'employment_duration' => 'required',          // employmentduration of Stay
        'app_letter' => 'required|mimes:pdf,doc,docx|max:10240',  // 10MB max file size
        'passport_photo' => 'required|mimes:jpg,pdf,doc,docx|max:10240',
        'employment_contract' => 'required|mimes:jpg,jpeg,png,pdf,doc,docx|max:10240',
        'cv' => 'required|mimes:jpg,jpeg,png,pdf,doc,docx|max:10240',
        'professional_clearance' => 'required|mimes:jpg,jpeg,png,pdf,doc,docx|max:10240'
    ]);
    //dd("User ID: " . $incomingFields['user_id']);
   //dd("Form submitted successfully!");

        $incomingFields['app_letter'] = $request->file('app_letter')->store('uploads', 'public');
    
        $incomingFields['passport_photo'] = $request->file('passport_photo')->store('uploads', 'public');
    
        $incomingFields['employment_contract'] = $request->file('employment_contract')->store('uploads', 'public');

        $incomingFields['cv'] = $request->file('cv')->store('uploads', 'public');

        $incomingFields['professional_clearance'] = $request->file('professional_clearance')->store('uploads', 'public');
        
    
    
   // Sanitize the input to remove any HTML tags
    $incomingFields['name'] = strip_tags($incomingFields['name']);
    $incomingFields['email'] = strip_tags($incomingFields['email']);
    $incomingFields['phone'] = strip_tags($incomingFields['phone']);
    $incomingFields['dob'] = strip_tags($incomingFields['dob']);
    $incomingFields['nationality'] = strip_tags($incomingFields['nationality']);
    $incomingFields['passport_number'] = strip_tags($incomingFields['passport_number']);
    $incomingFields['job_title'] = strip_tags($incomingFields['job_title']);
    $incomingFields['employer'] = strip_tags($incomingFields['employer']);
    $incomingFields['workplace_address'] = strip_tags($incomingFields['workplace_address']);
    $incomingFields['employment_duration'] = strip_tags($incomingFields['employment_duration']);
    

    $incomingFields['user_id'] = auth()->id();
    //dd("User ID: " . $incomingFields['user_id']);
    $permit=Workpermit::create($incomingFields);
    
    // Generate a random reference number
    $referenceNumber = strtoupper('REF-' . uniqid());

    // Optionally, save the reference number to the database
    $permit->reference_number = $referenceNumber;
    $permit->save();

    // Store the reference number in session for later use
    session(['reference_number' => $referenceNumber]);
    
    // Redirect to stripe checkout first
    return redirect()->route('stripe.checkout');
}

public function createPermit(Request $request) {
    $incomingFields = $request->validate([
        'phone' => 'required',              // Phone Number
        'dob' => 'required',                // Date of Birth
        'nationality' => 'required',       // Nationality
        'id_number' => 'required',         // Identification Number
        'course' => 'required',            // Course of Study
        'institution' => 'required',            // Course of Study
        'current_address' => 'required',   // Current Place of Residence
        'duration' => 'required',          // Duration of Stay
        'app_letter' => 'required|mimes:pdf,doc,docx|max:10240',  // 10MB max file size
        'passport_photo' => 'required|mimes:jpg,jpeg,png,pdf,doc,docx|max:10240',
        'birth_certificate' => 'required|mimes:jpg,jpeg,png,pdf,doc,docx|max:10240'
    ],[
        // Custom error messages
        'phone.required' => 'The phone number is required.',
        'phone.regex' => 'The phone number format is invalid.',
        'dob.required' => 'The date of birth is required.',
        'dob.date' => 'Please provide a valid date of birth.',
        'nationality.required' => 'Nationality is required.',
        'id_number.required' => 'The ID number is required.',
        'id_number.alpha_num' => 'The ID number should be alphanumeric.',
        'id_number.min' => 'The ID number should be at least 8 characters long.',
        'course.required' => 'The course of study is required.',
        'institution.required' => 'The institution name is required.',
        'current_address.required' => 'Your current address is required.',
        'duration.required' => 'The duration of stay is required.',
        'duration.integer' => 'The duration must be a number.',
        'duration.min' => 'The duration must be at least 1.',
        'app_letter.required' => 'The application letter is required.',
        'app_letter.mimes' => 'The application letter must be a file of type: pdf, doc, docx.',
        'app_letter.max' => 'The application letter cannot be larger than 10MB.',
        'passport_photo.required' => 'The passport photo is required.',
        'passport_photo.mimes' => 'The passport photo must be a file of type: jpg, jpeg, png.',
        'passport_photo.max' => 'The passport photo cannot be larger than 10MB.',
        'birth_certificate.required' => 'The birth certificate is required.',
        'birth_certificate.max' => 'The birth certificate cannot be larger than 10MB.'
    ]);
    

        $incomingFields['app_letter'] = $request->file('app_letter')->store('uploads', 'public');
    
        $incomingFields['passport_photo'] = $request->file('passport_photo')->store('uploads', 'public');
    
        $incomingFields['birth_certificate'] = $request->file('birth_certificate')->store('uploads', 'public');
    
    
   // Sanitize the input to remove any HTML tags
   $incomingFields['name'] = auth()->user()->name;
   $incomingFields['email'] = auth()->user()->email;
    $incomingFields['phone'] = strip_tags($incomingFields['phone']);
    $incomingFields['dob'] = strip_tags($incomingFields['dob']);
    $incomingFields['nationality'] = strip_tags($incomingFields['nationality']);
    $incomingFields['id_number'] = strip_tags($incomingFields['id_number']);
    $incomingFields['course'] = strip_tags($incomingFields['course']);
    $incomingFields['institution'] = strip_tags($incomingFields['institution']);
    $incomingFields['current_address'] = strip_tags($incomingFields['current_address']);
    $incomingFields['duration'] = strip_tags($incomingFields['duration']);
    

    $incomingFields['user_id'] = auth()->id();
    $permit=Studentpermit::create($incomingFields);
    
    // Generate a reference number using full name and 4 random digits
    $fullName = auth()->user()->name;
    $randomDigits = rand(1000, 9999);  // Generate a 4-digit random number
    $referenceNumber = strtoupper(str_replace(' ', '', $fullName) . $randomDigits);

    // Save the reference number to the database
    $permit->reference_number = $referenceNumber;
    $permit->save();

    // Store the reference number in session for later use
    session(['reference_number' => $referenceNumber]);
    
    // Redirect to stripe checkout first
    return redirect()->route('stripe.checkout');
}


public function showSuccessPage($reference_number)
{
    $user = auth()->user();
    
    // Get the latest receipt for the authenticated user
    $latestReceipt = \App\Models\Receipt::where('user_id', $user->id)
        ->latest('payment_date')
        ->first();

    // Get the latest permit (either student or work)
    $studentPermit = \App\Models\Studentpermit::where('user_id', $user->id)
        ->latest()
        ->first();
    
    $workPermit = \App\Models\Workpermit::where('user_id', $user->id)
        ->latest()
        ->first();
        
    // Use whichever permit reference number exists
    $reference_number = $studentPermit ? $studentPermit->reference_number : 
                       ($workPermit ? $workPermit->reference_number : $reference_number);

    return view('permit_success', compact('reference_number', 'latestReceipt'));
}

}




