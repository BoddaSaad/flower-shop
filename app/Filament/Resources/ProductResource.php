<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Models\Product;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $slug = 'products';

    protected static ?string $navigationIcon = 'heroicon-o-building-storefront';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('الاسم')
                    ->required(),

                TextInput::make('price')
                    ->label('السعر')
                    ->required()
                    ->numeric(),

                TextInput::make('discount')
                    ->label('التخفيض')
                    ->numeric(),

                Select::make('discount_type')
                    ->label('نوع التخفيض')
                    ->native(false)
                    ->options([
                        'fixed' => 'ثابت',
                        'percentage' => 'نسبة مئوية',
                    ]),

                TextInput::make('quantity')
                    ->label('الكمية')
                    ->required()
                    ->integer(),

                Select::make('categories')
                    ->relationship('categories', 'name')
                    ->multiple()
                    ->preload()
                    ->label('الأقسام')
                    ->searchable(),

                Select::make('gifts')
                    ->relationship('gifts', 'name')
                    ->multiple()
                    ->preload()
                    ->label('الهدايا')
                    ->searchable(),

                SpatieMediaLibraryFileUpload::make('الصور')
                    ->reorderable()
                    ->openable()
                    ->appendFiles()
                    ->multiple()->panelLayout('grid'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('الاسم')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('price')->label('السعر')->sortable(),

                TextColumn::make('discount')->label('التخفيض'),

                TextColumn::make('discount_type')
                    ->label('نوع التخفيض')
                    ->formatStateUsing(fn($state) => $state === 'fixed' ? 'ثابت' : ($state === 'percentage' ? 'نسبة مئوية' : $state)),

                TextColumn::make('quantity')->label('الكمية')->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'slug'];
    }

    public static function getNavigationLabel(): string
    {
        return 'المنتجات';
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->withoutGlobalScopes();
    }

    public static function getNavigationBadge(): ?string
    {
        /** @var class-string<Model> $modelClass */
        $modelClass = static::$model;

        return (string) $modelClass::where('quantity', '<', 10)->count() ?: null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'danger';
    }
}
