<?php

namespace App\Filament\Resources\Attendances\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Schemas\Schema;

class AttendanceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('user_id')
                    ->required()
                    ->numeric(),
                DatePicker::make('attendance_date'),
                TimePicker::make('check_in_time'),
                TextInput::make('check_in_latitude')
                    ->numeric(),
                TextInput::make('check_in_longitude')
                    ->numeric(),
                TextInput::make('check_in_photo'),
                TimePicker::make('check_out_time'),
                TextInput::make('check_out_latitude')
                    ->numeric(),
                TextInput::make('check_out_longitude')
                    ->numeric(),
                TextInput::make('check_out_photo'),
                Select::make('status')
                    ->options(['present' => 'Present', 'absent' => 'Absent', 'late' => 'Late'])
                    ->default('absent')
                    ->required(),
            ]);
    }
}
