<?php

namespace App\Filament\Resources\Roles\Pages;

use App\Filament\Resources\Roles\RoleResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditRole extends EditRecord
{
    protected static string $resource = RoleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
    protected function mutateFormDataBeforeSave(array $data): array
    {
        unset($data['permission_groups']);

        return $data;
    }

    protected function afterSave(): void
    {
        $this->syncPermissions();
    }

    private function syncPermissions(): void
    {
        $groups = $this->form->getState()['permission_groups'] ?? [];

        $permissionIds = collect($groups)
            ->flatten()
            ->unique()
            ->values()
            ->all();

        $this->record
            ->permissions()
            ->sync($permissionIds);
    }
}
