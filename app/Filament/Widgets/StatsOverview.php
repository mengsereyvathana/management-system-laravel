<?php

namespace App\Filament\Widgets;

use App\Enums\OrderStatusEnum;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{

    protected static ?int $sort = 2;

    protected static ?string $pollingInterval = '15s';

    protected static bool $isLazy = true;
    protected function getStats(): array
    {
        return [
            Stat::make('Total Customer',Customer::count())
                ->description('increase in customers')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success')
                ->chart([7,3,4,5,6,3,5,3]),
             Stat::make('Total Products', Product::count())
                 ->description('Total products in app'),
//                 ->descriptionIcon('heroicon-m-arrow-trending-down')
//                 ->color('danger')
//                 ->chart([7, 3, 4, 5, 6, 3, 5, 3]),
            Stat::make('Pending Orders', Order::where('status', OrderStatusEnum::PENDING->value)->count())
                ->description('Total pending orders')
//                ->descriptionIcon('heroicon-m-arrow-trending-down')
//                ->color('danger')
//                ->chart([7, 3, 4, 5, 6, 3, 5, 3]),
        ];
    }
}
