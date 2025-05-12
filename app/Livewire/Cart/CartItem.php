<?php

namespace App\Livewire\Cart;

use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use App\Models\CartItem as CartItemModel;

class CartItem extends Component
{
    public $item;

    #[Validate('required|min:3', as: 'رسالة الإهداء')]
    public $message = '';

    #[Validate('required', as: 'رقم المستلم')]
    public $receiver_number = '';

    #[Validate('required', as: 'تاريخ التوصيل')]
    public $delivery_date = '';

    public $quantity = 1;

    public function mount($item)
    {
        $this->item = $item;
        $this->message = $item->message;
        $this->receiver_number = $item->receiver_number;
        $this->delivery_date = $item->delivery_date;
        $this->quantity = $item->quantity;

        if($this->message && $this->receiver_number && $this->delivery_date){
            $this->dispatch('cartItemValidated', [
                'itemId' => $this->item->id,
                'isValid' => true
            ]);
        }
    }

    public function updated()
    {
        $isValid = false;

        try {
            $this->validate();
            $isValid = true;

            $this->item->update([
                'message' => $this->message,
                'receiver_number' => $this->receiver_number,
                'delivery_date' => $this->delivery_date,
                'quantity' => $this->quantity,
            ]);

            $this->dispatch('popToast', ['message'=>'تم تحديث الطلب بنجاح', 'type'=>'success']);
        } catch (\Illuminate\Validation\ValidationException $e) {
            $isValid = false;
        }

        $this->dispatch('cartItemValidated', [
            'itemId' => $this->item->id,
            'isValid' => $isValid
        ]);
    }

    public function removeItem()
    {
        CartItemModel::find($this->item->id)->delete();
        $this->dispatch('cartUpdated');
        $this->dispatch('popToast', ['message'=>'تمت إزالة العنصر من العربة', 'type'=>'success']);
    }

    public function render()
    {
        return view('livewire.cart.cart-item');
    }
}
