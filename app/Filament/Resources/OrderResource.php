<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Models\Order;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\BulkActionGroup;
use Illuminate\Support\Facades\Auth;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Illuminate\Database\Eloquent\Builder;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-cube';
    protected static ?string $navigationLabel = 'Pedidos Digistore';

    protected function beforeSave(): void
    { 
        if (isset($this->data['merchant_name'])) {
            $this->data['merchant_name'] = Auth::user()->merchant_name;
        }
        $this->data['event'] = 'on_payment'; // Set the event to "on_payment" by default
    }

    public static function form(Form $form): Form
    {
        $isEditMode = $form->getState() && isset($form->getState()['id']); // Verifica se o pedido já foi criado

        return $form
            ->schema([
                Forms\Components\TextInput::make('order_number')
                    ->label('Order Number')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->disabled($isEditMode), // Desabilita se já foi criado

                Forms\Components\TextInput::make('amount')
                    ->label('Amount')
                    ->required()
                    ->numeric()
                    ->disabled($isEditMode), // Desabilita se já foi criado

                Forms\Components\TextInput::make('product_name')
                    ->label('Product Name')
                    ->required()
                    ->disabled($isEditMode), // Desabilita se já foi criado

                Forms\Components\TextInput::make('product_name_2')
                    ->label('Product Name 2')
                    ->required()
                    ->disabled($isEditMode), // Desabilita se já foi criado

                // O campo 'event' agora está fixo para 'on_payment'
                Forms\Components\Hidden::make('event')
                    ->default('on_payment') // Sempre define 'on_payment'
                    ->disabled() // Torna o campo invisível no formulário
                    ->required(),

                Forms\Components\TextInput::make('address_country')
                    ->label('Address Country')
                    ->required()
                    ->disabled($isEditMode), // Desabilita se já foi criado

                Forms\Components\TextInput::make('merchant_name')
                    ->label('Merchant Name')
                    ->required()
                    ->default(Auth::user()->merchant_name)
                    ->disabled(), // Desabilitado por padrão
                
                Forms\Components\TextInput::make('ipn_config_product_ids')
                    ->label('Linha de Produtos')
                    ->required()
                    ->disabled($isEditMode), // Desabilita se já foi criado

                Forms\Components\TextInput::make('product_id')
                    ->label('Product ID')
                    ->required()
                    ->numeric()
                    ->disabled($isEditMode), // Desabilita se já foi criado

                Forms\Components\TextInput::make('product_id_2')
                    ->label('Product ID 2')
                    ->required()
                    ->numeric()
                    ->disabled($isEditMode), // Desabilita se já foi criado
            ]);
    }

    public static function table(Table $table): Table
    {
        $currentMerchantName = Auth::user()->merchant_name;

        return $table
            ->query(Order::query()->where('merchant_name', $currentMerchantName)->orderBy('created_at', 'desc'))
            ->columns([
                TextColumn::make('merchant_name')
                    ->label('Merchant Name')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('amount')
                    ->label('Amount')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('product_name')
                    ->label('Product Name')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('product_name_2')
                    ->label('Product Name 2')
                    ->sortable(),

                // Substituindo a coluna 'event' com ícone por uma coluna com o 'order_id'
                TextColumn::make('order_id') // Agora está exibindo o 'order_id' (ID do pedido)
                    ->label('Order ID')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('created_at')
                    ->label('Created At')
                    ->sortable()
                    ->dateTime(),

                TextColumn::make('ipn_config_product_ids')
                    ->label('Linha de Produtos')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('product_id')
                    ->label('Product ID')
                    ->sortable(),

                TextColumn::make('product_id_2')
                    ->label('Product ID 2')
                    ->sortable(),
            ])
            ->filters([
                Filter::make('created_at')
                    ->label('Created At')
                    ->form([
                        DatePicker::make('created_from')
                            ->label('From')
                            ->default(now()->startOfMonth()),

                        DatePicker::make('created_until')
                            ->label('Until')
                            ->default(now()),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    }),

                Filter::make('order_id_or_product')
                    ->label('Order ID or Product Name')
                    ->form([
                        Select::make('order_id_or_product')
                            ->label('Selecione um pedido')
                            ->options(function () {
                                // Carrega todos os produtos relacionados ao merchant_name do usuário logado
                                $orders = Order::where('merchant_name', Auth::user()->merchant_name)
                                    ->get(['product_name', 'product_name_2']);
                                
                                // Cria um array de opções para o Select, garantindo que não haja valores nulos
                                $options = [];
                                foreach ($orders as $order) {
                                    // Adiciona as opções para product_name, product_name_2
                                    if ($order->product_name) {
                                        $options[$order->product_name] = "Produto: {$order->product_name}";
                                    }
                                    if ($order->product_name_2) {
                                        $options[$order->product_name_2] = "Produto 2: {$order->product_name_2}";
                                    }
                                }

                                return $options;
                            })
                            ->placeholder('Selecione o produto'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            $data['order_id_or_product'],
                            fn (Builder $query, $value): Builder => $query->where(function ($query) use ($value) {
                                // Filtra por product_name ou product_name_2
                                $query->where('product_name', 'like', "%$value%")
                                      ->orWhere('product_name_2', 'like', "%$value%");
                            }),
                        );
                    }),
            ])
            ->actions([
                EditAction::make()->url(fn($record) => url('/produtores/orders/produtores/orders')), // Redireciona para a URL dos pedidos
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/produtores/orders'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'), // Mantém a página de edição
        ];
    }

    public static function editOrder($order)
    {
        // Se o pedido já foi criado, redireciona para a página de listagem
        if ($order->exists) {
            return redirect()->route('filament.resources.orders.index');
        }

        return $order;
    }
}
