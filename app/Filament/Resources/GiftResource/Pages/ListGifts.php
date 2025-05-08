<?php

namespace App\Filament\Resources\GiftResource\Pages;

use App\Filament\Resources\GiftResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListGifts extends ListRecords
{
    protected static string $resource = GiftResource::class;

    protected static ?string $title = 'الهدايا';

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->label('إضافة هدية'),
        ];
    }
}
