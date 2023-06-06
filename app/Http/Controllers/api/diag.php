<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class diag extends Controller
{
    public function show($id)
    {
        $data = DB::table('visitdiag')
                ->select('visitdiag.diagcode','cdisease.diseasenamethai')
                ->join('cdisease','cdisease.diseasecode','visitdiag.diagcode')
                ->where('visitdiag.visitno',$id)
                ->get();
        return response()->json($data);
    }
}
