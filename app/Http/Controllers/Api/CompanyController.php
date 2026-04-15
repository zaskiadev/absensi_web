<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company;
use Illuminate\Http\JsonResponse;
class CompanyController extends Controller
{
    //
    public function index(): JsonResponse
    {
        $companies = Company::getCompany();  
        if (!$companies) {
            return response()->json([
                'success' => false,
                'message' => 'No company data found',
            ], 404);
        } 
        return response()->json([
                'success' => true,
                'data' => $companies,
                'message' => 'Company data retrieved successfully',
            ]);
    }
}
