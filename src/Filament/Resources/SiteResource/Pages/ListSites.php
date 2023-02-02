<?php

namespace Taecontrol\Moonguard\Filament\Resources\SiteResource\Pages;

use Exception;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
use Taecontrol\Moonguard\Filament\Resources\SiteResource;

class ListSites extends ListRecords
{
    protected static string $resource = SiteResource::class;

    /**
     * @throws Exception
     */
    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
