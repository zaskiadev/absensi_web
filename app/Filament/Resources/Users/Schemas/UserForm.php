<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Hash;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required(),
                DateTimePicker::make('email_verified_at'),
                TextInput::make('password')
                    ->required(fn (string $operation) => $operation === 'create')
                    ->dehydrated(fn ($state) => filled($state)) //agar password tidak terupdate jika field kosong
                    ->dehydrateStateUsing(fn ($state) => Hash::make($state)) //hash password sebelum disimpan
                    ->password(),
            
                TextInput::make('phone')
                    ->tel(),
                    Select::make('jabatan')->options([
                        'GM' => 'General Manager',
                        
                        'FBM' => 'FB Manager',
                        'BanquetManager' => 'Banquet Manager',
                        'BanquetCaptain' => 'Banquet Captain',
                        'BanquetStaff' => 'Banquet Staff',
                        'DWBanquet' => 'DW Banquet',
                        'RestaurantManager' => 'Restaurant Manager',
                        'FBCaptain' => 'FB Captain',
                        'FBCashier' => 'FB Cashier',
                        'Waiter' => 'Waiter',
                        'Bartender' => 'Bartender',
                        'Server' => 'Server',
                        'AsstServer' => 'Asst Server',
                        'DWFBStaff' => 'DW FB Service',
                        'TraineeFBS' => 'Trainee FB Service',
                        
                        'SportActivityManager' => 'Sport Activity Manager',
                        'SportActivitySPV' => 'Sport Activity SPV',
                        'PoolAttendant' => 'Pool Attendant',
                        'BeachAttendant' => 'Beach Attendant',
                        
                        'Secretary' => 'Secretary',
                        
                        'PurchasingManager' => 'Purchasing Manager',
                        'PurchasingStaff' => 'Purchasing Staff',

                        'LOManager' => 'LO Manager',
                        'SalesManager' => 'Sales Manager',
                        'LOOfficer' => 'LO Officer',

                        'ExecutiveCheff' => 'Executive Cheff',
                        'SousChef' => 'Sous Chef',
                        'ChiefSteward' => 'Chief Steward',
                        'Steward' => 'Steward',
                        'DWSteward' => 'DW Steward',
                        'CDP' => 'CDP',
                        'CommisChef' => 'Commis Chef',
                        'DWKitchen' => 'DW Kitchen',
                        'DemiPastrier' => 'Demi Pastrier',
                        'CommisPastrier' => 'Commis Pastrier',
                        'DwPastrier' => 'DW Pastrier',
                        'DemiChef' => 'Demi Chef',
                        'KitchenAdmin' => 'Kitchen Admin',

                        'ChiefEngineering'  => 'Chief Engineering',
                        'Engineering' => 'Engineering',

                        'ExecutiveHousekeeper' => 'Executive Housekeeper',
                        'HKSPV' => 'HK SPV',
                        'HKStaff' => 'HK Staff',
                        'PA' => 'Public Area',
                        'DWPA' => 'DW Public Area',
                        'DWMaintenanceAC' => 'DW Maintenance AC',
                        'RA' => 'Room Attendant',
                        'GardenerSPV' => 'Gardener SPV',
                        'Gardener' => 'Gardener',
                        'LaundrySPV' => 'Laundry SPV',
                        'Laundry' => 'Laundry',
                        'DWLaundry' => 'DW Laundry',
                        
                        'GSM' => 'GS Manager',
                        'TeraphistSPV' => 'Teraphist SPV',
                        'Teraphist' => 'Teraphist',
                        'GSSPV' => 'GS SPV',
                        'Bellman' => 'Bellman',
                        'DWBellman' => 'DW Bellman',
                        'CashierShop' => 'Cashier Shop',
                        'GRO' => 'GRO',
                        'FacilityAttendant' => 'Facility Attendant',
                        'SPAReceptionist' => 'SPA Receptionist',

                        'FOM' => 'FO Manager',
                        'FOSPV' => 'FO SPV',
                        'FDA' => 'FDA',
                        'Reservation' => 'Reservation',
                        'NigtManager' => 'Night Manager',
                        'NA' => 'Night Audit',

                        'FinanceController' => 'Finance Controller',
                        'CA' => 'Chief Accountant',
                        'IAAR' => 'IA/AR',
                        'Storekeeper' => 'Storekeeper',
                        'AP' => 'Accounts Payable',
                        'GC' => 'General Cashier',
                        'CC' => 'Cost Control',
                        'Bookkeeper' => 'Bookkeeper',

                        'HRM' => 'HR Manager',
                        'CasualStewardEDR' => 'Casual Steward EDR',
                        'CasualCookEDR' => 'Casual Cook EDR',
                        'TraineeHR' => 'Trainee HR',
                        'HRStaff' => 'HR Staff',

                        'ITM' => 'IT Manager',
                        'ITStaff' => 'IT Staff',
                    ])->required()
                    ->searchable(),


                Select::make('role')
                    ->options([
            'admin' => 'Admin',
            'employee' => 'Employee',
            'HRM' => 'HRM',
            'HOD' => 'HOD',
            'GM' => 'GM',
        ])
                    ->default('employee')
                    ->required(),
            ]);
    }
}
