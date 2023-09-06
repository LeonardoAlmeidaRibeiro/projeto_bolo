<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use Closure;
use Filament\Forms;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Hash;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {

        return $form
            ->schema([
                Fieldset::make('Dados do Pedidos')->schema([
                    Select::make('customer_id')
                        ->label('Cliente')
                        ->reactive(true)
                        ->options(Customer::all()->pluck('name', 'id'))
                        ->searchable(),
                    Select::make('status')
                        ->label('Status')
                        ->options([
                            'new' => 'Novo',
                            'processing' => 'Processando',
                            'shipped' => 'Enviado',
                            'delivered' => 'Entregue',
                            'cancelled' => 'Cancelado',
                        ])
                        ->default('new'),
                    Select::make('payment')
                        ->label('Pagamento')
                        ->options([
                            'pix' => 'Pix',
                            'cash' => 'Dinheiro',
                            'card' => 'Cartão',
                        ]),
                    Select::make('address_id')
                        ->label('Endereço')
                        ->options(function (Closure $get) {
                            if (!$get('customer_id')) {
                                return [];
                            }
                            $customer = Customer::find($get('customer_id'));
                            return $customer->address->pluck('street', 'id');
                        }),
                    TextInput::make('total_price')
                        ->label('Preço Final')
                        ->default(0)
                        ->disabled()
                ]),
                Section::make('Produtos')
                    ->schema([
                        Repeater::make('items')
                            ->relationship()
                            ->schema(
                                [
                                    Select::make('product_id')
                                        ->label('Produtos')
                                        ->reactive()
                                        ->required()
                                        ->options(
                                            Product::all()->pluck('name', 'id')
                                        )
                                        ->searchable(),
                                    TextInput::make('quantity')
                                        ->integer()
                                        ->default(0)
                                        ->reactive()
                                        ->required()
                                        ->afterStateUpdated(fn ($state, callable $set, Closure $get) => $set('subt_total', $state * Product::find($get('product_id'))?->price ?? 0))
                                        ->label('Quantidade'),
                                    TextInput::make('subt_total')
                                        ->numeric()
                                        ->reactive()
                                        ->required()
                                        ->disabled()
                                        ->label('Sub Total'),
                                ],
                            )->columns(3),


                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('customer.name')
                    ->label('Nome')
                    ->sortable()
                    ->searchable(),
                BadgeColumn::make('status')
                    ->colors([
                        'danger' => 'cancelled',
                        'warning' => 'processing',
                        'waerning' => fn ($state) => in_array($state, ['delivered', 'shipped', 'new']),
                    ]),
                    TextColumn::make('total_price')->label('Valor Total')->money('brl'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'view' => Pages\ViewOrder::route('/{record}'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
