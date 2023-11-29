<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BrandResource\Pages;
use App\Models\Brand;
use Filament\Forms;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class BrandResource extends Resource
{
    protected static ?string $model = Brand::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationGroup = 'Shop';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->live(onBlur: true)
                            ->unique()
                            ->afterStateUpdated( //takes callback function
                                function (string $operation, $state, Forms\Set $set) {
                                    if ($operation != 'create') {
                                        return;
                                    }
                                    $set('slug', Str::slug($state));
                                }
                            ),
                        TextInput::make('slug')
                            ->disabled()
                            ->dehydrated()
                            ->required()
                            ->unique(),
                        TextInput::make('url')
                            ->label('Website URL')
                            ->required()
                            ->unique()
                            ->columnSpan('full'),
                        MarkdownEditor::make('description')->columnSpan('full'),
                    ])->columns(2),
                Group::make()
                    ->schema([
                        Section::make('Status')
                            ->schema([
                                Toggle::make('is_visible')
                                    ->label('Visible')
                                    ->helperText('Enable or disable product visibility')
                                    ->default(true),
                            ]),

                        Group::make()
                            ->schema([
                                Section::make('Color')
                                    ->schema([
                                        ColorPicker::make('primary_hex')
                                            ->label('Primary Color')
                                    ]),

                            ])
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // TextColumn::make('name')
                //     ->searchable()
                //     ->sortable(),
                // TextColumn::make('url')
                //     ->searchable()
                //     ->sortable()
                //     ->label('Website URL'),
                // TextColumn::make('primary_hex')
                //     ->label('Primary Color'),
                // IconColumn::make('is_visible')
                //     ->boolean()
                //     ->sortable()
                //     ->label('Visibility'),
                // TextColumn::make('updated_at')
                //     ->date()
                //     ->sortable()
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
            'index' => Pages\ListBrands::route('/'),
            'create' => Pages\CreateBrand::route('/create'),
            'edit' => Pages\EditBrand::route('/{record}/edit'),
        ];
    }
}
