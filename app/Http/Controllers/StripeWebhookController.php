<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Laravel\Cashier\Http\Controllers\WebhookController as CashierWebhookController;

class StripeWebhookController extends CashierWebhookController
{
    public function handleChargeRefunded($payload)
    {
        $order = Order::where('transaction_id', $payload['data']['object']['id'])->first();
        $order?->update([
            'status' => 'refunded'
        ]);;
    }
}
