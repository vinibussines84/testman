<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PedidoCartPandaResource\Pages;
use App\Models\PedidoCartPanda;
use App\Models\Keys;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Form;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\BulkActionGroup;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PedidoCartPandaResource extends Resource
{
    protected static ?string $model = PedidoCartPanda::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-magnifying-glass';

    protected static ?string $navigationLabel = 'Pedidos CartPanda';

    // Função para buscar os pedidos da API CartPanda
    public static function getOrdersFromCartPanda($shopSlug)
    {
        Log::info("Iniciando a busca de pedidos para o shop_slug: {$shopSlug}");

        $key = Keys::where('shop_slug', $shopSlug)->first();

        if (!$key) {
            Log::error("Shop slug não encontrado: {$shopSlug}");
            return ['error' => 'Shop slug not found'];
        }

        if ($shopSlug === 'oticasvibe') {
            $key = (object)[
                'authorization' => 'DTtgXmFC2S07iLS5Apjjk2Xkvauo2ZyH539KFxADJp2A5nCuP3V8uBwv5KNy'
            ];
        }

        Log::info("Authorization token: {$key->authorization}");

        // Fazendo a requisição para a API CartPanda
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $key->authorization,
        ])->get("https://accounts.cartpanda.com/api/v3/{$shopSlug}/orders");

        if ($response->successful()) {
            Log::info("Pedidos encontrados com sucesso para o shop_slug: {$shopSlug}");
            return $response->json();  // Retorna os dados dos pedidos em formato de array
        }

        Log::error("Erro ao buscar pedidos para o shop_slug: {$shopSlug} - Status: {$response->status()} - Mensagem: {$response->body()}");
        return ['error' => 'Failed to fetch orders'];
    }

    // Query personalizada para trazer os dados dos pedidos da API
    public static function query()
    {
        // Buscando os pedidos da API
        $orders = self::getOrdersFromCartPanda('oticasvibe');

        if (isset($orders['error'])) {
            // Se houver erro na API, retornamos uma coleção vazia
            return collect(); // Retorna uma coleção vazia caso haja erro
        }

        // Convertendo os dados para uma coleção, manipulando os dados
        return collect($orders)->map(function ($order) {
            return [
                'order_number' => $order['order_number'] ?? 'N/A',
                'total_amount' => $order['total_amount'] ?? 0,
                'status' => $order['status'] ?? 'pending',
                'created_at' => $order['created_at'] ?? now(),
            ];
        });
    }

    // Tabela para listar os pedidos CartPanda
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('order_number')
                    ->label('Order Number')
                    ->sortable()
                    ->searchable(),

                // Exibindo o campo total_amount com formatação de moeda
                TextColumn::make('total_amount')
                    ->label('Total Amount')
                    ->sortable()
                    ->money('USD'),

                // Exibindo o status com ícone e cor dependendo do valor
                IconColumn::make('status')
                    ->icon(fn ($state) => 
                        $state === 'completed' 
                            ? 'heroicon-o-check-circle' 
                            : ($state === 'pending' 
                                ? 'heroicon-o-exclamation-circle' 
                                : 'heroicon-o-truck')
                    )
                    ->color(fn ($state) => 
                        $state === 'completed' 
                            ? 'success' 
                            : ($state === 'pending' 
                                ? 'warning' 
                                : 'info')
                    )
                    ->label('')
                    ->sortable(),

                // Exibindo a data de criação do pedido
                TextColumn::make('created_at')
                    ->label('Created At')
                    ->sortable()
                    ->dateTime(),
            ])
            ->query(function () {
                return self::query(); // Chamando a função `query()` para passar os dados da API
            })
            ->filters([
                // Adicionar filtros personalizados se necessário
            ])
            ->actions([
                EditAction::make(),  // Ação de editar na tabela
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),  // Ação de excluir em massa
                ]),
            ]);
    }

    // Configuração das páginas (Listar, Criar, Editar)
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPedidoCartPandas::route('/'),
            'create' => Pages\CreatePedidoCartPanda::route('/create'),
            'edit' => Pages\EditPedidoCartPanda::route('/{record}/edit'),
        ];
    }
}
