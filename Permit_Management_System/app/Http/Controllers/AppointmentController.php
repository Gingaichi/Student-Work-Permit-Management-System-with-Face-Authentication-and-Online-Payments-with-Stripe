<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AvailableSlot;
use App\Models\Appointment;
use Carbon\Carbon;

class AppointmentController extends Controller
{
   // Method to assign an available slot to an applicant based on their ID
   public function assignSlotToApplicant($applicantId)
   {
       // Get date 5 days from now instead of tomorrow
       $futureDate = Carbon::now()->addDays(5)->startOfDay();

       // Find the first available slot that is not booked and is from 5 days onwards
       $slot = AvailableSlot::where('is_booked', false)
                            ->where('date', '>=', $futureDate)
                            ->orderBy('date')
                            ->orderBy('slot_time')
                            ->first();

       if (!$slot) {
           return response()->json(['message' => 'No available slots'], 400);
       }

       $slot->update(['is_booked' => true, 'applicant_id' => $applicantId]);

       return response()->json(['message' => 'Slot assigned', 'slot' => $slot]);
   }

   public function showAppointmentDetails(Request $request)
   {
       // Retrieve the appointment associated with the authenticated user
       $appointment = Appointment::where('applicant_id', auth()->id())->first();
       
       if (!$appointment) {
           return view('appointments.no_appointment');
       }

       // Access the slot_time and date from the related AvailableSlot model
       $slotTime = $appointment->slot ? Carbon::parse($appointment->slot->slot_time)->format('h:i A') : 'N/A';
       $slotDate = $appointment->slot ? Carbon::parse($appointment->slot->date)->format('F j, Y') : 'N/A';

       return view('appointment_details', compact('appointment', 'slotTime', 'slotDate'));
   }
}
