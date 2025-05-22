<?php

namespace App\Filament\Kitchen\Resources\ProductResource\Widgets;

use App\Models\Product;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class PurchaseStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Purchase Today (BDT)', '৳' . number_format(Product::whereDate('created_at', now()->toDateString())->sum('price'), 2)),

            Stat::make('Purchases Last 7 Days (BDT)', '৳' . number_format(Product::where('created_at', '>=', now()->subDays(7)->startOfDay())->sum('price'), 2)),

            Stat::make('Purchases Last 30 Days (BDT)', '৳' . number_format(Product::where('created_at', '>=', now()->subDays(30)->startOfDay())->sum('price'), 2)),
        ];
    }
}
