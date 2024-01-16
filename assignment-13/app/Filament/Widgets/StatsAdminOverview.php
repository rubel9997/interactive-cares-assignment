<?php

namespace App\Filament\Widgets;

use App\Constants\Status;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsAdminOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Registered User', User::query()->count())
                ->icon('heroicon-m-user-group'),
            Stat::make('Vaccinated User', User::query()->where('status', Status::VACCINATED)->count())
                ->icon('heroicon-m-user-group'),
            Stat::make('Not Vaccinated User', User::query()->where('status', Status::NOT_VACCINATED)->count())
                ->icon('heroicon-m-user-group'),
            Stat::make('Scheduled User', User::query()->where('status', Status::SCHEDULED)->count())
                ->icon('heroicon-m-user-group'),
        ];
    }
}
