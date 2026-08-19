<?php

namespace App\Filament\Resources\Roles\Pages;

use App\Filament\Resources\Roles\RoleResource;
use App\Models\Permission;
use Filament\Resources\Pages\CreateRecord;

class CreateRole extends CreateRecord
{
    protected static string $resource = RoleResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        unset($data['permission_groups']);

        return $data;
    }

    protected function afterCreate(): void
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