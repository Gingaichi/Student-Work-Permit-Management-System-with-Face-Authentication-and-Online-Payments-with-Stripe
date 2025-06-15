<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class StripeController extends Controller
{
    public function index()
    {
        return view('stripe.index');
    }

    public function checkout(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SK'));

        // Get the reference number from request or session
        $referenceNumber = 'REF-' . rand(1000, 9999);
        session(['reference_number' => $referenceNumber]);

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'bwp',
                    'product_data' => [
                        'name' => 'Permit Fee',
                    ],
                    'unit_amount' => 150000, // $10.00
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('stripe.success'), // Redirect after success
            'cancel_url' => route('stripe.cancel'),   // Redirect if cancelled
        ]);

        return redirect($session->url);
    }

    public function success()
    {
        $user = auth()->user();
        
        // get reference number from student permit or work permit
        $studentPermit = \App\Models\Studentpermit::where('user_id', $user->id)
            ->latest()
            ->first();
        
        $workPermit = \App\Models\Workpermit::where('user_id', $user->id)
            ->latest()
            ->first();
            
        $referenceNumber = $studentPermit ? $studentPermit->reference_number : 
                          ($workPermit ? $workPermit->reference_number : null);

        // Create a receipt record in DB
        \App\Models\Receipt::create([
            'user_id' => $user->id,
            'payment_reference' => $referenceNumber,
            'amount' => 1500.00,
            'currency' => 'BWP',
            'payment_date' => now(),
        ]);

        // Redirect to permit success page
        return redirect()->route('permit.success', ['reference_number' => $referenceNumber]);
    }
    

    public function cancel()
    {
        return view('stripe.cancel'); // Optional: handle payment cancel view
    }
}



