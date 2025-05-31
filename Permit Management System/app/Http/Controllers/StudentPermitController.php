<?php

namespace App\Http\Controllers;

use App\Models\Studentpermit;
use Illuminate\Http\Request;


class StudentPermitController extends Controller
{
    // Method to display the application details for editing
    public function edit($id)
    {
        $application = Studentpermit::findOrFail($id);
        return view('application.edit', compact('application'));
    }

    // Method to handle the application update
    public function update(Request $request, $id)
    {
        $application = Studentpermit::findOrFail($id);

        // Validate the form input
        $validated = $request->validate([
            'phone' => 'required|regex:/^\+?[0-9]{10,15}$/',
            'dob' => 'required|date|before:today',
            // Add other validation rules as needed
        ]);

        // Update the application with the validated data
        $application->update($validated);

        // Redirect back or to a confirmation page
        return redirect()->route('application.edit', $id)->with('status', 'Application updated successfully');
    }

    
    
}

?>