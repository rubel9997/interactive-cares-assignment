<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Constants\Status;
use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make()
                ->icon('heroicon-m-user-group'),
            'Scheduled' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', Status::SCHEDULED)),
            'Not Vaccinated' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', Status::NOT_VACCINATED)),
            'Vaccinated' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', Status::VACCINATED)),
        ];
    }
}
