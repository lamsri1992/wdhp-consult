<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class jhcis extends Controller
{
    public function consult()
    {
        return view('consult');
    }

    public function datacorrect()
    {
        return view('datacorrect');
    }

    public function search(Request $request)
    {
        $result = DB::table('visitdiag')
                ->select('visit.visitdate','visit.visitno','person.idcard','person.pid','person.fname','person.lname','visitdiag.diagcode','cdxtype.dxtypedesc','visit.symptoms')
                ->leftjoin('visit','visit.visitno','visitdiag.visitno')
                ->leftjoin('person','person.pid','visit.pid')
                ->leftjoin('cdxtype','cdxtype.dxtypecode','visitdiag.dxtype')
                ->where('visitdiag.diagcode','like', '%'.$request->icd.'%')
                ->whereBetween('visit.visitdate',[$request->dstart,$request->dended])
                ->get();
        return view('search',['result'=>$result]);
    }

    function delete(Request $request)
    {
        $data = $request->formData;
        // dd($data);
        foreach($data as $array){
            DB::table('visitdiag')->where('visitno', $array[2])->where('diagcode', $array[6])->delete();
        }
    }

}
