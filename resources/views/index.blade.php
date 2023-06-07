@extends('layouts.app')
@section('content')
<section class="section">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="fa-solid fa-house-chimney-medical"></i>
                        WDHP-ex.MODULE :: ระบบเสริมสำหรับ รพ.สต. (JHCIS)
                    </h5>
                    <div class="col-md-12">
                        <nav style="--bs-breadcrumb-divider: '-';">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item active">หน้าหลัก</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Tele-Consult</h5>
                                    <p class="card-text">ระบบปรึกษาแพทย์ทางไกล</p>
                                    <a href="{{ route('consult') }}" class="card-link">
                                        <i class="fa-solid fa-right-to-bracket"></i>
                                        ใช้งานระบบ
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Data-Correct</h5>
                                    <p class="card-text">ระบบตรวจสอบข้อมูลผู้ป่วยกลุ่ม NCD</p>
                                    <a href="{{ route('datacorrect') }}" class="card-link">
                                        <i class="fa-solid fa-right-to-bracket"></i>
                                        ใช้งานระบบ
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Data-Correct [สสจ.เชียงใหม่]</h5>
                                    <p class="card-text">ระบบตรวจสอบข้อมูลผู้ป่วยกลุ่ม NCD</p>
                                    <a href="https://datacorrect.chiangmaihealth.go.th/" target="_blank" class="card-link">
                                        <i class="fa-solid fa-right-to-bracket"></i>
                                        ใช้งานระบบ
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Data-Correct</h5>
                                    <p class="card-text">โปรแกรมปรับปรุงข้อมูล</p>
                                    <a href="https://ayo.moph.go.th/main/file_upload/downloads/ManualDataCorrect.pdf" target="_blank" class="card-link">
                                        <i class="fa-regular fa-circle-question"></i>
                                        คู่มือ
                                    </a>
                                    <a href="https://ayo.moph.go.th/main/index.php?mod=Downloads&file=index&op=downloadsDetail&id=cd673052fd4a736d83244b78a19414f" target="_blank" class="card-link">
                                        <i class="fa-solid fa-download"></i>
                                        ดาวน์โหลด
                                    </a>
                                </div>
                            </div>
                        </div>
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
