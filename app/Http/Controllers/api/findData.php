<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class findData extends Controller
{
    public function show($id)
    {
        $data = DB::table('visit')
                ->select('visit.pcucode','visit.visitno','visit.visitdate','_tmpprename_code.prename','person.fname',
                'person.lname','visit.symptoms','visit.weight','visit.height','visit.pressure','visit.temperature','visit.pulse','visit.respri')
                ->join('person','person.pid','visit.pid')
                ->join('_tmpprename_code','_tmpprename_code.prenamecode','person.prename')
                ->where('visit.visitno',$id)
                ->first();
        return response()->json($data);
    }
}
