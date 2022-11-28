<?php

namespace Taecontrol\Larastats\Filament\Resources\SiteResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use Taecontrol\Larastats\ValueObjects\RequestDuration;
use Taecontrol\Larastats\Filament\Resources\SiteResource;

class CreateSite extends CreateRecord
{
    protected static string $resource = SiteResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['max_request_duration_ms'] = RequestDuration::from(data_get($data, 'max_request_duration_ms', 1000));
        $data['down_for_maintenance_at'] = $data['down_for_maintenance'] ? now() : null;

        return $data;
    }
}
