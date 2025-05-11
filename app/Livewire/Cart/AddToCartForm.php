<?php

namespace App\Livewire\Cart;

use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Component;

class AddToCartForm extends Component
{
    public $product;

    #[Validate('required|min:3', as: 'رسالة الإهداء')]
    public $message = '';

    #[Validate('required', as: 'رقم المستلم')]
    public $receiver_number = '';

    #[Validate('required', as: 'تاريخ التوصيل')]
    public $delivery_date = '';

    public $quantity = '';
    public $gifts = [];

    public function addToCart()
    {
        $this->validate();

        if (Auth::check()) {
            $cartItem = CartItem::create([
                'user_id' => auth()->id(),
                'product_id' => $this->product->id,
                'message' => $this->message,
                'receiver_number' => $this->receiver_number,
                'delivery_date' => $this->delivery_date,
                'quantity' => $this->quantity,
            ]);

            $cartItem->gifts()->attach($this->gifts);

            $this->dispatch('popToast', ['message'=>'تمت الإضافة إلى العربة', 'type'=>'success']);
        } else {
            $this->dispatch('popToast', ['message'=>'يرجى تسجيل الدخول أولًا', 'type'=>'info']);
        }
    }

    public function toggleGift($giftId)
    {
        if (in_array($giftId, $this->gifts)) {
            $this->gifts = array_diff($this->gifts, [$giftId]);
        } else {
            $this->gifts[] = $giftId;
        }
    }

    public function render()
    {
        return view('livewire.cart.add-to-cart-form');
    }
}
