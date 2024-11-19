<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LapanganResource\Pages;
use App\Models\Lapangan;
use App\Models\Order;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Table;
use Filament\Tables\Columns\Layout\View;

class LapanganResource extends Resource
{
    protected static ?string $model = Lapangan::class;

    protected static ?string $navigationIcon = 'heroicon-o-map';


    protected static ?int $navigationSort = 2;

    protected static ?string $navigationLabel = 'Data Lapangan';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name'),
                Forms\Components\TextInput::make('price')
                    ->numeric()
                    ->prefix('Rp')
                    ->maxValue(42949672.95),
                FileUpload::make('img')
                    ->label('Gambar Lapangan')
                    ->image()
                    ->directory('images'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('price')->money('Rp ')
                    ->sortable(),
                ImageColumn::make('img')
                    ->label('Image')
                    ->sortable()
                    ->extraAttributes(['class' => 'clickable-image']),

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),

            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
        ;
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
            'index' => Pages\ListLapangans::route('/'),
            'create' => Pages\CreateLapangan::route('/create'),
            // 'edit' => Pages\EditLapangan::route('/{record}/edit'),
        ];
    }
}
