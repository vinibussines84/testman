<?php

namespace App\Filament\Resources\PedidoCartPandaResource\Pages;

use App\Filament\Resources\PedidoCartPandaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPedidoCartPandas extends ListRecords
{
    protected static string $resource = PedidoCartPandaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
