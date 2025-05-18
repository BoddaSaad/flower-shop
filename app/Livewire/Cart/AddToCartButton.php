<?php

namespace App\Livewire\Cart;

use App\Services\CartService;
use Livewire\Component;

class AddToCartButton extends Component
{
    public $productId;

    public function addToCart(CartService $cart)
    {
        $cart->add($this->productId);
        $this->dispatch('popToast', ['message'=>'تمت الإضافة إلى العربة', 'type'=>'success']);
    }

    public function render()
    {
        return view('livewire.cart.add-to-cart-button');
    }
}
