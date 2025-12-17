<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Widgets\ChartWidget;
use Carbon\Carbon;

class OrdersChart extends ChartWidget
{
    protected static ?string $heading = 'Grafik Pesanan';

    protected function getOptions(): array
    {
        return [
            'scales' => [
                'x' => [
                    'grid' => [
                        'display' => false,
                    ],
                ],
            ],
        ];
    }

    protected function getData(): array
    {
        $data = Order::select('created_at')
            ->whereBetween('created_at', [Carbon::now()->subDays(7), Carbon::now()])
            ->get()
            ->groupBy(function ($date) {
                return Carbon::parse($date->created_at)->format('D'); // grouping by day name
            });

        $labels = [];
        $values = [];
        $dayMap = [
            'Mon' => 'Sen',
            'Tue' => 'Sel',
            'Wed' => 'Rab',
            'Thu' => 'Kam',
            'Fri' => 'Jum',
            'Sat' => 'Sab',
            'Sun' => 'Min',
        ];

        // Loop through the last 7 days to ensure all days are present
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $day = $date->format('D');
            $labels[] = $dayMap[$day];
            $values[] = $data->has($day) ? $data[$day]->count() : 0;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Pesanan per hari',
                    'data' => $values,
                    'backgroundColor' => 'rgba(54, 162, 235, 0.2)',
                    'borderColor' => 'rgba(54, 162, 235, 1)',
                    'borderWidth' => 1,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}