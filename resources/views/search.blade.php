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
                                    <i class="fa-solid fa-search"></i>
                                    SearchData
                                </button>
                            </div>
                        </div>
                    </form>
                    <!-- End Horizontal Form -->
                    <div class="card-body col-md-12">
                        <table id="tableSelect" class="table table-striped table-borderless">
                            <thead>
                                <tr>
                                    <th class="text-center"><i class="fa-solid fa-check-circle text-success"></i></th>
                                    <th class="text-center">VISIT:DATE</th>
                                    <th class="text-center">VISIT:NO</th>
                                    <th>CID</th>
                                    <th>PID</th>
                                    <th>PATIENT</th>
                                    <th class="text-center">DIAG</th>
                                    {{-- <th>NOTE</th> --}}
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
                                    {{-- <td>{{ $res->symptoms }}</td> --}}
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="col-md-12">
                            <button id="btn_del" class="btn btn-danger"><i class="fa-solid fa-trash"></i> ลบรายการที่เลือก</button>
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
         // DATATABLES
        $(document).ready(function () {
            var table = $('#tableSelect').DataTable({
                lengthMenu: [
                    [10, 25, 50, -1],
                    [10, 25, 50, "All"]
                ],
                columnDefs: [ {
                    orderable: false,
                    className: 'select-checkbox',
                    targets:   0
                } ],
                select: {
                    style: 'multi',
                    selector: 'td:first-child'
                },
                language: {
                    select: {
                        rows: {
                            _: "<small class='text-danger'>เลือกแล้ว %d รายการ</small>",
                        }
                    }
                },
                rowReorder: {
                    selector: 'td:nth-child(2)'
                },
                ordering: false,
                responsive: true,
                oLanguage: {
                    oPaginate: {
                        sFirst: '<small>หน้าแรก</small>',
                        sLast: '<small>หน้าสุดท้าย</small>',
                        sNext: '<small>ถัดไป</small>',
                        sPrevious: '<small>กลับ</small>'
                    },
                sSearch: '<small><i class="fa fa-search"></i> ค้นหา</small>',
                sInfo: '<small>ทั้งหมด _TOTAL_ รายการ</small>',
                sLengthMenu: '<small>แสดง _MENU_ รายการ</small>',
                sInfoEmpty: '<small>ไม่มีข้อมูล</small>',
                sInfoFiltered: '<small>(ค้นหาจาก _MAX_ รายการ)</small>',
                },
            });

        $('#tableSelect tbody').on('click', 'tr', function () {
            $(this).toggleClass('selected');
        });

        $('#btn_del').click( function () {
            var token = "{{ csrf_token() }}";
            var array = [];
            table.rows('.selected').every(function(rowIdx) {
                array.push(table.row(rowIdx).data())
            })
            var formData = array;

        Swal.fire({
            title: 'ยืนยันการลบรายการ',
            text: 'หากลบข้อมูลแล้ว จะไม่สามารถนำกลับได้อีก',
            showCancelButton: true,
            confirmButtonText: `ยืนยัน`,
            cancelButtonText: `ยกเลิก`,
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url:"{{ route('delete') }}",
                    method:'GET',
                    data:{formData: formData,_token: token},
                    success:function(data)
                    {
                        let timerInterval
                            Swal.fire({
                            title: 'กำลังลบรายการ',
                            timer: 2000,
                            timerProgressBar: true,
                            didOpen: () => {
                                Swal.showLoading()
                                timerInterval = setInterval(() => {
                                const content = Swal.getContent()
                                if (content) {
                                    const b = content.querySelector('b')
                                    if (b) {
                                    b.textContent = Swal.getTimerLeft()
                                    }
                                }
                                }, 100)
                            },
                            willClose: () => {
                                clearInterval(timerInterval)
                            }
                            }).then((result) => {
                            if (result.dismiss === Swal.DismissReason.timer) {
                                    Swal.fire({
                                    icon: 'success',
                                    title: 'ลบรายการสำเร็จ',
                                    showConfirmButton: false,
                                    timer: 3000
                                })
                                window.setTimeout(function () {
                                    location.reload()
                                }, 3500);
                            }
                        })
                    }
                });
            }
        })
    });
});
</script>
@endsection
