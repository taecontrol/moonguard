<?php

namespace Taecontrol\Larastats\Filament\Resources\SiteResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use Taecontrol\Larastats\Filament\Resources\SiteResource;
use Taecontrol\Larastats\ValueObjects\RequestDuration;

class CreateSite extends CreateRecord
{
    protected static string $resource = SiteResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['max_request_duration_ms'] = RequestDuration::from($data['max_request_duration_ms']);
        $data['down_for_maintenance_at'] = $data['down_for_maintenance'] ? now() : null;

        return $data;
    }
}
