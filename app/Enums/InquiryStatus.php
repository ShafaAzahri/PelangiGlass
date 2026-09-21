<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum InquiryStatus: string implements HasLabel, HasColor, HasIcon
{
    case NEW = 'new';
    case CONTACTED = 'contacted';
    case COMPLETED = 'completed';
    case SPAM = 'spam';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::NEW => 'Pesan Baru',
            self::CONTACTED => 'Sedang Dihubungi',
            self::COMPLETED => 'Selesai / Terlayani',
            self::SPAM => 'Spam',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::NEW => 'danger',
            self::CONTACTED => 'warning',
            self::COMPLETED => 'success',
            self::SPAM => 'gray',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::NEW => 'heroicon-m-sparkles',
            self::CONTACTED => 'heroicon-m-phone',
            self::COMPLETED => 'heroicon-m-check-badge',
            self::SPAM => 'heroicon-m-no-symbol',
        };
    }
}
