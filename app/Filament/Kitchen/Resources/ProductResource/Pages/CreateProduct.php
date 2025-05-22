<?php

namespace App\Filament\Kitchen\Resources\ProductResource\Pages;

use App\Filament\Kitchen\Resources\ProductResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateProduct extends CreateRecord
{
    protected static string $resource = ProductResource::class;
}
