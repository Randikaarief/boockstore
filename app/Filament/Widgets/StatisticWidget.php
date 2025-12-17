<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatisticWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Pendapatan', Order::where('status', 'shipped')->sum('total_price'))
                ->description('Semua pendapatan dari pesanan')
                ->descriptionIcon('heroicon-m-currency-dollar')
                ->color('primary'),
            Stat::make('Total Pesanan', Order::count())
                ->description('Semua pesanan yang dibuat')
                ->descriptionIcon('heroicon-m-shopping-cart')
                ->color('secondary'),
            Stat::make('Total Buku Terjual', Order::where('status', 'shipped')->withCount('orderItems')->get()->sum('order_items_count'))
                ->description('Semua buku yang telah terjual')
                ->descriptionIcon('heroicon-m-book-open')
                ->color('success'),
        ];
    }
}
