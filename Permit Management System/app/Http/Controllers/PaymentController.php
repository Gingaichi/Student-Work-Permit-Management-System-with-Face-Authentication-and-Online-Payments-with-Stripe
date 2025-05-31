<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function initiate()
    {
        // Create a datetime for the transaction
        $dateTime = new \DateTime();

        // Prepare the data for the payment request
        $data = [
            'PAYGATE_ID'       => env('PAYGATE_ID'),
            'REFERENCE'        => uniqid('pgtest_'),
            'AMOUNT'           => 3299, // Example amount in cents
            'CURRENCY'         => 'ZAR',
            'RETURN_URL'       => route('payment_response'),
            'TRANSACTION_DATE' => $dateTime->format('Y-m-d H:i:s'),
            'LOCALE'           => 'en-za',
            'COUNTRY'          => 'ZAF',
            'EMAIL'            => 'developer@mailinator.com',
            'NOTIFY_URL'       => route('payment_notify'),
        ];

        // Calculate the checksum for the request
        $checksum = md5(implode('', $data) . env('PAYGATE_SECRET'));
        $data['CHECKSUM'] = $checksum;

        // Send the request to PayGate
        $response = Http::asForm()->post(env('PAYGATE_INITIATE_URL'), $data);

        // Parse the response
        parse_str($response->body(), $output);

        // Log the PayGate response for debugging
        Log::info("PayGate Initiate Response", $output);

        // Check if the expected keys are present in the response
        if (isset($output['PAY_REQUEST_ID']) && isset($output['PAYGATE_ID']) && isset($output['REFERENCE']) && isset($output['CHECKSUM'])) {
            // Create a transaction record in the database
            Transaction::create([
                'pay_request_id'     => $output['PAY_REQUEST_ID'],
                'paygate_id'         => $output['PAYGATE_ID'],
                'reference'          => $output['REFERENCE'],
                'checksum'           => $output['CHECKSUM'],
                'transaction_status' => 'initiated',
            ]);

            // Pass the output data to the view for displaying the payment button
            return view('payment.form', compact('output'));
        }

        // Log an error if expected keys are missing
        Log::error("Missing expected keys in initiate response", ['response' => $response->body()]);
        return "Something went wrong while initiating payment.";
    }

    public function notify(Request $request)
    {
        // Process the notification from PayGate to verify the payment status
        $paygateId = $request->input('PAYGATE_ID');
        $payRequestId = $request->input('PAY_REQUEST_ID');

        // Find the transaction in the database
        $transaction = Transaction::where('paygate_id', $paygateId)
            ->where('pay_request_id', $payRequestId)
            ->where('transaction_status', 'initiated')
            ->first();

        if ($transaction) {
            // Prepare data for querying the transaction status from PayGate
            $data = [
                'PAYGATE_ID'     => env('PAYGATE_ID'),
                'PAY_REQUEST_ID' => $transaction->pay_request_id,
                'REFERENCE'      => $transaction->reference,
            ];

            // Calculate the checksum for the query request
            $data['CHECKSUM'] = md5(implode('', $data) . env('PAYGATE_SECRET'));

            // Query PayGate for the transaction status
            $response = Http::asForm()->post(env('PAYGATE_QUERY_URL'), $data);
            parse_str($response->body(), $output);

            // Log the PayGate notification response for debugging
            Log::info("PayGate Notify Response", $output);

            // If the transaction status is successful, update the transaction in the database
            $status = $output['TRANSACTION_STATUS'] ?? null;
            if (!empty($output) && $status == '1') {
                $transaction->update([
                    'reference'          => $output['REFERENCE'] ?? $transaction->reference,
                    'transaction_status' => 'successful',
                    'result_code'        => $output['RESULT_CODE'] ?? null,
                    'auth_code'          => $output['AUTH_CODE'] ?? null,
                    'currency'           => $output['CURRENCY'] ?? null,
                    'amount'             => $output['AMOUNT'] ?? null,
                    'result_desc'        => $output['RESULT_DESC'] ?? null,
                    'transaction_id'     => $output['TRANSACTION_ID'] ?? null,
                    'pay_method'         => $output['PAY_METHOD'] ?? null,
                    'pay_method_detail'  => $output['PAY_METHOD_DETAIL'] ?? null,
                    'vault_id'           => $output['VAULT_ID'] ?? null,
                    'payvault_data_1'    => $output['PAYVAULT_DATA_1'] ?? null,
                    'payvault_data_2'    => $output['PAYVAULT_DATA_2'] ?? null,
                    'checksum'           => $output['CHECKSUM'] ?? null,
                ]);

                return "OK";
            }

            // Mark the transaction as failed if the status isn't successful
            $transaction->update([
                'reference'          => $output['REFERENCE'] ?? $transaction->reference,
                'transaction_status' => 'failed',
                'result_code'        => $output['RESULT_CODE'] ?? null,
                'auth_code'          => $output['AUTH_CODE'] ?? null,
                'currency'           => $output['CURRENCY'] ?? null,
                'amount'             => $output['AMOUNT'] ?? null,
                'result_desc'        => $output['RESULT_DESC'] ?? null,
                'transaction_id'     => $output['TRANSACTION_ID'] ?? null,
                'pay_method'         => $output['PAY_METHOD'] ?? null,
                'pay_method_detail'  => $output['PAY_METHOD_DETAIL'] ?? null,
                'vault_id'           => $output['VAULT_ID'] ?? null,
                'payvault_data_1'    => $output['PAYVAULT_DATA_1'] ?? null,
                'payvault_data_2'    => $output['PAYVAULT_DATA_2'] ?? null,
                'checksum'           => $output['CHECKSUM'] ?? null,
            ]);

            return "Payment couldn't be verified";
        }

        // If no transaction was found, log a warning and return an error message
        Log::warning("Transaction not found for notify", ['PAY_REQUEST_ID' => $payRequestId]);
        return "Something went wrong";
    }

    public function pg_response(Request $request)
    {
        // Get the payment request ID from the response and look up the transaction
        $payRequestId = $request->input('PAY_REQUEST_ID');
        $transaction = Transaction::where('pay_request_id', $payRequestId)->first();

        // If the transaction doesn't exist, return an error message
        if (!$transaction) {
            Log::error("Transaction not found for response", ['PAY_REQUEST_ID' => $payRequestId]);
            return "Something went wrong";
        }

        // Return the response view with the transaction data
        return view("payment.response", compact('transaction'));
    }
    public function viewPaymentPage() {
        // Check if you need to fetch transaction details or initiate payment data
        $transaction = Transaction::latest()->first();  // Example: Get the latest transaction, or adjust as needed
    
        // If no transaction exists, you can either redirect to initiate payment or handle the error.
        if (!$transaction) {
            return redirect()->route('payment_initiate');  // Redirect to initiate if there's no transaction
        }
    
        // Prepare the output data you want to pass to the view, similar to the 'initiate' method
        $output = [
            'PAY_REQUEST_ID' => $transaction->pay_request_id,
            'CHECKSUM'       => $transaction->checksum,
            'PAYGATE_ID'     => $transaction->paygate_id,
            'REFERENCE'      => $transaction->reference,
        ];
    
        // Return the view and pass the output data to it
        return view('payment.form', compact('output'));
    }
    
}
