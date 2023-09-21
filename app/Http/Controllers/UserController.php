<?php

namespace App\Http\Controllers;

use App\Mail\AccessChanged;
use App\Mail\Invite;
use App\Mail\OrderShipped;
use App\Mail\RefundRequest;
use App\Models\ProductCategory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Stripe\Customer;
use Stripe\Stripe;

class UserController extends Controller
{
    public function purchase(Request $request){
        $customer = $request->customer;
        $card = $request->card;
        $pass = Str::random(12);
        $user = User::firstOrCreate([
            'email' => $customer['email']
        ], [
            'name' => $customer['name'],
            'password' => Hash::make($pass),
            'login_access' => true,
            'purchase_access' => true,
        ]);

        try {
            if(!$user->purchase_access){
                return response()->json([
                    'status' => 'error',
                    'message' => 'Access denied. Please contact support',
                ], 200);
            }
            $category = ProductCategory::find($card['category_id'])->name;
            $wasCreated = $user->wasRecentlyCreated;

            $payment = $user->charge(
                $card['price']*100,
                $customer['payment_method_id'],

            );
            $payment = $payment->asStripePaymentIntent();

            $order = $user->orders()->create([
                'transaction_id' => $payment->charges->data[0]->id,
                'total' => $payment->charges->data[0]->amount,
                'last_four' => $payment->charges->data[0]->payment_method_details->card->last4,
                'product_id' => $card['id'],
                'status' => $payment->charges->data[0]->status,
            ]);
            /*remove all roles*/
            $user->roles()->detach();
            $user->assignRole($category.' Customer');

            Mail::send(new OrderShipped($wasCreated,$user->email, $user->name, $pass, $order->last_four));

            return response()->json([
                'status' => 'success', // 'success' or 'error
                'message' => 'Payment Successful',
                'order' => $order,
            ], 200);
        }catch (\Exception $e){
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function refundRequest(Request $request){
        $user = auth()->user();
        try {
            $order = $user->orders()->find($request->id);

            $order->is_refund_request = true;
            $order->save();
            Mail::send(new RefundRequest($user->name, $order->transaction_id));

            return response()->json([
                'status' => 'success',
                'message' => 'Refund request sent'
            ], 200);
        }catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }


    /*admin route for toggling user access*/
    public function toggleAccess(Request $request){
        $user = User::find($request->id);
        $typeOfAccess = $request->type;
        $changedAccess = null;
        if($typeOfAccess === 'login'){
            $user->login_access = !$user->login_access;
            $changedAccess = $user->login_access;
        }else if($typeOfAccess === 'purchase'){
            $user->purchase_access = !$user->purchase_access;
            $changedAccess = $user->purchase_access;
        }

        $user->save();

        Mail::send(new AccessChanged($user->email, $user->name, $typeOfAccess, $changedAccess));

        return response()->json([
            'status' => 'success',
            'message' => 'User access toggled'
        ], 200);
    }
}
