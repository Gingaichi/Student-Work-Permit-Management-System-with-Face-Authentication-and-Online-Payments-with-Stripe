<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;  // Import the Http facade

class ImageController extends Controller
{
    public function checkBackground(Request $request)
    {
        // Validate that the file is present
        $request->validate([
            'image' => 'required|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        // Get the uploaded file
        $file = $request->file('image');

        // Send the image to the Flask API
        $response = Http::attach(
            'file', file_get_contents($file), $file->getClientOriginalName()
        )->post('http://127.0.0.1:5000/check-background');  // Flask API endpoint

        // Check the response from the Flask API
        if ($response->successful()) {
            $responseData = $response->json();

            // Return a response based on the Flask API result
            return response()->json([
                'message' => $responseData['message']
            ], 200);
        } else {
            // If there was an error with the request to Flask API
            return response()->json([
                'error' => 'Error in processing the image'
            ], 500);
        }
    }
}
