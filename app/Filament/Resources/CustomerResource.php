<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerResource\Pages;
use App\Filament\Resources\CustomerResource\RelationManagers;
use App\Models\Customer;
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
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Hash;

class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Fieldset::make('Dados Pessoais')->schema([
                    Forms\Components\TextInput::make('name')->label('Nome')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('cpf')->label('CPF')
                        ->required()
                        ->minLength(11)
                        ->mask(fn (TextInput\Mask $mask) => $mask->pattern('000.000.000-00')),
                    Forms\Components\TextInput::make('phone')->label('Telefone')
                        ->tel()
                        ->required()
                        ->mask(fn (TextInput\Mask $mask) => $mask->pattern('(00) 0 0000-0000 ')),
                    Forms\Components\TextInput::make('email')->label('E-Mail')
                        ->email()
                        ->required()
                        ->maxLength(255),
                    TextInput::make('password')
                        ->password()
                        ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                        ->dehydrated(fn ($state) => filled($state))
                        ->required(fn (string $context): bool => $context === 'create')
                        ->disabled(fn (string $context): bool => $context === 'edit')
                ]), Section::make('Endereço do Cliente')
                    ->schema([
                        Repeater::make('address')
                        ->relationship()
                            ->schema([
                                TextInput::make('street')->required()->label('Endereço'),
                                TextInput::make('neighborhood')->required()->label('Bairro'),
                                TextInput::make('city')->required()->label('Cidade'),
                                TextInput::make('cep')->required()->label('CEP'),
                               
                            ])
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('cpf'),
                Tables\Columns\TextColumn::make('phone'),
                Tables\Columns\TextColumn::make('email'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime(),
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
            'index' => Pages\ListCustomers::route('/'),
            'create' => Pages\CreateCustomer::route('/create'),
            'view' => Pages\ViewCustomer::route('/{record}'),
            'edit' => Pages\EditCustomer::route('/{record}/edit'),
        ];
    }
}
