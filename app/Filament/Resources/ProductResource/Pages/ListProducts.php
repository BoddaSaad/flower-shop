<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListProducts extends ListRecords
{
    protected static string $resource = ProductResource::class;

    protected static ?string $title = 'المنتجات';

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->label('إضافة منتج'),
        ];
    }
}
