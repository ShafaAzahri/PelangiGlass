<?php

namespace App\Filament\Widgets;

use App\Enums\InquiryStatus;
use App\Models\Inquiry;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Promo;
use App\Models\Service;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $newInquiries = Inquiry::where('status', InquiryStatus::NEW)->count();
        $totalInquiries = Inquiry::count();
        $activeProducts = Product::where('is_active', true)->count();
        $totalCategories = ProductCategory::count();
        $activeServices = Service::where('is_active', true)->count();
        $activePromos = Promo::where('is_active', true)->count();

        return [
            Stat::make('Pesan Masuk (Leads)', $newInquiries.' Baru')
                ->description($totalInquiries.' total pesan masuk kontak')
                ->descriptionIcon('heroicon-m-envelope')
                ->chart([2, 4, 3, 5, 4, 6, $newInquiries > 0 ? 8 : 4])
                ->color('gray'),

            Stat::make('Katalog Produk Aktif', $activeProducts.' Produk')
                ->description($totalCategories.' kategori kaca mobil & film')
                ->descriptionIcon('heroicon-m-shopping-bag')
                ->chart([3, 5, 4, 6, 7, 8])
                ->color('gray'),

            Stat::make('Layanan & Servis', $activeServices.' Layanan')
                ->description('Pemasangan kaca & kaca film')
                ->descriptionIcon('heroicon-m-wrench-screwdriver')
                ->chart([2, 3, 5, 5, 6, 8])
                ->color('gray'),

            Stat::make('Promo & Penawaran', $activePromos.' Aktif')
                ->description('Diskon spesial tayang di website')
                ->descriptionIcon('heroicon-m-sparkles')
                ->chart([1, 2, 2, 3, 3, 3])
                ->color('gray'),
        ];
    }
}
