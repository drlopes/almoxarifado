<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TenantResource\Pages;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Actions\ActionGroup;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Forms\Form;
use App\Models\Tenant;
use Filament\Tables;

class TenantResource extends Resource
{
    protected static ?string $model = Tenant::class;
    protected static bool $isScopedToTenant = false;
    protected static bool $shouldRegisterNavigation = false;


    public static function form(Form $form) : Form
    {
        return $form
            ->schema([
                TextInput::make('code')
                    ->label(__('Acronym'))
                    ->unique(ignoreRecord: true)
                    ->required(),
                TextInput::make('client')
                    ->label(__('Client'))
                    ->required(),
                Textarea::make('description')
                    ->label(__('Description'))
                    ->columnSpan(2)
                    ->rows(5),
            ]);
    }

    public static function table(Table $table) : Table
    {
        return $table
            ->striped()
            ->columns([
                TextColumn::make('code')
                    ->label(__('Acronym'))
                    ->formatStateUsing(fn ($state) => strtoupper($state))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('client')
                    ->label(__('Client'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('users_count')
                    ->label(__('Users'))
                    ->badge()
                    ->sortable()
                    ->counts('users')
                    ->colors(['success']),
                TextColumn::make('description')
                    ->label(__('Description'))
                    ->toggleable(),
            ])
            ->filters([
                SelectFilter::make('client')
                    ->label(__('Client'))
                    ->multiple()
                    ->options(function () {
                        return Tenant::query()
                            ->pluck('client')
                            ->sort()
                            ->mapWithKeys(fn ($client) => [$client => $client])
                            ->toArray();
                    }),
            ])
            ->actions([
                ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations() : array
    {
        return [
            //
        ];
    }

    public static function getPages() : array
    {
        return [
            'index' => Pages\ListTenants::route('/'),
            'create' => Pages\CreateTenant::route('/create'),
            'edit' => Pages\EditTenant::route('/{record}/edit'),
        ];
    }

    public static function getModelLabel() : string
    {
        return __('tenant');
    }
}
