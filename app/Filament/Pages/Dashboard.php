<?php

namespace App\Filament\Pages;

class Dashboard extends \Filament\Pages\Dashboard
{
    protected static ?string $navigationLabel = 'Dashboard';
    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';
    protected static bool $shouldRegisterNavigation = true;

    public static function canAccess(): bool
    {
        return true;
    }
}