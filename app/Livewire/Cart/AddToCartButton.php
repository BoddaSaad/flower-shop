<?php

namespace App\Livewire\Cart;

use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AddToCartButton extends Component
{
    public $productId;

    public function addToCart()
    {
        if (Auth::check()) {
            CartItem::create([
                'user_id' => auth()->id(),
                'product_id' => $this->productId,
            ]);

            $this->dispatch('popToast', ['message'=>'تمت الإضافة إلى العربة', 'type'=>'success']);
        } else {
            $this->dispatch('popToast', ['message'=>'يرجى تسجيل الدخول أولًا', 'type'=>'info']);
        }
    }

    public function render()
    {
        return view('livewire.cart.add-to-cart-button');
    }
}
