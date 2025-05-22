<?php

namespace App\Filament\Kitchen\Resources;

use App\Filament\Kitchen\Resources\DailyMealResource\Pages;
use App\Models\DailyMeal;
use App\Models\Employee;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Radio;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables;

class DailyMealResource extends Resource
{
    protected static ?string $model = DailyMeal::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';
    protected static ?string $navigationGroup = 'Daily Meal Order';
    protected static ?string $navigationLabel = 'Daily Meals';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Select::make('employee_id')
                ->label('Employee')
                ->options(Employee::all()->pluck('name', 'id'))
                ->searchable()
                ->required(),

            DatePicker::make('meal_date')
                ->label('Date')
                ->required(),

            Toggle::make('lunch')->label('Lunch'),

            Radio::make('status')
                ->label('Status')
                ->options([
                    'pending' => 'Pending',
                    'done' => 'Done',
                ])
                ->inline()
                ->default('pending')
                ->required(),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('employee.name')->label('Employee')->searchable(),
                TextColumn::make('employee.department')->label('Department')->sortable()->toggleable(),
                TextColumn::make('employee.organization')->label('Organization')->sortable()->toggleable(),

                TextColumn::make('meal_date')->label('Date')->date(),

                IconColumn::make('lunch')->label('Lunch')->boolean(),

                TextColumn::make('status')
                    ->badge()
                    ->colors([
                        'pending' => 'warning',
                        'done' => 'success',
                    ])
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                Filter::make('meal_date_range')
                    ->label('Date Range')
                    ->form([
                        DatePicker::make('from')->label('From'),
                        DatePicker::make('until')->label('Until'),
                    ])
                    ->columns(2)
                    ->query(function (Builder $query, array $data) {
                        return $query
                            ->when($data['from'], fn ($q, $date) => $q->whereDate('meal_date', '>=', $date))
                            ->when($data['until'], fn ($q, $date) => $q->whereDate('meal_date', '<=', $date));
                    }),

                SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'pending' => 'Pending',
                        'done' => 'Done',
                    ]),
            ])
            ->filtersLayout(FiltersLayout::AboveContent)
            ->filtersFormColumns(3)
            ->actions([
                Tables\Actions\Action::make('markAsCompleted')
                    ->label('Mark as Completed')
                    ->icon('heroicon-o-check-badge')
                    ->requiresConfirmation()
                    ->action(function (DailyMeal $record): void {
                        $record->update(['status' => 'done']);
                    })
                    ->visible(fn (DailyMeal $record) => $record->status !== 'done'),

            ])
            ->bulkActions([
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDailyMeals::route('/'),
            'edit' => Pages\EditDailyMeal::route('/{record}/edit'),
        ];
    }
}
