<?php

namespace App\Filament\Kitchen\Resources\ProductResource\Pages;

use App\Filament\Kitchen\Resources\ProductResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProducts extends ListRecords
{
    protected static string $resource = ProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
    protected function getHeaderWidgets(): array
{
    return [
        \App\Filament\Kitchen\Resources\ProductResource\Widgets\PurchaseStatsOverview::class,
    ];
}

}
