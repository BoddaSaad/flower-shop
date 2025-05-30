<?php

namespace App\Filament\Resources\GiftResource\Pages;

use App\Filament\Resources\GiftResource;
use Filament\Resources\Pages\CreateRecord;

class CreateGift extends CreateRecord
{
    protected static string $resource = GiftResource::class;

    protected static ?string $title = 'إضافة هدية';

    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}
