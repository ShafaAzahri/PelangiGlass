<?php

namespace App\Filament\Resources\Articles\Pages;

use App\Filament\Resources\Articles\ArticleResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListArticles extends ListRecords
{
    protected static string $resource = ArticleResource::class;

    protected ?string $heading = 'Artikel & Tips Perawatan Kaca';

    public function getSubheading(): ?string
    {
        return 'Kelola konten publikasi, panduan perawatan kaca mobil, tips tolak panas, dan keselamatan berkendara.';
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->label('Tulis Artikel Baru'),
        ];
    }
}
