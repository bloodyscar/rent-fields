<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->relationship('users', 'name')
                    ->required(),
                Forms\Components\Select::make('lapangan_id')
                    ->relationship('lapangans', 'name')
                    ->required(),
                Forms\Components\DateTimePicker::make('tanggal_pesan')
                    ->required()
                    ->maxDate(now()),
                Forms\Components\DateTimePicker::make('jam_pesan')
                    ->label('Jam Pesan')
                    ->required(),
                Forms\Components\TimePicker::make('lama_sewa')->label('Jam Pesan')
                    ->required(),
                Forms\Components\TimePicker::make('lama_habis')->label('Jam Pesan')
                    ->required(),
                FileUpload::make('bukti_transfer')
                    ->label('Bukti Transfer')
                    ->image()
                    ->directory('public/images'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('users.name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('lapangans.name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tanggal_pesan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('jam_pesan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('lama_sewa')
                    ->searchable(),
                Tables\Columns\TextColumn::make('lama_habis')
                    ->searchable(),
                ImageColumn::make('bukti_transfer'),
                Tables\Columns\TextColumn::make('terkonfirmasi')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
