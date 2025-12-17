<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Widgets\ChartWidget;
use Carbon\Carbon;

class NewUsersChart extends ChartWidget
{
    protected static ?string $heading = 'Grafik Pengguna Baru';
    protected static string $color = 'info';

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
        $data = User::select('created_at')
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

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $day = $date->format('D');
            $labels[] = $dayMap[$day];
            $values[] = $data->has($day) ? $data[$day]->count() : 0;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Pengguna baru per hari',
                    'data' => $values,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}