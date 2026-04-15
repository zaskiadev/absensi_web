<?php

namespace App\Filament\Widgets;

use App\Models\Attendance;
use Filament\Actions\BulkActionGroup;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

class LatestAttendanceWidget extends TableWidget
{
     protected static ?string $heading = 'Attendance This Day';

    protected static ?int $sort = 3;

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Attendance::query()
                ->with('user')
                ->whereDate('attendance_date', Carbon::today())
                ->latest('check_in_time')
            )   

            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('user.employee_id')
                    ->label('ID Karyawan')
                    ->searchable(),
                    
                Tables\Columns\TextColumn::make('check_in_time')
                    ->label('Check-in')
                    ->dateTime('H:i')
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('check_out_time')
                    ->label('Check-out')
                    ->dateTime('H:i')
                    ->placeholder('-')
                    ->sortable(),
                    
                Tables\Columns\BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'success' => 'on_time',
                        'warning' => 'late',
                    ])
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'on_time' => 'Tepat Waktu',
                        'late' => 'Terlambat',
                        default => $state,
                    }),      

                //
            ])
            ->filters([
                //
            ])
            ->headerActions([
                //
            ])
            ->recordActions([
                //
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    //
                ]),
            ]);
    }
}
