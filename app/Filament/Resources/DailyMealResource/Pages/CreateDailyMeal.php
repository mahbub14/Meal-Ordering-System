<?php

namespace App\Filament\Resources\DailyMealResource\Pages;

use App\Filament\Resources\DailyMealResource;
use App\Models\DailyMeal;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateDailyMeal extends CreateRecord
{
    protected static string $resource = DailyMealResource::class;

    /**
     * Override the default create behavior to prevent duplicate meal orders.
     */
    protected function handleRecordCreation(array $data): Model
    {
        // Check if the record already exists
        $exists = DailyMeal::where('employee_id', $data['employee_id'])
            ->where('meal_date', $data['meal_date'])
            ->exists();

        if ($exists) {
            // Show warning notification
            $this->notify('danger', 'A meal order already exists for this employee on this date.');

            // Return existing record to avoid crash
            return DailyMeal::where('employee_id', $data['employee_id'])
                ->where('meal_date', $data['meal_date'])
                ->first();
        }

        // If not exists, create a new one
        return DailyMeal::create([
            'employee_id' => $data['employee_id'],
            'meal_date'   => $data['meal_date'],
            'breakfast'   => $data['breakfast'] ?? false,
            'lunch'       => $data['lunch'] ?? false,
            'dinner'      => $data['dinner'] ?? false,
            'status'      => $data['status'],
        ]);
        
    }
      protected function getRedirectUrl(): string 
    { 
        return $this->getResource()::getUrl('index'); 
    } 
}
