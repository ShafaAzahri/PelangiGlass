<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum InquiryStatus: string implements HasColor, HasIcon, HasLabel
{
    case NEW = 'new';
    case READ = 'read';
    case CONTACTED = 'contacted';
    case COMPLETED = 'completed';
    case SPAM = 'spam';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::NEW => 'Pesan Baru',
            self::READ => 'Sudah Dibaca',
            self::CONTACTED => 'Sudah Dihubungi',
            self::COMPLETED => 'Selesai',
            self::SPAM => 'Spam',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::NEW => 'danger',
            self::READ => 'gray',
            self::CONTACTED => 'info',
            self::COMPLETED => 'success',
            self::SPAM => 'gray',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::NEW => 'heroicon-m-envelope',
            self::READ => 'heroicon-m-envelope-open',
            self::CONTACTED => 'heroicon-m-chat-bubble-left-right',
            self::COMPLETED => 'heroicon-m-check-circle',
            self::SPAM => 'heroicon-m-no-symbol',
        };
    }
}
