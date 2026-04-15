<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Carbon\Carbon;
use App\Models\Attendance;

class AttendanceChartWidget extends ChartWidget
{
    protected ?string $heading = 'Statistic Attendance Last 30 Days';

    protected static ?int $sort = 2;

    protected int | string | array $columnSpan = 'full';
    protected function getData(): array
    {

        $data = collect();
        $labels = collect();
        $lateData = collect();
        $presentData = collect();
        $absentData = collect();

        for ($i = 29; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $labels->push($date->format('d M'));
            $dayAttendance = Attendance::whereDate('attendance_date', $date->toDateString());
            $lateData->push((clone $dayAttendance)->where('status', 'late')->count());
            $presentData->push((clone $dayAttendance)->where('status', 'present')->count());
            $absentData->push((clone $dayAttendance)->where('status', 'absent')->count());
        }
        return [
            'labels' => $labels->toArray(),
            'datasets' => [
                [
                    'label' => 'Late',
                    'data' => $lateData->toArray(),
                    'backgroundColor' => 'rgba(255, 99, 132, 0.2)',
                    'borderColor' => 'rgba(255, 99, 132, 1)',
                ],
                [
                    'label' => 'Present',
                    'data' => $presentData->toArray(),
                    'backgroundColor' => 'rgba(54, 162, 235, 0.2)',
                    'borderColor' => 'rgba(54, 162, 235, 1)',
                ],
                [
                    'label' => 'Absent',
                    'data' => $absentData->toArray(),
                    'backgroundColor' => 'rgba(255, 205, 86, 0.2)',
                    'borderColor' => 'rgba(255, 205, 86, 1)',
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
