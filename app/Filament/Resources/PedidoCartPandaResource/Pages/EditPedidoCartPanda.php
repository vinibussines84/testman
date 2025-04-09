<?php

namespace App\Filament\Resources\PedidoCartPandaResource\Pages;

use App\Filament\Resources\PedidoCartPandaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPedidoCartPanda extends EditRecord
{
    protected static string $resource = PedidoCartPandaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
