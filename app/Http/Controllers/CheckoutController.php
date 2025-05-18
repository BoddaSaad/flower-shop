<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\PaymobService;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{

    public function webhook(Request $request)
    {
        $data = $request->obj;
        $hmac = $request->query('hmac');
        if((new PaymobService())->hmacCalc($data, $hmac)) {
            $checkout = Order::where('reference', $data['order']['merchant_order_id'])->firstOrFail();

            if ($data['success'] === true) {
                $checkout->update(['status' => "confirmed"]);
                $checkout->items->each(function ($item) {
                    $item->product->decrement('quantity', $item->quantity);
                    $item->gifts()->decrement('quantity');
                });

                $checkout->user->cartItems()->delete();
            } else {
                $checkout->update(['status' => "cancelled"]);
            }

            return 'good';
        }

        return 'failed';
        // HMAC Isn't Correct
    }
}
