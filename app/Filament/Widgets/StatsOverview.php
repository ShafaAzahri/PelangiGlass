<?php

namespace App\Filament\Widgets;

use App\Enums\InquiryStatus;
use App\Models\Article;
use App\Models\Inquiry;
use App\Models\Product;
use App\Models\Service;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $newInquiries = Inquiry::where('status', InquiryStatus::NEW)->count();

        return [
            Stat::make('Pesan Masuk Baru', $newInquiries)
                ->description($newInquiries > 0 ? 'Perlu segera ditindaklanjuti via WA' : 'Semua pesan telah ditindaklanjuti')
                ->descriptionIcon('heroicon-m-inbox-arrow-down')
                ->color($newInquiries > 0 ? 'danger' : 'success'),

            Stat::make('Total Produk Aktif', Product::where('is_active', true)->count())
                ->description('Kaca Mobil, Kaca Film & Aksesoris')
                ->descriptionIcon('heroicon-m-shopping-bag')
                ->color('primary'),

            Stat::make('Layanan & Servis', Service::where('is_active', true)->count())
                ->description('Paket ganti kaca & tolak panas')
                ->descriptionIcon('heroicon-m-wrench-screwdriver')
                ->color('info'),

            Stat::make('Artikel & Edukasi', Article::count())
                ->description('Tips perawatan & keselamatan')
                ->descriptionIcon('heroicon-m-document-text')
                ->color('warning'),
        ];
    }
}
