@extends('layouts.app')
@section('content')
<section class="section">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="far fa-clipboard"></i>
                        Consult Form :: ระบุข้อมูลขอคำปรึกษาจากแพทย์
                    </h5>
                    <div class="col-md-12">
                        <nav style="--bs-breadcrumb-divider: '-';">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ url('/') }}">หน้าหลัก</a></li>
                                <li class="breadcrumb-item active">ระบุข้อมูลขอคำปรึกษาจากแพทย์</li>
                            </ol>
                        </nav>
                    </div>
                    <!-- Horizontal Form -->
                    <form>
                        <div class="card-body row mb-3">
                            <label for="" class="col-sm-2 col-form-label">
                                <span class="text-danger">*</span>
                                ระบุหมายเลข VISIT
                            </label>
                            <div class="input-group mb-2 mr-sm-2">
                                <input id="vstno" name="vstno" type="text" class="form-control"
                                    value="{{ old('vstno') }}"
                                    placeholder="Visit No ของผู้มารับบริการจาก JHCIS"
                                    >
                                <div class="input-group-text">
                                    <a id="vn_find" type="button" style="font-size: 1rem;">
                                        <small class="text-muted">
                                            <i class="fa-solid fa-search"></i> ค้นหา
                                        </small>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="visit"></div>
                            <br>
                            <table id="dx" class="table table-striped" border="1" hidden>
                                <thead>
                                    <tr>
                                        <th class="text-center">รหัสโรค</th>
                                        <th>คำอธิบาย</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                            <table id="drug" class="table table-striped" border="1" hidden>
                                <thead>
                                    <tr>
                                        <th class="" style="">รายการ</th>
                                        <th class="" style="">คำอธิบาย</th>
                                        <th class="text-center" style="">Unit</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                        <div class="card-body" id="txtnote" hidden>
                            <label for="">
                                Text Note
                            </label>
                            <textarea class="form-control" style="height: 100px"></textarea>
                        </div>
                        <div class="card-body" id="txtlevel" hidden>
                            <label for="">
                                ระดับความเร่งด่วน
                            </label>
                            <select name="" class="form-select">
                                <option>----- กรุณาเลือก -----</option>
                                <option value="Normal">ปกติ</option>
                                <option value="Fast">เร่งด่วน</option>
                                <option value="Emergency">ฉุกเฉิน</option>
                            </select>
                        </div>
                        <div class="card-body text-end" id="btn" hidden>
                            <a href="#" class="btn btn-success">
                                <i class="fas fa-check"></i>
                                ส่งข้อมูล Consult
                            </a>
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
    $('#vn_find').click(function () {
        var vn = document.getElementById("vstno").value;
        Swal.fire({
            title: 'กำลังค้นหาข้อมูล VN: '+ vn,
            timerProgressBar: true,
            didOpen: () => {
                Swal.showLoading()
                const b = Swal.getHtmlContainer().querySelector('b')
            },
        }).then((result) => {
            if (result.dismiss === Swal.DismissReason.timer) {}
        })
        $.ajax({
            url: "api/visit/" + vn,
            success: function (result) {
                document.getElementById("txtnote").hidden = false;
                document.getElementById("txtlevel").hidden = false;
                document.getElementById("btn").hidden = false;
                if ($.trim(result)) {
                    Swal.fire({
                        icon: 'success',
                        title: 'พบข้อมูล VN: ' + vn,
                        text: result.prename + result.fname + " " + result.lname,
                        showConfirmButton: false,
                        timer: 2000
                    })
                }
                $('.visit').html("");
                const json_date = new Date(result.visitdate);
                        function formatDate(date) {
                            var d = new Date(date),
                                month = '' + (d.getMonth() + 1),
                                day = '' + d.getDate(),
                                year = d.getFullYear() + 543;

                            if (month.length < 2) 
                                month = '0' + month;
                            if (day.length < 2) 
                                day = '0' + day;
                            return [day, month, year].join('/');
                        }
                vstdate = formatDate(json_date);
                
                var row =
                    $(
                    '<h4 style="font-weight:bold;" class="text-center"><i class="fas fa-user-circle"></i> '+ result.prename + result.fname +" "+ result.lname +'</h4>' +
                    '<h5 class="text-center"><i class="fas fa-calendar-check text-success"></i> '+ vstdate +'</h5>' +
                    '<p style="font-weight:bold;">' +
                        '<i class="fa-solid fa-heart-pulse text-danger"></i> ' +
                        'Vital Sign' + 
                    '</p>' +
                    '<div class="row">' +
                        '<div class="col-md-6">' +
                            '<ul class="list-group">' +
                                '<li class="list-group-item d-flex justify-content-between align-items-center">' +
                                    'ความดัน' +
                                    '<span style="font-weight:bold;">'+ result.pressure +'</span>' +
                                '</li>' +
                                '<li class="list-group-item d-flex justify-content-between align-items-center">' +
                                    'อุณหภูมิ' +
                                    '<span style="font-weight:bold;">'+ result.temperature +'</span>' +
                                '</li>' +
                                '<li class="list-group-item d-flex justify-content-between align-items-center">' +
                                    'ชีพจร' +
                                    '<span style="font-weight:bold;">'+ result.pulse +'</span>' +
                                '</li>' +
                            '</ul>' +
                        '</div>' + 
                        '<div class="col-md-6">' +
                            '<ul class="list-group">' +
                                '<li class="list-group-item d-flex justify-content-between align-items-center">' +
                                    'RR' +
                                    '<span style="font-weight:bold;">'+ result.respri +'</span>' +
                                '</li>' +
                                '<li class="list-group-item d-flex justify-content-between align-items-center">' +
                                    'น้ำหนัก' +
                                    '<span style="font-weight:bold;">'+ result.weight +'</span>' +
                                '</li>' +
                                '<li class="list-group-item d-flex justify-content-between align-items-center">' +
                                    'ส่วนสูง' +
                                    '<span style="font-weight:bold;">'+ result.height +'</span>' +
                                '</li>' +
                            '</ul>' +
                        '</div>' +
                    '</div>' +
                    '<br>' +
                    '<p style="font-weight:bold;">' +
                        '<i class="fa-solid fa-clipboard text-primary"></i> ' +
                        'อาการสำคัญ' +
                    '</p>' +
                    '<div class="row">' +
                        '<div class="col-md-12">' +
                            '<ul class="list-group">' +
                                '<li class="list-group-item d-flex justify-content-between align-items-center">' +
                                    '<span style="font-weight:bold;">'+ result.symptoms +'</span>' +
                                '</li>' +
                            '</ul>' +
                        '</div>' +
                    '</div>'
                    );
                $('.visit').append(row);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                Swal.fire({
                    icon: 'error',
                    title: 'ไม่สามารถเชื่อมต่อ API ได้',
                    text: 'Error: ' + textStatus + ' - ' + errorThrown,
                })
            }
        });

        $.ajax({
            url: "api/diag/" + vn,
            success: function (data) {
                document.getElementById("dx").hidden = false;
                $("#dx tbody").html("");
                for (var i = 0; i < data.length; i++) {
                var row =
                    $(
                        '<tr>'+
                            '<td class="text-center">' + data[i].diagcode + '</td>' +
                            '<td>' + data[i].diseasenamethai + '</td>' +
                        '</tr>'
                    );
                    $('#dx').append(row);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                Swal.fire({
                    icon: 'error',
                    title: 'ไม่สามารถเชื่อมต่อ API ได้',
                    text: 'Error: ' + textStatus + ' - ' + errorThrown,
                })
            }
        });

        $.ajax({
            url: "api/drug/" + vn,
            success: function (data) {
                document.getElementById("drug").hidden = false;
                $("#drug tbody").html("");
                for (var i = 0; i < data.length; i++) {
                var row =
                    $(
                        '<tr>'+
                            '<td class="">' + data[i].drugname + '</td>' +
                            '<td class="">' + data[i].dose + '</td>' +
                            '<td class="text-center">' + data[i].unit + '</td>' +
                        '</tr>'
                    );
                    $('#drug').append(row);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                Swal.fire({
                    icon: 'error',
                    title: 'ไม่สามารถเชื่อมต่อ API ได้',
                    text: 'Error: ' + textStatus + ' - ' + errorThrown,
                })
            }
        });
    });
</script>
@endsection
