<?php

namespace Taecontrol\Larastats\Filament\Resources\SiteResource\Pages;

use Exception;
use Spatie\Url\Url;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;
use Taecontrol\Larastats\Filament\Resources\SiteResource;
use Taecontrol\Larastats\ValueObjects\RequestDuration;

class EditSite extends EditRecord
{
    protected static string $resource = SiteResource::class;

    protected function mutateFormDataBeforeFill(array $data): array
    {
        /** @var Url $url */
        $url = $data['url'];

        /** @var RequestDuration $maxDuration */
        $maxDuration = $data['max_request_duration_ms'];

        $data['url'] = $url->__toString();
        $data['max_request_duration_ms'] = $maxDuration->toRawMilliseconds();
        $data['api_token_enabled'] = (bool) $data['api_token'];
        $data['down_for_maintenance'] = (bool) $data['down_for_maintenance_at'];

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['max_request_duration_ms'] = RequestDuration::from($data['max_request_duration_ms']);
        $data['down_for_maintenance_at'] = $data['down_for_maintenance'] ? now() : null;

        return $data;
    }

    /**
     * @throws Exception
     */
    protected function getActions(): array
    {
        return [
            Actions\Action::make('exceptions')
                ->url("/admin/sites/{$this->record->id}/exceptions"),
            Actions\DeleteAction::make(),
        ];
    }
}
