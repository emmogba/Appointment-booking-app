<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Service;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Jayboss\Paystack\Paystack;

class PaymentController extends Controller
{

    /**
     * Redirect the User to Paystack Payment Page
     * @return Url
     */
    public function redirectToGateway(Request $request, $serviceId)
    {
        $service = Service::findOrFail($serviceId);
    $amount = $service->price * 100; // convert to kobo

    $data = [
        'amount' => $amount,
        'email' => $request->user()->email,
        'metadata' => [
            'service_id' => $serviceId,
            'user_id' => $request->user()->id,
        ],
    ];
        try{
            $paystack = new Paystack();

            return $paystack->getAuthorizationUrl($data)->redirectNow();
        }catch(\Exception $e) {
            return Redirect::back()->withMessage(['msg'=>'The paystack token has expired. Please refresh the page and try again.', 'type'=>'error']);
        }        
    }

    /**
     * Obtain Paystack payment information
     * @return void
     */
    public function handleGatewayCallback(Request $request)
    {
         $paystack = new Paystack();
        $paymentDetails = $paystack->getPaymentData();
         if (!$paymentDetails['status']) {
        return redirect()->back()->with('error', 'Unable to verify payment. Please try again later.');
    }

    $metadata = $paymentDetails['data']['metadata'];
    $serviceId = $metadata['service_id'];

        dd($paymentDetails);
        $appointment = new Appointment();
        $appointment->service_id = $serviceId;
        $appointment->user_id = $metadata['user_id'];
        $appointment->save();

        return redirect()->route('appointments.index')->with('success', 'Appointment booked successfully.');

    }
        public function test()
    {
        $paystack = new Paystack();
        $ref = $paystack->genTranxRef();
        return view('welcome',compact('ref'));
    }

}