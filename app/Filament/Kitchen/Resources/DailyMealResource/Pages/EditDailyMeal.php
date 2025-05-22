<?php

namespace App\Filament\Kitchen\Resources\DailyMealResource\Pages;

use App\Filament\Kitchen\Resources\DailyMealResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDailyMeal extends EditRecord
{
    protected static string $resource = DailyMealResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
      protected function getRedirectUrl(): string 
    { 
        return $this->getResource()::getUrl('index'); 
    } 
}
