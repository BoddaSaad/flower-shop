<?php

namespace App\Filament\Resources\OrderResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'items';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('product_id')
                    ->relationship('product', 'name')
                    ->required()
                    ->label('المنتج'),

                Forms\Components\TextInput::make('quantity')
                    ->label('الكمية')
                    ->required(),

                Forms\Components\TextInput::make('receiver_number')
                    ->label('رقم المستلم')
                    ->required(),

                Forms\Components\DatePicker::make('delivery_date')
                    ->label('تاريخ التسليم')
                    ->required()
                    ->minDate(now()),

                Forms\Components\Textarea::make('message')
                    ->label('رسالة')
                    ->required(),

                Forms\Components\TextInput::make('unit_price_in_cents')
                    ->label('سعر الوحدة')
                    ->required()
                    ->integer()
                    ->formatStateUsing(fn ($state) => number_format($state / 100, 2)),

                Forms\Components\Select::make('gifts')
                    ->relationship('gifts', 'name')
                    ->multiple()
                    ->preload()
                    ->columnSpanFull()
                    ->label('الهدايا'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('product.name')
                    ->label('المنتج'),
                Tables\Columns\TextColumn::make('quantity')
                    ->label('الكمية'),
                Tables\Columns\TextColumn::make('delivery_date')
                    ->label('تاريخ التسليم'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
