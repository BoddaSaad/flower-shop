<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use App\Models\Order;
use Filament\Actions\CreateAction;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListOrders extends ListRecords
{
    protected static string $resource = OrderResource::class;

    protected static ?string $title = 'الطلبات';

    public function getTabs(): array
    {
        return [
            'الكل' => Tab::make(),
            'بالانتظار' => Tab::make()
                ->modifyQueryUsing(fn(Builder $query) => $query->where('shipping_status', 'pending'))
                ->badge(Order::query()->where('shipping_status', 'pending')->count()),
            'يتم تحضيرها' => Tab::make()
                ->modifyQueryUsing(fn(Builder $query) => $query->where('shipping_status', 'preparing')),
            'تم الشحن' => Tab::make()
                ->modifyQueryUsing(fn(Builder $query) => $query->where('shipping_status', 'shipped')),
            'تم التسليم' => Tab::make()
                ->modifyQueryUsing(fn(Builder $query) => $query->where('shipping_status', 'delivered')),
        ];
    }
}
