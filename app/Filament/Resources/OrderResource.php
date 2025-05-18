<?php

namespace App\Filament\Resources;

use App\Enums\OrderShippingStatus;
use App\Enums\OrderStatus;
use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers\ItemsRelationManager;
use App\Filament\Resources\OrderResource\RelationManagers\ProductsRelationManager;
use App\Models\Order;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $slug = 'orders';

    protected static ?string $recordTitleAttribute = 'reference';

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('user_id')
                    ->label('العميل')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->required(),

                TextInput::make('amount_in_cents')
                    ->label('المبلغ')
                    ->readOnly()
                    ->formatStateUsing(fn ($state) => number_format($state / 100, 2))
                    ->required()
                    ->integer(),

                ToggleButtons::make('status')
                    ->label('حالة الدفع')
                    ->inline()
                    ->options(OrderStatus::class)
                    ->required(),

                ToggleButtons::make('shipping_status')
                    ->label('حالة الشحن')
                    ->inline()
                    ->options(OrderShippingStatus::class)
                    ->required(),

                TextInput::make('reference')
                    ->label('الرقم المرجعي')
                    ->readOnly()
                    ->required(),

                TextInput::make('transaction')
                    ->label('رقم المعاملة')
                    ->readOnly(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->searchable()
                    ->label('العميل')
                    ->sortable(),

                TextColumn::make('status')
                    ->label('حالة الدفع')
                    ->sortable()
                    ->badge()->color(fn(string $state): string => match ($state) {
                        'pending' => 'info',
                        'cancelled' => 'danger',
                        'confirmed' => 'success',
                    })->icon(fn(string $state): string => match ($state) {
                        'pending' => 'heroicon-s-sparkles',
                        'cancelled' => 'heroicon-s-x-circle',
                        'confirmed' => 'heroicon-s-check-circle',
                    })->formatStateUsing(function (string $state): string {
                        return match ($state) {
                            'pending' => 'قيد الانتظار',
                            'cancelled' => 'ملغاة',
                            'confirmed' => 'تم الدفع',
                        };
                    }),

                TextColumn::make('shipping_status')
                    ->label('حالة الشحن')
                    ->sortable()
                    ->badge()->color(fn(string $state): string => match ($state) {
                        'pending' => 'info',
                        'preparing' => 'warning',
                        'shipped' => 'success',
                        'delivered' => 'success',
                    })->icon(fn(string $state): string => match ($state) {
                        'pending' => 'heroicon-s-sparkles',
                        'preparing' => 'heroicon-s-arrow-path',
                        'shipped' => 'heroicon-s-truck',
                        'delivered' => 'heroicon-s-check-badge',
                    })->formatStateUsing(function (string $state): string {
                        return match ($state) {
                            'pending' => 'قيد الانتظار',
                            'preparing' => 'قيد التحضير',
                            'shipped' => 'تم الشحن',
                            'delivered' => 'تم التسليم',
                        };
                    }),

                TextColumn::make('reference')
                    ->label('الرقم المرجعي')
                    ->sortable()
                    ->formatStateUsing(function ($state){
                        return strtoupper($state);
                    })
                    ->copyable()
                    ->copyMessage('تم نسخ الرقم المرجعي')
                    ->copyMessageDuration(1500)
                    ->searchable(),

                TextColumn::make('amount_in_cents')->label('المبلغ')
                    ->sortable()
                    ->formatStateUsing(function ($state) {
                        return number_format($state / 100, 2);
                    }),

                TextColumn::make('created_at')->label('تاريخ الطلب')
                    ->sortable()
                    ->dateTime('j M Y'),
            ])
            ->filters([
                Filter::make('created_at')
                    ->form([
                        DatePicker::make('created_from')->label('من تاريخ')
                            ->placeholder(fn($state): string => 'Dec 18, '.now()->subYear()->format('Y')),
                        DatePicker::make('created_until')->label('إلى تاريخ')
                            ->placeholder(fn($state): string => now()->format('M d, Y')),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'] ?? null,
                                fn(Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'] ?? null,
                                fn(Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    })
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];
                        if ($data['created_from'] ?? null) {
                            $indicators['created_from'] = 'Order from '.Carbon::parse($data['created_from'])->toFormattedDateString();
                        }
                        if ($data['created_until'] ?? null) {
                            $indicators['created_until'] = 'Order until '.Carbon::parse($data['created_until'])->toFormattedDateString();
                        }

                        return $indicators;
                    }),
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
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }

    public static function getGlobalSearchEloquentQuery(): Builder
    {
        return parent::getGlobalSearchEloquentQuery()->with(['user']);
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['user.name'];
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        $details = [];

        if ($record->user) {
            $details['User'] = $record->user->name;
        }

        return $details;
    }

    public static function getRelations(): array
    {
        return [
            ItemsRelationManager::class,
        ];
    }

    public static function getNavigationLabel(): string
    {
        return 'الطلبات';
    }

    public static function getNavigationBadge(): ?string
    {
        /** @var class-string<Model> $modelClass */
        $modelClass = static::$model;

        return (string) $modelClass::where('status', 'confirmed')->where('shipping_status', 'pending')->count();
    }
}
