<?php

namespace App\Livewire;

use App\Models\ShippingPrice as ShippingPriceModel;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Livewire\Component;

class ShippingPrice extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    public function mount(ShippingPriceModel $model): void
    {
        $this->form->fill($model->first()?->toArray());
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('price')
                    ->label('سعر الشحن')
                    ->required(),
            ])->statePath('data');
    }

    public function create(): void
    {
        $data = $this->form->getState();

        ShippingPriceModel::updateOrCreate([
            'city' => "جدة"
        ], [
            'price' => $data['price']
        ]);

        Notification::make()
            ->title('تم تحديث سعر الشحن')
            ->success()
            ->send();
    }

    public function render()
    {
        return view('livewire.shipping-price');
    }
}
