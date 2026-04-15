<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Api\CheckInRequest;
use App\Http\Requests\Api\CheckOutRequest;
use Illuminate\Http\JsonResponse;
use App\Models\Attendance;
use Carbon\Carbon;
use App\Models\Company;
use App\Http\Resources\AttendanceResource;

class AttendanceController extends Controller
{
    //

    public function checkIn(CheckInRequest $request): JsonResponse
    {
        // Logic for checking in
        $user = $request->user();
        $today = Carbon::today();

        $existingAttendance = Attendance::where('user_id', $user->id)
            ->whereDate('attendance_date', $today)
            ->first();

            if($existingAttendance) {
                return response()->json([
                    'success' => false,
                    'message' => 'You have already checked in today.',
                ], 400);
            }

            //$company = Company::find($user->company_id);
            //$company = $user->company;
             $company = Company::getCompany();
            if(!$company) {
                return response()->json([
                    'success' => false,
                    'message' => 'Company not found.',
                ], 404);
            }

            $distance = $this->calculateDistance(
                $request->latitude,
                $request->longitude,
                $company->latitude,
                $company->longitude
            );

            if($distance > $company->radius) { // jika jarak lebih besar dari radius yang ditentukan
                return response()->json([
                    'success' => false,
                    'message' => 'You are too far from the company location to check in.',
                ], 400);
            }

        $photoPath = $request->file('photo')->store('attendances/'.$today->format('Y/m'), 'public');

         $now = Carbon::now();
        $workStartTime = Carbon::parse($company->work_start_time);
        
       $status = $now->gt($workStartTime->setDate($now->year, $now->month, $now->day)) ? 'late' : 'on_time';


        $attendance = Attendance::create([
            'user_id' => $user->id,
            'attendance_date' => $today,
            'check_in_time' => Carbon::now(),
            'check_in_latitude' => $request->latitude,
            'check_in_longitude' => $request->longitude,
            'check_in_photo' => $photoPath,
            'status' => $status,
        ]);
        $message = $status === 'late' ? 'Check-in successful, but you are late.' : 'Check-in successful.';
        return response()->json([
            'success' => true,
            'data' => $attendance,
            'message' => $message,
            
        ]);

    }

    public function checkOut(CheckOutRequest $request)
    {
        // Logic for checking out
        $user = $request->user();
        $today = Carbon::today();

        $existingAttendance = Attendance::where('user_id', $user->id)
            ->whereDate('attendance_date', $today)
            ->first();

        if(!$existingAttendance) {
            return response()->json([
                'success' => false,
                'message' => 'You have not checked in today.',
            ], 400);
        }

        $company = Company::getCompany();
        if(!$company) {
            return response()->json([
                'success' => false,
                'message' => 'Company not found.',
            ], 404);
        }

        $distance = $this->calculateDistance(
            $request->latitude,
            $request->longitude,        
            $company->latitude,
            $company->longitude
        );


        if($distance > $company->radius) { // jika jarak lebih besar dari radius yang ditentukan
            return response()->json([
                'success' => false,
                'message' => 'You are too far from the company location to check out.',
            ], 400);
        }

        $photoPath = $request->file('photo')->store('attendances/'.$today->format('Y/m'), 'public');
        
        $existingAttendance = $existingAttendance->update([
            'check_out_time' => Carbon::now(),
            'check_out_latitude' => $request->latitude,
            'check_out_longitude' => $request->longitude,
            'check_out_photo' => $photoPath,
        ]);

        return response()->json([
            'success' => true,
            'data' => $existingAttendance,
            'message' => 'Check-out successful.',
        ]);
    }

    public function todayAttendance(Request $request): JsonResponse
    {
        // Logic for fetching today's attendance
        $attendance = Attendance::where('user_id', $request->user()->id)
            ->whereDate('attendance_date', Carbon::today())
            ->first();

            return response()->json([
                'success' => true,
                'data' => $attendance ,
                'message' => $attendance ? 'Today\'s attendance retrieved successfully' : 'No attendance record found for today.',
            ]);
    }

    public function attendanceHistory(Request $request): JsonResponse
    {
        // Logic for fetching attendance history

        $month = $request->query('month', Carbon::now()->month);
        $year = $request->query('year', Carbon::now()->year);

        $attendances = Attendance::where('user_id', $request->user()->id)
            ->whereYear('attendance_date', $year)
            ->whereMonth('attendance_date', $month)
            ->orderBy('attendance_date', 'desc')
            ->get();

            return response()->json([
                'success' => true,
                'data' => $attendances,
                'message' => 'Attendance history retrieved successfully',
            ]);
    }


    private function calculateDistance(float $lat1, float $lon1, float $lat2, float $lon2): float
    {

        //semua method disini adalah untuk menghitung jarak absen dengan lokasi perusahaan menggunakan rumus Haversine
        $earthRadius = 6371000; // Earth's radius in meters

        $lat1Rad = deg2rad($lat1);
        $lat2Rad = deg2rad($lat2);
        $deltaLat = deg2rad($lat2 - $lat1);
        $deltaLon = deg2rad($lon2 - $lon1);

        $a = sin($deltaLat / 2) * sin($deltaLat / 2) +
            cos($lat1Rad) * cos($lat2Rad) *
            sin($deltaLon / 2) * sin($deltaLon / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c;
    }
}
