<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\RelationManagers\TenantsRelationManager;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Select;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use STS\FilamentImpersonate\Tables\Actions\Impersonate;
use App\Filament\Resources\UserResource\Pages;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Actions\DeleteAction;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Actions\ActionGroup;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Model;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Resources\Resource;
use Illuminate\Support\Str;
use Filament\Tables\Table;
use Filament\Forms\Form;
use App\Models\User;
use Filament\Tables;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?int $navigationSort = -1;
    protected static bool $shouldRegisterNavigation = false;

    public static function form(Form $form) : Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label(__('Name'))
                    ->required(),
                TextInput::make('email')
                    ->label(__('E-mail'))
                    ->unique(ignoreRecord: true)
                    ->required(),
                Select::make('roles')
                    ->label(__('Role'))
                    ->relationship('roles', 'name', modifyQueryUsing: fn ($query) => $query->when(! auth()->user()->hasRole('developer'), fn ($query) => $query->where('name', '!=', 'developer'))->orderBy('id'))
                    ->getOptionLabelFromRecordUsing(fn (Model $record) => trans(Str::title($record->name), locale: 'pt_BR'))
                    ->columns(3)
                    ->required(),
                TextInput::make('password')
                    ->label(__('Password'))
                    ->password()
                    ->revealable()
                    ->rules([Password::defaults()])
                    ->required(fn (string $operation) : bool => $operation === 'create'),
                Checkbox::make('force_renew_password')
                    ->label(__('User should reset password'))
                    ->default(true),
            ]);
    }

    public static function table(Table $table) : Table
    {
        return $table
            ->striped()
            ->columns([
                TextColumn::make('name')
                    ->label(__('Name'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->label(__('E-mail'))
                    ->searchable(),
                TextColumn::make('roles.name')
                    ->label(__('Role'))
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->colors([
                        'primary' => 'developer',
                        'warning' => 'admin',
                        'success' => 'user',
                    ]),
                TextColumn::make('created_at')
                    ->label(__('Created At'))
                    ->dateTime('M j, Y')
                    ->toggleable()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\Filter::make('created_at')
                    ->form([
                        DatePicker::make('created_from')->label(__('Created from')),
                        DatePicker::make('created_until')->label(__('Created until')),
                    ])
                    ->query(function (Builder $query, array $data) : Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (Builder $query, $date) : Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date) : Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    }),
            ])
            ->actions([
                Impersonate::make(),
                ActionGroup::make([
                    ViewAction::make(),
                    EditAction::make(),
                    DeleteAction::make()
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->checkIfRecordIsSelectableUsing(
                fn (Model $record) : bool => Auth::user()->can('delete', $record)
            );
    }

    public static function getRelations() : array
    {
        return [
            TenantsRelationManager::class,
        ];
    }

    public static function getPages() : array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function getModelLabel() : string
    {
        return __('user');
    }
}
