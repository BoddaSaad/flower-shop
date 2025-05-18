<?php

namespace App\Filament\Resources\BannerResource\Pages;

use App\Filament\Resources\BannerResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListBanners extends ListRecords
{
    protected static string $resource = BannerResource::class;

    protected static ?string $title = 'البنرات الإعلانية';

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->label('إضافة إعلان'),
        ];
    }
}
