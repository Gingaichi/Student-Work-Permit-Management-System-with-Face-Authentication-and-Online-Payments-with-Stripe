<?php

namespace App\Http\Controllers;


use App\Models\Workpermit;
use Illuminate\Http\Request;


class WorkpermitController extends Controller
{
    public function edit($id)
{
    $workpermit = Workpermit::findOrFail($id);
    return view('workpermit.edit', compact('workpermit'));
}

public function update(Request $request, $id)
    {
        $application = Workpermit::findOrFail($id);

        // Validate the form input
        $validated = $request->validate([
            'phone' => 'required|regex:/^\+?[0-9]{10,15}$/',
            'dob' => 'required|date|before:today',
            // Add other validation rules as needed
        ]);

        // Update the application with the validated data
        $application->update($validated);

        // Redirect back or to a confirmation page
        return redirect()->route('workpermit.edit', $id)->with('status', 'Application updated successfully');
    }

}