<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class ShippingPrice extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-truck';

    protected static string $view = 'filament.pages.shipping-price';

    protected static ?int $navigationSort = 6;

    public static function getNavigationLabel(): string
    {
        return 'سعر الشحن';
    }

    protected static ?string $title = 'سعر الشحن';
}
