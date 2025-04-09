<?php

namespace App\Filament\Resources\UltimosPedidosResource\Widgets;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use App\Models\Order; // Usando a classe Order
use Illuminate\Support\Facades\Auth;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;

class Pedidos extends BaseWidget
{
    public function table(Table $table): Table
    {
        $currentMerchantName = Auth::user()->merchant_name; // Obtém o nome do comerciante do usuário logado

        return $table
            ->query(
                fn () => Order::where('merchant_name', $currentMerchantName)
                    ->latest() // Mostra os pedidos mais recentes
                    ->take(3) // Limita a consulta aos 3 últimos pedidos
            )
            ->columns([
                TextColumn::make('order_id') // Coluna com o ID do pedido
                    ->label('Order ID')
                    ->sortable()
                    ->searchable(), // Torna a coluna 'order_id' pesquisável

                TextColumn::make('product_name') // Nome do produto
                    ->label('Product Name')
                    ->sortable()
                    ->searchable(), // Torna a coluna 'product_name' pesquisável
IconColumn::make('status') // Status do pedido
                    ->label('Status')
                    ->sortable()
                    ->searchable()
                    ->getStateUsing(fn (Order $record) => 'Completed') // Sempre define o status como "Completed"
                    ->trueIcon('') // Exibe o ícone de "check" quando o status é "Completed"
                    ->falseIcon('') // Exibe o ícone de "x" caso não seja "Completed"
                    ->color('success'), // Marca o status com cor verde (para "Completed")

                TextColumn::make('amount') // Quantia do pedido
                    ->label('Amount')
                    ->sortable()
                    ->searchable(), // Torna a coluna 'amount' pesquisável

                TextColumn::make('created_at') // Data de criação do pedido
                    ->label('Created At')
                    ->sortable()
                    ->dateTime()
                    ->searchable(), // Torna a coluna 'created_at' pesquisável

                // Usando IconColumn para mostrar ícone no lugar de 'Completed'
                IconColumn::make('status') // Status do pedido
                    ->label('Status')
                    ->sortable()
                    ->searchable()
                    ->getStateUsing(fn (Order $record) => 'Completed') // Sempre define o status como "Completed"
                    ->trueIcon('heroicon-o-check-circle') // Exibe o ícone de "check" quando o status é "Completed"
                    ->falseIcon('heroicon-o-check-circle') // Exibe o ícone de "x" caso não seja "Completed"
                    ->color('success'), // Marca o status com cor verde (para "Completed")

                // Adicionando o campo 'is_featured' com IconColumn (boolean)
                IconColumn::make('is_featured')
                    ->label('Featured')
                    ->boolean() // Exibe ícone para status booleano
                    ->trueIcon('heroicon-o-check')
                    ->falseIcon('heroicon-o-x'),
            ]);
    }
}
