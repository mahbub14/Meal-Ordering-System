<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DailyMealResource\Pages;
use App\Models\DailyMeal;
use App\Models\Employee;
use Closure;
use Filament\Forms\Form;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;

class DailyMealResource extends Resource
{
    protected static ?string $model = DailyMeal::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';
    protected static ?string $navigationGroup = 'Daily Meal Order';
    protected static ?string $navigationLabel = 'Daily Meals';
    protected static ?string $modelLabel = 'Meal Order';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Select::make('employee_id')
                ->label('Employee')
                ->options(Employee::all()->pluck('name', 'id'))
                ->searchable()
                ->required()
                ->reactive()
                ->afterStateUpdated(function ($state, callable $set) {
                    $employee = Employee::find($state);
                    if ($employee) {
                        $set('organization', $employee->organization);
                        $set('department', $employee->department);
                    } else {
                        $set('organization', null);
                        $set('department', null);
                    }
                }),

            TextInput::make('organization')
                ->label('Organization')
                ->disabled()
                ->dehydrated(false),

            TextInput::make('department')
                ->label('Department')
                ->disabled()
                ->dehydrated(false),

            DatePicker::make('meal_date')
                ->label('Date')
                ->required()
                ->rule(function (callable $get) {
                    return function (string $attribute, $value, Closure $fail) use ($get) {
                        $employeeId = $get('employee_id');
                        $recordId = request()->route('record')?->id ?? null;

                        if (!$employeeId || !$value) {
                            return;
                        }

                        $exists = DailyMeal::where('employee_id', $employeeId)
                            ->where('meal_date', $value)
                            ->when($recordId, fn ($q) => $q->where('id', '!=', $recordId))
                            ->exists();

                        if ($exists) {
                            $fail('This employee already has a meal order for the selected date.');
                        }
                    };
                }),

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
                TextColumn::make('employee.name')
                    ->label('Employee')
                    ->searchable(),

                TextColumn::make('meal_date')->label('Date')->date(),

                IconColumn::make('lunch')->label('Lunch')->boolean(),

                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'done' => 'success',
                        'pending' => 'warning',
                    }),
                    TextColumn::make('employee.organization')
    ->label('Organization')
    ->searchable(),


TextColumn::make('employee.department')
    ->label('Department')
    ->searchable()            ])
            ->filters([
                Filter::make('meal_date_range')
                    ->label('Date Range')
                    ->form([
                        DatePicker::make('from')->label('From'),
                        DatePicker::make('until')->label('Until'),
                    ])
                    ->columns(2)
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['from'] ?? null, fn ($q, $date) => $q->whereDate('meal_date', '>=', $date))
                            ->when($data['until'] ?? null, fn ($q, $date) => $q->whereDate('meal_date', '<=', $date));
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
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                DeleteBulkAction::make(),
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
