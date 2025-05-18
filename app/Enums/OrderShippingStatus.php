<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum OrderShippingStatus: string implements HasColor, HasIcon, HasLabel
{
    case Pending = 'pending';

    case Preparing = 'preparing';

    case Shipped = 'shipped';

    case Delivered = 'delivered';

    public function getLabel(): string
    {
        return match ($this) {
            self::Pending => 'قيد الانتظار',
            self::Preparing => 'قيد التحضير',
            self::Shipped => 'تم الشحن',
            self::Delivered => 'تم التسليم',
        };
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::Pending => 'info',
            self::Preparing => 'warning',
            self::Shipped, self::Delivered => 'success',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::Pending => 'heroicon-m-sparkles',
            self::Preparing => 'heroicon-m-arrow-path',
            self::Shipped => 'heroicon-m-truck',
            self::Delivered => 'heroicon-m-check-badge',
        };
    }
}
