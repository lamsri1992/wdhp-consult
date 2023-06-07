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
                    <div class="col-md-12">
                        <nav style="--bs-breadcrumb-divider: '-';">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ url('/') }}">หน้าหลัก</a></li>
                                <li class="breadcrumb-item active">ระบบตรวจสอบข้อมูล</li>
                            </ol>
                        </nav>
                    </div>
                    <!-- Horizontal Form -->
                    <form action="{{ route('search') }}">
                        <div class="card-body row mb-3">
                            <div class="col-md-4 mb-3">
                                <label for="" class="form-label">ICD10 : รหัสโรค</label>
                                <input type="text" class="form-control" id="" name="icd" placeholder="ระบุรหัสโรคที่ต้องการลบ">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="" class="form-label">วันที่เริ่มต้น</label>
                                <input type="text" class="form-control basicDate" id="" name="dstart" placeholder="ระบุวันที่เริ่มต้น" readonly>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="" class="form-label">วันที่สิ้นสุด</label>
                                <input type="text" class="form-control basicDate" id="" name="dended" placeholder="ระบุวันที่สิ้นสุด" readonly>
                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-success">
                                    Search Data
                                </button>
                            </div>
                        </div>
                    </form>
                    <!-- End Horizontal Form -->
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
