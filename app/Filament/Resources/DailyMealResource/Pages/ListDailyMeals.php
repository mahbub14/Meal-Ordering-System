<?php

namespace App\Filament\Resources\DailyMealResource\Pages;

use App\Filament\Resources\DailyMealResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDailyMeals extends ListRecords
{
    protected static string $resource = DailyMealResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
