<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Carbon\Carbon;
use App\Models\Attendance;
use App\Models\User;

class StatsOverview extends BaseWidget
{

    protected static ?int $sort=1;

    protected function getStats(): array
    {
        $today = Carbon::today();
        //$totalEmployees = User::where('role', 'employee')->count(); ini untuk menghitung jika usernya rolenya employee, karena disini rolenya selain admin banyak, jadinya tidak berdasarkan employee
        $totalEmployees = User::count();
        $attendanceToday = Attendance::whereDate('attendance_date', $today);
        $presentToday = $attendanceToday->count();
        $lateToday = (clone $attendanceToday)->where('status', 'late')->count();
        $absentToday = (clone $attendanceToday)->where('status', 'absent')->count();


        return [

            Stat::make('Total Employees', $totalEmployees)
                 ->description('Total number of employees in the system')
                 ->descriptionIcon('heroicon-o-users')
                 ->color('primary'),

            Stat::make('Attendance Today', $presentToday)
            ->description("{$presentToday} out of {$totalEmployees} employees present today, {$lateToday} late, {$absentToday} absent")
                 ->descriptionIcon('heroicon-o-check-circle')
                 ->color('success'),

           // Stat::make('Late Today', Attendance::whereDate('attendance_date', $today)->where('status', 'late')->count()),
           // Stat::make('Absent Today', Attendance::whereDate('attendance_date', $today)->where('status', 'absent')->count()),
           
        ];
    }
}