<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VagaResource\Pages;
use App\Filament\Resources\VagaResource\RelationManagers;
use App\Models\Vaga;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class VagaResource extends Resource
{
    protected static ?string $model = Vaga::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    private static array $richTextOptions = [
        'bold',
        'italic',
        'strike',
        'h2',
        'h3',
        'bulletList',
        'orderedList',
        'redo',
        'undo',
    ];

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->columns(4)
                    ->schema([
                        TextInput::make('nome')
                            ->required()
                            ->label('Nome')
                            ->columnSpan(2)
                            ->autofocus(true),

                        TextInput::make('total_posicoes')
                            ->required()
                            ->numeric()
                            ->minValue(1)
                            ->default(1)
                            // BUG here... if you comment this line the RichEditor works fine
                            ->mask(fn (TextInput\Mask $mask) => $mask->integer())
                            ->label('Qtd. Posições'),


                        Fieldset::make('Descrição da vaga')
                            ->columnSpan(4)
                            ->schema([
                                RichEditor::make('descricao')
                                    ->columnSpan(4)
                                    ->disableAllToolbarButtons()
                                    ->enableToolbarButtons(self::$richTextOptions)
                                    ->label(''),
                            ]),

                        Fieldset::make('Requisitos da vaga')
                            ->columnSpan(4)
                            ->schema([
                                RichEditor::make('requisitos')
                                    // ->required()
                                    ->columnSpan(4)
                                    ->disableAllToolbarButtons()
                                    ->enableToolbarButtons(self::$richTextOptions)
                                    ->label(''),
                            ]),

                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nome')->label('Nome')->searchable()->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
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
            'index' => Pages\ListVagas::route('/'),
            'create' => Pages\CreateVaga::route('/create'),
            'edit' => Pages\EditVaga::route('/{record}/edit'),
        ];
    }
}
