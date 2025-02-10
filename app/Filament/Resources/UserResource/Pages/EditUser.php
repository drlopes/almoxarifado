<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Models\User;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use STS\FilamentImpersonate\Pages\Actions\Impersonate;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Impersonate::make(),
            Actions\DeleteAction::make(),
        ];
    }

    public function mutateFormDataBeforeSave(array $data) : array
    {
        $getUser = User::where('email', $data['email'])->first();
        if ($getUser && empty($data['password'])) {
            $data['password'] = $getUser->password;
        }

        return $data;
    }

    protected function getRedirectUrl() : string
    {
        return $this->previousUrl ?? $this->getResource()::getUrl('index');
    }
}
