<?php

namespace App\Services;

use App\Models\Gift;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\ShippingPrice;
use Illuminate\Support\Collection;

class CheckoutService
{

    private $items;
    private int $total_price_cents;
    private $apiUrl;
    private $publicKey;

    public function __construct() {
        $cart = (new CartService())->getCart();
        $productIds = array_column($cart, 'product_id');
        $giftIds = array_merge(...array_column(array_column($cart, 'attributes'), 'gifts'));
        $gifts = Gift::whereIn('id', $giftIds)->get();
        $products = Product::with('media')->whereIn('id', $productIds)->get();
        $this->items = new Collection();

        foreach ($cart as $item) {
            $this->items->push((object) [
                'id' => $item['id'],
                'product' => $products->where('id', $item['product_id'])->first(),
                'quantity' => $item['quantity'],
                ...$item['attributes'],
                'gifts' => $gifts->whereIn('id', $item['attributes']['gifts']),
            ]);
        }

        $this->total_price_cents = $this->calculateSummary() * 100;
        $this->apiUrl = config('paymob.api_url');
        $this->publicKey = config('paymob.public_key');
    }

    private function calculateSummary()
    {
        $subtotal = 0;
        foreach ($this->items as $item) {
            $subtotal += ($item->product->final_price * $item->quantity) + $item->gifts->sum('price');
        }

        $shippingCost = ShippingPrice::first()->price;
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
