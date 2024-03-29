<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RoomItemReportResource\Pages;
use App\Filament\Resources\RoomItemReportResource\RelationManagers;
use App\Models\RoomItem;
use App\Models\RoomItemReport;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RoomItemReportResource extends Resource
{
    protected static ?string $model = RoomItemReport::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('room_item_id')
                    ->label('Ruangan Barang')
                    ->relationship('roomItem', 'quantity')
                    ->required()
                    ->preload()
                    ->searchable(),
                TextInput::make('quantity')
                    ->label('Jumlah')
                    ->numeric()
                    ->required(),
                Select::make('status')
                    ->options([
                        'hilang' => 'Rusak',
                        'rusak' => 'Rusak',
                    ])
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('roomItem.room.code')
                    ->label('Ruangan'),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
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
            'index' => Pages\ListRoomItemReports::route('/'),
            'create' => Pages\CreateRoomItemReport::route('/create'),
            'edit' => Pages\EditRoomItemReport::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
