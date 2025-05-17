<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderProduct;
use Illuminate\Support\Collection;

class CheckoutService
{

    private $items;
    private int $total_price_cents;
    private $apiUrl;
    private $publicKey;

    public function __construct() {
        $this->items = auth()->user()->cartItems()->with(['product', 'gifts'])->get();
        $this->total_price_cents = $this->calculateSummary();
        $this->apiUrl = config('paymob.api_url');
        $this->publicKey = config('paymob.public_key');
    }

    private function calculateSummary()
    {
        $subtotal = 0;
        foreach ($this->items as $item) {
            $subtotal += ($item->product->final_price * $item->quantity) + $item->gifts->sum('price');
        }

        $shippingCost = 35; // TODO: Fetch from settings
        return $subtotal + $shippingCost;
    }

    private function createCheckout() {
        $checkout = Order::create([
            'user_id' => auth()->id(),
            'amount_in_cents' => $this->total_price_cents,
            'reference' => uniqid(),
        ]);

        $this->createCheckoutItems($checkout->id);

        return $checkout;
    }

    private function createCheckoutItems($checkoutId): void {
        foreach($this->items as $item){
            $orderItem = OrderProduct::create([
                'order_id' => $checkoutId,
                'product_id' => $item->product->id,
                'unit_price_in_cents' => $item->product->final_price * 100,
                'quantity' => $item->quantity,
                'message' => $item->message,
                'receiver_number' => $item->receiver_number,
                'delivery_date' => $item->delivery_date,
            ]);

            foreach($item->gifts as $gift) {
                $orderItem->gifts()->attach($gift->id);
            }
        }
    }

    private function apiCall(Order $checkout): string {
        $response = (new PaymobService())->intent($this->total_price_cents, $checkout->reference);
        $checkout->update(['transaction'=>$response['id']]);
        return $this->apiUrl.'/unifiedcheckout/?publicKey='.$this->publicKey.'&clientSecret='.$response['client_secret'];
    }

    public function checkout(): string {
        $checkout = $this->createCheckout();
        return $this->apiCall($checkout);
    }
}
