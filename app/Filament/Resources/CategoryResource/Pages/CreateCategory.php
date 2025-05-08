<?php

namespace App\Filament\Resources\CategoryResource\Pages;

use App\Filament\Resources\CategoryResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCategory extends CreateRecord
{
    protected static string $resource = CategoryResource::class;

    protected static ?string $title = 'إضافة قسم';

    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}
