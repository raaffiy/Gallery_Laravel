<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ImageResource\Pages;
use App\Filament\Resources\ImageResource\RelationManagers;
use App\Models\Image;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Storage;

class ImageResource extends Resource
{
    protected static ?string $model = Image::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema ([
                        FileUpload::make('gambar')->required()->image()->disk('public'),
                        TextInput::make('judul')->required(),
                        Textarea::make('short_description')->required(),
                        Textarea::make('long_description')->required(),
                        Select::make('category')
                            ->options([
                                'Mountain' => 'Mountain', 'Game Art' => 'Game Art', 'Sky' => 'Sky',
                                'Anime Art' => 'Anime Art'
                        ])->required(),
                ])
                ->columns (2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('gambar'),
                TextColumn::make('judul')->sortable()->searchable(),
                TextColumn::make('short_description'),
                TextColumn::make('category')->sortable()->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()->after(
                    function (Collection $records){
                        foreach($records as $key => $value){
                            if ($value->gambar){
                                Storage::disk('public')->delete($value->gambar);
                            }
                        }
                    }
                )
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make()->after(
                    function (Collection $records){
                        foreach ($records as $key => $value){
                            if ($value->gambar){
                            Storage::disk('public')->delete($value->gambar);
                            }
                        }
                    }
                ),
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
            'index' => Pages\ListImages::route('/'),
            'create' => Pages\CreateImage::route('/create'),
            'edit' => Pages\EditImage::route('/{record}/edit'),
        ];
    }    
}
