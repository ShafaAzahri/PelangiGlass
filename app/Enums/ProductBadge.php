<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum ProductBadge: string implements HasColor, HasLabel
{
    case TERLARIS = 'Terlaris';
    case PREMIUM = 'Premium';
    case BARU = 'Baru';
    case PROMO = 'Promo';

    public function getLabel(): ?string
    {
        return $this->value;
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::TERLARIS => 'danger',
            self::PREMIUM => 'warning',
            self::BARU => 'info',
            self::PROMO => 'success',
        };
    }
}
