<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KeysResource\Pages;
use App\Models\Keys;
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

class KeysResource extends Resource
{
    protected static ?string $model = Keys::class;

    protected static ?string $navigationIcon = 'heroicon-o-key';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('shop_slug')
                    ->label('Shop Slug')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->default(fn () => Auth::user()->shop_slug)  // Puxa o shop_slug do usuário logado
                    ->afterStateUpdated(function (callable $set, $state) {
                        // Atualiza o campo shop_slug no usuário logado
                        $user = Auth::user();
                        if ($user) {
                            $user->shop_slug = $state;
                            $user->save();  // Salva no banco de dados
                        }
                    }),

                Forms\Components\TextInput::make('authorization')
                    ->label('Authorization(TOKEN CartPanda')
                    ->required()
                    ->maxLength(255)
                    ->default(fn () => Auth::user()->authorization)  // Puxa o authorization do usuário logado
                    ->afterStateUpdated(function (callable $set, $state) {
                        // Quando o valor de authorization for alterado, atualiza no usuário logado
                        $user = Auth::user();
                        if ($user) {
                            $user->authorization = $state;  // Atualiza o campo authorization
                            $user->save();  // Salva no banco de dados

                            // Atualiza o campo authorization no modelo Keys
                            $key = Keys::where('user_id', $user->id)->first();
                            if ($key) {
                                $key->authorization = $state;  // Atualiza o campo authorization no Keys
                                $key->save();  // Salva no banco de dados
                            }
                        }
                    }),

                Forms\Components\TextInput::make('token')
                    ->label('Token')
                    ->required()
                    ->maxLength(255)
                    ->default(fn () => Auth::user()->token)  // Puxa o token do usuário logado
                    ->afterStateUpdated(function (callable $set, $state) {
                        // Quando o valor de token for alterado, atualiza no usuário logado
                        $user = Auth::user();
                        if ($user) {
                            $user->token = $state;  // Atualiza o campo token no usuário
                            $user->save();  // Salva no banco de dados
                        }
                    }),

                Forms\Components\TextInput::make('x_api_key')
                    ->label('X-API-KEY')
                    ->required()
                    ->maxLength(255),

                // Campo merchant_name com valor default baseado no usuário logado
                Forms\Components\TextInput::make('merchant_name')
                    ->label('Merchant Name')
                    ->nullable()
                    ->maxLength(255)
                    ->default(fn () => Auth::user()->merchant_name)
                    ->disabled(), // Torna o campo readonly (não editável)

                // Opcional: Adicione um campo para garantir a vinculação do usuário logado ao registro de Keys
                Forms\Components\Hidden::make('user_id')
                    ->default(fn () => Auth::id()) // Associa o usuário logado automaticamente
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(Keys::query()->where('user_id', Auth::id())) // Filtra as chaves pelo ID do usuário logado
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('shop_slug')
                    ->label('Shop Slug')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('authorization')
                    ->label('Authorization')
                    ->limit(50),

                TextColumn::make('token')
                    ->label('Token')
                    ->limit(50),

                TextColumn::make('x_api_key')
                    ->label('X-API-KEY')
                    ->limit(50),

                // Coluna para merchant_name
                TextColumn::make('merchant_name')
                    ->label('Merchant Name')
                    ->limit(50)
                    ->sortable(),

                // Adicionando a coluna que exibe o nome do usuário associado
                TextColumn::make('user.name')  // Exibe o nome do usuário
                    ->label('User Name')
                    ->sortable(),

                // Exemplo para exibir o email do usuário
                TextColumn::make('user.email')  // Exibe o email do usuário
                    ->label('User Email')
                    ->limit(100),

                // Exemplo para exibir o telefone do usuário
                TextColumn::make('user.phone')  // Exibe o telefone do usuário (ajuste conforme necessário)
                    ->label('User Phone')
                    ->limit(20),

                // Aqui você pode adicionar mais colunas conforme os campos que existem na tabela `users`
                TextColumn::make('created_at')
                    ->label('Criado em')
                    ->sortable()
                    ->dateTime(),
            ])
            ->filters([
                // Adicione filtros personalizados se necessário
            ])
            ->actions([
                EditAction::make(),
            ])
            ->bulkActions([ // Aqui estava o erro de sintaxe
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]); // Agora está fechado corretamente
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListKeys::route('/'),
            'create' => Pages\CreateKeys::route('/create'),
            'edit' => Pages\EditKeys::route('/{record}/edit'),
        ];
    }
}
