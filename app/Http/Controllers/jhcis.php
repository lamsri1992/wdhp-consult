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

    public function send(Request $request)
    {
        $vn = $request->vstno;
        $data = DB::table('visit')
                ->select('visit.pcucode','visit.visitno','visit.visitdate','person.pid','visit.symptoms','visit.weight','visit.height','visit.pressure','visit.temperature',
                'visit.pulse','visit.respri')
                ->join('person','person.pid','visit.pid')
                ->where('visit.visitno',$vn)
                ->first();
        $diag = DB::table('visitdiag')
                ->select('visitdiag.diagcode','cdisease.diseasenamethai','cdxtype.dxtypedesc')
                ->leftjoin('cdisease','cdisease.diseasecode','visitdiag.diagcode')
                ->leftjoin('cdxtype','cdxtype.dxtypecode','visitdiag.dxtype')
                ->where('visitdiag.visitno',$vn)
                ->get();
        $drug = DB::table('visitdrug')
                ->select('cdrug.drugname','visitdrug.unit','visitdrug.dose')
                ->join('cdrug','cdrug.drugcode','visitdrug.drugcode')
                ->where('visitdrug.visitno',$vn)
                ->get();

        // Insert Consult List
        DB::connection('mysql2')->table('h_consult')->insert(
            [
                'vstno' => $request->vstno,
                'note' => $request->note,
                'level' => $request->level,
                'pcucode' => $data->pcucode,
            ]
        );

        // Insert Consult Visit
        DB::connection('mysql2')->table('h_consult_visit')->insert(
            [
                'visitdate' => $data->visitdate,
                'pcucode' => $data->pcucode,
                'visitno' => $data->visitno,
                'pid' => $data->pid,
                'symptoms' => $data->symptoms,
                'weight' => $data->weight,
                'height' => $data->height,
                'pressure' => $data->pressure,
                'temperature' => $data->temperature,
                'pulse' => $data->pulse,
                'respri' => $data->respri,
            ]
        );

        // Insert Consult Diag
        foreach($diag as $res){
            DB::connection('mysql2')->table('h_consult_diag')->insert(
                [
                    'pcucode' => $data->pcucode,
                    'visitno' => $data->visitno,
                    'diagcode' => $res->diagcode,
                    'diseasenamethai' => $res->diseasenamethai,
                    'dxtypedesc' => $res->dxtypedesc,
                ]
            );
        }

        // Insert Consult Drug
        foreach($drug as $res){
            DB::connection('mysql2')->table('h_consult_drug')->insert(
                [
                    'pcucode' => $data->pcucode,
                    'visitno' => $data->visitno,
                    'drugname' => $res->drugname,
                    'unit' => $res->unit,
                    'dose' => $res->dose,
                ]
            );
        }
        // Line Notify
        $Token = "pI7JcfdQyyebIrdHEeTnmFOwZVDXwath4Rl4CAhgiQ6";
        $message = "รายการ Consult ใหม่\nรหัสหน่วยบริการ : ".$data->pcucode."\nความเร่งด่วน : ".$request->level."\nบันทึกข้อความ : ".$request->note."\nURL : http://203.157.209.59/wdhp-front";
        line_notify($Token, $message);

        return back()->with('success','บันทึกรายการ Consult สำเร็จ : '.$request->vstno."");
    }

}
