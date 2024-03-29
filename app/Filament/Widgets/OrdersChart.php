<?php

namespace App\Filament\Widgets;

use App\Enums\OrderStatusEnum;
use App\Models\Order;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class OrdersChart extends ChartWidget
{
    protected static ?int $sort = 3;

    protected static ?string $heading = 'Orders';

    protected function getData(): array
    {
        $data = Order::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

//        dd($data);

        return [
            'datasets' => [
                [
                    'label' => 'Orders',
                    'data' => $data
                ]
            ],
            'labels' => OrderStatusEnum::cases()
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
