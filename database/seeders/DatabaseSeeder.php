<?php

namespace Database\Seeders;

use App\Models\Attendance;
use App\Models\Company;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        
      

        // Create 10 employee users with attendance data
       //$users = User::factory()->count(20)->create();
       
       //mengambil user yang sudah ada di database
       $users = User::all();

        // Jika tidak ada user sama sekali, tampilkan pesan peringatan di terminal
        if ($users->isEmpty()) {
            $this->command->warn("Tidak ada user ditemukan. Silahkan buat user terlebih dahulu.");
            return;
        }
        // Generate attendance data for each user for the last 30 days
        //$startDate = Carbon::now()->subDays(1);
        $startDate = Carbon::now();
        $endDate = Carbon::now();

        foreach ($users as $user) {
            $currentDate = $startDate->copy();

            while ($currentDate <= $endDate) {
                /*// Skip weekends (Saturday = 6, Sunday = 0)
                //if ($currentDate->dayOfWeek !== Carbon::SATURDAY && $currentDate->dayOfWeek !== Carbon::SUNDAY) {
                    // 90% chance of attendance, 10% chance of absent
                    if (fake()->boolean(90)) {
                        Attendance::factory()
                            ->for($user)
                            ->forDate($currentDate)
                            ->create();
                    }*/

                            // PENGECEKAN: Cari apakah user ini sudah punya absen di tanggal ini
                $exists = Attendance::where('user_id', $user->id)
                    ->whereDate('attendance_date', $currentDate->format('Y-m-d'))
                    ->exists();

                // Hanya buat data jika belum ada (dan lolos 90% chance)
                if (!$exists && fake()->boolean(90)) {
                    Attendance::factory()
                        ->for($user)
                        ->forDate($currentDate)
                        ->create();
                }

                $currentDate->addDay();
               // }

                $currentDate->addDay();
            }
        }
    }
}