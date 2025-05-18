<?php

namespace App\Filament\Resources\BannerResource\Pages;

use App\Filament\Resources\BannerResource;
use Filament\Resources\Pages\CreateRecord;

class CreateBanner extends CreateRecord
{
    protected static string $resource = BannerResource::class;

    protected static ?string $title = 'إضافة إعلان';

    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}
