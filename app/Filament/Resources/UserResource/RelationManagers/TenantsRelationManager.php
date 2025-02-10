<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Actions\AttachAction;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Actions\DetachAction;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Facades\Auth;
use Filament\Tables\Table;
use Filament\Forms\Form;

class TenantsRelationManager extends RelationManager
{
    protected static string $relationship = 'tenants';

    public function form(Form $form) : Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public function table(Table $table) : Table
    {
        return $table
            ->recordTitleAttribute('code')
            ->heading(__('Tenants'))
            ->columns([
                TextColumn::make('code')
                    ->label(__('Acronym'))
                    ->formatStateUsing(fn ($state) => strtoupper($state)),
                TextColumn::make('client')
                    ->label(__('Client')),
                TextColumn::make('description')
                    ->label(__('Description')),
            ])
            ->headerActions([
                AttachAction::make()
                    ->preloadRecordSelect()
                    ->recordSelectOptionsQuery(
                        fn (Builder $query) => Auth::user()->hasRole('developer')
                        ? $query
                        : auth()->user()->tenants()->getQuery()
                    )
                    ->label(__('Attach Tenant'))
                    ->modalHeading(__('Attach Tenant'))
            ])
            ->actions([
                DetachAction::make()
                    ->authorize(fn ($record) => Auth::user()->can('detach', [$record, $this->getOwnerRecord()])),
            ]);

    }
}
