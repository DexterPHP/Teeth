@extends('adminlte::page')

@section('title', 'محاسبة |استعراض العمليات المحاسبية')

@section('content_header')
    <h1 class="text-center">استعراض حركات المحاسبة التي تمت في
{{ $center->center_name }}
    </h1>
@stop

@section('content')


    <div class="row">
        <div class="col-md-6">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title text-right">صندوق المركز </h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                            <i class="fas fa-minus"></i></button>
                    </div>
                </div>
                <div class="card-body  text-center">
                    <!-- small card -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>مدخلات مركز</h3>

                            <p>صندوق</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-balance-scale-right"></i>
                        </div>
                        <a href="center/in/{{$center->uuid}}" class="small-box-footer">
                            تنفيذ <i class="fas fa-arrow-circle-down"></i>
                        </a>
                    </div>
                    <!-- small card -->
                    <div class="small-box bg-danger">
                        <div class="icon left">
                            <i class="fas fa-balance-scale-left"></i>
                        </div>
                        <div class="inner">
                            <h3>مسحوبات مركز</h3>
                            <p>صندوق</p>
                        </div>

                        <a href="center/out/{{$center->uuid}}" class="small-box-footer">
                            تنفيذ <i class="fas fa-arrow-circle-up"></i>
                        </a>
                    </div>

                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <div class="col-md-6">
            <div class="card card-secondary">
                <div class="card-header">
                    <h3 class="card-title">أطباء </h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                            <i class="fas fa-minus"></i></button>
                    </div>
                </div>
                <div class="card-body text-center">

                    <!-- small card -->
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>مدخلات طبيب</h3>

                            <p>{{$doctor->doctor_fname}} </p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-balance-scale-right"></i>
                        </div>
                        <a href="doctors/in/push/{{$doctor->uuid}}" class="small-box-footer">
                            تنفيذ <i class="fas fa-arrow-circle-down"></i>
                        </a>
                    </div>
                    <!-- small card -->
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>مسحوبات طبيب</h3>

                            <p>{{$doctor->doctor_fname}}</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-balance-scale-left"></i>
                        </div>
                        <a href="doctors/out/pull/{{$doctor->uuid}}" class="small-box-footer">
                            تنفيذ <i class="fas fa-arrow-circle-up"></i>
                        </a>
                    </div>



                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>

@stop

@section('js')
    <!-- Page script -->
    <script>
        $(function () {
            $('#reservation').daterangepicker({
                timePicker: false,
                locale: 'ar',
                "showWeekNumbers": true,
                "showISOWeekNumbers": true,
                "autoApply": true,

                ranges: {
                    'اليوم': [moment(), moment()],
                    'الأمس': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'اخر 7 أيام': [moment().subtract(6, 'days'), moment()],
                    ' اخر 30 يوما ': [moment().subtract(29, 'days'), moment()],
                    'هذا الشهر': [moment().startOf('month'), moment().endOf('month')],
                    'الشهر الماضي': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                },
                showDropdowns: true,
                timePickerIncrement: 60,
                opens: 'left',
                locale: {
                    format: 'YYYY-MM-DD',
                    "applyLabel": "Apply",
                    "separator": " || ",
                    "applyLabel": "موافق",
                    "cancelLabel": "إلغاء",
                    "fromLabel": "من",
                    "toLabel": "إلى",
                    "customRangeLabel": "Custom",
                    "weekLabel": "W",
                    "daysOfWeek": [
                        "الأحد",
                        "الاثنين",
                        "الثلاثاء",
                        "الأربعاء",
                        "الخميس",
                        "الجمعة",
                        "السبت"
                    ],
                    "monthNames": [
                        "كانون ثاني",
                        "شباط",
                        "آذار",
                        "نيسان",
                        "أيار",
                        "حزيران",
                        "تموز",
                        "أب",
                        "أيلول",
                        "تشرين أول",
                        "تشرين ثاني",
                        "كانون أول"
                    ],

                },

            })
        });
    </script>

@stop

