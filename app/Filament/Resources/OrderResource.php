<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Models\Order;
use Filament\Actions\Modal\Actions\Action;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\SoftDeletingScope;


use function Laravel\Prompts\search;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';
    protected static ?int $navigationSort = 3;


    protected static ?string $navigationLabel = 'Data Pesanan';

    public static function canCreate(): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make([
                    TextInput::make('name')
                        ->readOnly()
                ])
                    ->relationship('users'),
                Forms\Components\Select::make('lapangan_id')
                    ->relationship('lapangans', 'name')
                    ->disabled(function ($get) {
                        return is_null($get('class_stage_id'));
                    }),
                Forms\Components\DateTimePicker::make('tanggal_pesan')
                    ->required()
                    ->extraInputAttributes(['readonly' => true])
                    ->maxDate(now()),
                Forms\Components\DateTimePicker::make('jam_pesan')
                    ->label('Jam Pesan')
                    ->required()
                    ->extraInputAttributes(['readonly' => true]),

                Forms\Components\Select::make('lama_sewa')
                    ->options([
                        '1' => '1 Jam',
                        '2' => '2 Jam',
                        '3' => '3 Jam',
                        '4' => '4 Jam',
                        '5' => '5 Jam',
                    ])
                    ->disabled(function ($get) {
                        return is_null($get('class_stage_id'));
                    }),
                Forms\Components\Select::make('konfirmasi')
                    ->default('Belum Konfirmasi')
                    ->options([
                        'Belum Konfirmasi' => 'Belum Konfirmasi',
                        'Sudah Konfirmasi' => 'Sudah Konfirmasi',
                    ])
                    ->disablePlaceholderSelection(true),
                Forms\Components\TextInput::make('total_harga')
                    ->numeric()
                    ->prefix('Rp')
                    ->readOnly(),
                FileUpload::make('bukti_transfer')
                    ->label('Bukti Transfer')
                    ->image()
                    ->directory('images'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('users.name')
                    ->label('Nama Penyewa')
                    ->searchable(),
                Tables\Columns\TextColumn::make('lapangans.name')
                    ->label('Lapangan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tanggal_pesan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('jam_pesan')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('lama_sewa')
                    ->searchable(),
                Tables\Columns\TextColumn::make('lama_habis')
                    ->searchable(),
                Tables\Columns\TextColumn::make('total_harga')
                    ->numeric()
                    ->prefix('Rp '),

                Tables\Columns\TextColumn::make('konfirmasi')

            ])
            ->filters([
                //
            ])
            ->actions([
                // Tables\Actions\Action::make('Bukti Transfer')
                //     ->modalContent(fn(Order $order) => view('filament.pages.actions.image', ['order' => $order]))
                //     ->modalSubmitAction(false),
                // Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('Bukti Transfer')
                    ->url(fn(Order $order) => route('order.newtab', ['id' => $order->id]))
                    ->openUrlInNewTab(),
                Tables\Actions\EditAction::make(),

            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
                // BulkAction::make('delete')
                //     ->action(fn(Collection $records) => $records->each->delete())


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
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
