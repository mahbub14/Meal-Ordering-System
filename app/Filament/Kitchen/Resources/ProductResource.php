<?php

namespace App\Filament\Kitchen\Resources;

use App\Filament\Kitchen\Resources\ProductResource\Pages;
use App\Models\Product;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Kitchen Management';
    protected static ?string $navigationLabel = 'Products';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Product Name')
                    ->required()
                    ->maxLength(255),

                TextInput::make('qnt')
                    ->label('Quantity')
                    ->required()
                    ->numeric()
                    ->minValue(0)
                    ->reactive()
                    ->afterStateUpdated(function ($set, $state, $get) {
                        $set('price', $state * floatval($get('unit_price')));
                    }),

                Select::make('unit')
                    ->label('Unit')
                    ->options([
                        'kg' => 'Kilogram (kg)',
                        'piece' => 'Piece',
                        'litre' => 'Litre',
                        'gm' => 'Gram (gm)',
                    ])
                    ->required(),

                TextInput::make('unit_price')
                    ->label('Unit Price')
                    ->required()
                    ->numeric()
                    ->minValue(0)
                    ->step(0.01)
                    ->reactive()
                    ->afterStateUpdated(function ($set, $state, $get) {
                        $set('price', floatval($get('qnt')) * $state);
                    }),

                TextInput::make('price')
                    ->label('Total Price')
                    ->numeric()
                    ->disabled()
                    ->dehydrated()
                    ->minValue(0)
                    ->step(0.01),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Product Name')
                    ->searchable(),

                TextColumn::make('qnt')
                    ->label('Quantity'),

                TextColumn::make('unit')
                    ->label('Unit'),

                TextColumn::make('unit_price')
                    ->label('Unit Price')
                    ->formatStateUsing(fn ($state) => number_format($state, 2) . ' BDT'),

                TextColumn::make('price')
                    ->label('Total Price')
                    ->formatStateUsing(fn ($state) => number_format($state, 2) . ' BDT')
                    ->summarize(
                        Tables\Columns\Summarizers\Sum::make()
                            ->label('Total Price')
                            ->formatStateUsing(fn ($state) => number_format($state, 2) . ' BDT')
                    ),

                TextColumn::make('created_at')
                    ->label('Purchased Date')
                    ->date(),
            ])
            ->filters([
                Filter::make('created_at')
                    ->form([
                        DatePicker::make('from')->label('From Date'),
                        DatePicker::make('until')->label('To Date'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when($data['from'], fn ($q) => $q->whereDate('created_at', '>=', $data['from']))
                            ->when($data['until'], fn ($q) => $q->whereDate('created_at', '<=', $data['until']));
                    }),
            ], layout: Tables\Enums\FiltersLayout::AboveContentCollapsible)
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkAction::make('exportPdf')
                    ->label('Export PDF')
                    ->form([
                        DatePicker::make('fromDate')->label('From Date'),
                        DatePicker::make('toDate')->label('To Date'),
                    ])
                    ->action(function (array $data, \Illuminate\Support\Collection $records) {
                        $filteredRecords = $records;

                        if (!empty($data['fromDate'])) {
                            $filteredRecords = $filteredRecords->filter(
                                fn ($record) => $record->created_at->gte($data['fromDate'])
                            );
                        }

                        if (!empty($data['toDate'])) {
                            $filteredRecords = $filteredRecords->filter(
                                fn ($record) => $record->created_at->lte($data['toDate'])
                            );
                        }

                       $products = $filteredRecords->map(function ($product) {
    return [
        'name' => iconv('UTF-8', 'ASCII//IGNORE', $product->name),
        'qnt' => $product->qnt,
        'unit' => iconv('UTF-8', 'ASCII//IGNORE', $product->unit),
        'unit_price' => $product->unit_price,
        'price' => $product->price,
        'created_at' => $product->created_at->format('Y-m-d'),
    ];
})->toArray();

                        $pdf = Pdf::loadView('filament.kitchen.products.report-pdf', [
                            'products' => $products,
                            'fromDate' => !empty($data['fromDate']) ? Carbon::parse($data['fromDate'])->format('Y-m-d') : null,
                            'toDate' => !empty($data['toDate']) ? Carbon::parse($data['toDate'])->format('Y-m-d') : null,
                        ]);

                        return response()->streamDownload(function () use ($pdf) {
                            echo $pdf->stream();
                        }, 'products_report_' . now()->format('Y_m_d_H_i_s') . '.pdf');
                    }),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }



}
