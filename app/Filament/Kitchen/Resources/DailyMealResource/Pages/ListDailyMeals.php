<?php

namespace App\Filament\Kitchen\Resources\DailyMealResource\Pages;

use App\Filament\Kitchen\Resources\DailyMealResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDailyMeals extends ListRecords
{
    protected static string $resource = DailyMealResource::class;

    protected function getHeaderActions(): array
    {
        return [
        ];
    }
}
