<?php

namespace App\Filament\Widgets;

use App\Models\Lapangan;
use App\Models\Order;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Order', value: Order::count()),
            Stat::make('Total Penyewa', value: User::where('role', 'user')->count()),
            Stat::make('Total Lapangan', value: Lapangan::count()),
        ];
    }
}
