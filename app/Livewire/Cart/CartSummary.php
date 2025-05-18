<?php

namespace App\Livewire\Cart;

use App\Models\Gift;
use App\Models\Product;
use App\Models\ShippingPrice;
use App\Services\CartService;
use App\Services\CheckoutService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class CartSummary extends Component
{
    public $cartItems;
    public $summary;
    public $validationStatus = [];
    public $allItemsValid = false;
    protected CartService $cart;

    public function boot(CartService $cart)
    {
        $this->cart = $cart;
    }

    public function mount()
    {
        $this->loadCartItems();
        $this->initializeValidationStatus();
    }

    #[On('cartUpdated')]
    public function loadCartItems()
    {
        $cart = $this->cart->getCart();
        $productIds = array_column($cart, 'product_id');
        $giftIds = array_merge(...array_column(array_column($cart, 'attributes'), 'gifts'));
        $gifts = Gift::whereIn('id', $giftIds)->get();
        $products = Product::with('media')->whereIn('id', $productIds)->get();
        $this->cartItems = new Collection();

        foreach ($cart as $item) {
            $this->cartItems->push((object) [
                'id' => $item['id'],
                'product' => $products->where('id', $item['product_id'])->first(),
                'quantity' => $item['quantity'],
                ...$item['attributes'],
                'gifts' => $gifts->whereIn('id', $item['attributes']['gifts']),
            ]);
        }

        $this->summary = $this->calculateSummary();
    }

    private function initializeValidationStatus()
    {
        $this->validationStatus = [];
        foreach ($this->cartItems as $item) {
            $this->validationStatus[$item->id] = false;
        }
        $this->updateValidationStatus();
    }

    #[On('cartItemValidated')]
    public function updateItemValidation($data)
    {
        $this->validationStatus[$data['itemId']] = $data['isValid'];
        $this->updateValidationStatus();
    }

    private function updateValidationStatus()
    {
        $this->allItemsValid = !empty($this->validationStatus) &&
            count(array_filter($this->validationStatus)) === count($this->validationStatus);
    }

    public function calculateSummary()
    {
        $subtotal = 0;
        foreach ($this->cartItems as $item) {
            $subtotal += ($item->product->final_price * $item->quantity) + $item->gifts->sum('price');
        }

        $shippingCost = ShippingPrice::first()->price;
        $total = $subtotal + $shippingCost;
        return [
            'subtotal' => $subtotal,
            'shippingCost' => $shippingCost,
            'total' => $total,
        ];
    }

    public function checkout()
    {
        if(Auth::check()){
            return redirect()->away( (new CheckoutService())->checkout() );
        }

        return redirect()->route('login');
    }

    public function render()
    {
        return view('livewire.cart.cart-summary');
    }
}
