@extends('layouts.app')
@section('content')
<section class="section">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="far fa-check-square"></i>
                        Data-Correct :: ระบบตรวจสอบข้อมูล
                    </h5>
                    <!-- Horizontal Form -->
                    <form action="{{ route('search') }}">
                        <div class="card-body row mb-3">
                            <div class="col-md-4 mb-3">
                                <label for="" class="form-label">ICD10 : รหัสโรค</label>
                                <input type="text" class="form-control" name="icd" placeholder="ระบุรหัสโรคที่ต้องการลบ" value="{{ $_REQUEST['icd'] }}">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="" class="form-label">วันที่เริ่มต้น</label>
                                <input type="text" class="form-control basicDate" name="dstart" placeholder="ระบุวันที่เริ่มต้น" readonly value="{{ $_REQUEST['dstart'] }}">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="" class="form-label">วันที่สิ้นสุด</label>
                                <input type="text" class="form-control basicDate" name="dended" placeholder="ระบุวันที่สิ้นสุด" readonly value="{{ $_REQUEST['dended'] }}">
                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-success">
                                    Search Data
                                </button>
                            </div>
                        </div>
                    </form>
                    <!-- End Horizontal Form -->
                    <div class="card-body col-md-12">
                        <table id="tableBasic" class="table table-striped table-borderless">
                            <thead>
                                <tr>
                                    <th class="text-center"></th>
                                    <th class="text-center">VISIT:DATE</th>
                                    <th class="text-center">VISIT:NO</th>
                                    <th>CID</th>
                                    <th>PID</th>
                                    <th>PATIENT</th>
                                    <th class="text-center">DIAG</th>
                                    <th>NOTE</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($result as $res)
                                <tr>
                                    <td class="text-center"></td>
                                    <td class="text-center">{{ $res->visitdate }}</td>
                                    <td class="text-center">{{ $res->visitno }}</td>
                                    <td>{{ $res->idcard }}</td>
                                    <td>{{ $res->pid }}</td>
                                    <td>{{ $res->fname." ".$res->lname }}</td>
                                    <td class="text-center">{{ $res->diagcode }}</td>
                                    <td>{{ $res->symptoms }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('script')
<script>
    
</script>
@endsection
