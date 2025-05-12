<?php

namespace App\Livewire\Cart;

use Livewire\Attributes\On;
use Livewire\Component;

class CartSummary extends Component
{
    public $cartItems;
    public $summary;
    public $validationStatus = [];
    public $allItemsValid = false;

    public function mount()
    {
        $this->loadCartItems();
        $this->initializeValidationStatus();
    }

    #[On('cartUpdated')]
    public function loadCartItems()
    {
        $this->cartItems = auth()->user()->cartItems()->with('product.media')->get();
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
            $subtotal += $item->product->price * $item->quantity;
        }

        $shippingCost = 35; // TODO: Fetch from settings
        $total = $subtotal + $shippingCost;
        return [
            'subtotal' => $subtotal,
            'shippingCost' => $shippingCost,
            'total' => $total,
        ];
    }

    public function checkout()
    {
        dd($this->validationStatus);
    }

    public function render()
    {
        return view('livewire.cart.cart-summary');
    }
}
