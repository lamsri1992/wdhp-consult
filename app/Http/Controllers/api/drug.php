<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class drug extends Controller
{
    public function show($id)
    {
        $data = DB::table('visitdrug')
                ->select('cdrug.drugname','visitdrug.unit','visitdrug.dose')
                ->join('cdrug','cdrug.drugcode','visitdrug.drugcode')
                ->where('visitdrug.visitno',$id)
                ->get();
        return response()->json($data);
    }
}
