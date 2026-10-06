<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum ServiceBadge: string implements HasColor, HasLabel
{
    case TERLARIS = 'Terlaris';
    case BERGARANSI = 'Bergaransi';
    case HEMAT = 'Hemat';
    case PREMIUM = 'Premium';
    case BARU = 'Baru';

    public function getLabel(): ?string
    {
        return $this->value;
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::TERLARIS => 'danger',
            self::BERGARANSI => 'primary',
            self::HEMAT => 'success',
            self::PREMIUM => 'warning',
            self::BARU => 'info',
        };
    }
}
