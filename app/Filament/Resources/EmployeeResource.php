<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EmployeeResource\Pages;
use App\Models\Employee;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;

class EmployeeResource extends Resource
{
    protected static ?string $model = Employee::class;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';
    protected static ?string $navigationGroup = 'Employees Management';
    protected static ?string $navigationLabel = 'Employees';
    protected static ?string $modelLabel = 'Employee';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form->schema([
            TextInput::make('employees_id')
                ->label('Employee ID')
                ->required()
                ->unique(ignoreRecord: true),
            TextInput::make('name')->required(),
            TextInput::make('phone_no')->required(),
            TextInput::make('position'),
            TextInput::make('organization'),
            TextInput::make('department'),
        ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                TextColumn::make('employees_id')->label('ID')->searchable(),
                TextColumn::make('name')->searchable(),
                TextColumn::make('phone_no')->searchable(),
                TextColumn::make('position'),
                TextColumn::make('organization'),
                TextColumn::make('department'),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEmployees::route('/'),
            'create' => Pages\CreateEmployee::route('/create'),
            'edit' => Pages\EditEmployee::route('/{record}/edit'),
        ];
    }
}
