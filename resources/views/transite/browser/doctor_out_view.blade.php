@extends('adminlte::page')

@section('title', 'محاسبة |استعراض العمليات المحاسبية')

@section('content_header')
    <h1 class="text-center">مسحوبات طبيب

    </h1>
@stop

@section('content')
    @if(session('nowtrans'))
        <div class="alert alert-success alert-dismissible text-right">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h5><i class="icon fas fa-check"></i>فارغ </h5>
            لا يوجد ضمن مجال البحث هذا
        </div>
    @endif
    <form method="post" dir="rtl" @if(isset($data)) style="display: none" @endif>
        {{csrf_field()}}
        <div class="row">
            <div class="col-md-12 text-right">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title float-right"> الطبيب</h3>

                    </div>
                    <div class="card-body text-right">
                        <div class="form-group">
                            <label>نحديد مجال البحث
                                البداية || النهاية
                            </label>

                            <div class="input-group">
                                <div class="input-group-prepend">
                                  <span class="input-group-text">
                                    <i class="far fa-calendar-alt"></i>
                                  </span>
                                </div>
                                <input type="text" class="form-control float-right" id="reservation" name="dates" required />
                            </div>
                            <!-- /.input group -->
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <a href="#" class="btn btn-secondary">إلغاء</a>
                <input type="submit" value="عرض" class="btn btn-success float-right">

            </div>
        </div>
    </form>


    @if(isset($data))
        <div class="row">
            <div class="col-md-4 col-sm-6 col-12">
                <div class="info-box">
                    <span class="info-box-icon bg-info"><i class="far fa-envelope"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">المجموع</span>
                        <span class="info-box-number">{{$data->All}}</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->

        </div>
        <br />
        <table id="example" class="table table-striped table-bordered display text-center" style="width:100%">
            <thead>
            <tr>
                <th> التاريخ والوقت</th>
                <th>  المريض</th>
                <th> المبلغ </th>
                <th>  المدخل</th>
                <th> الملاحظة </th>
                <th>اسم الطبيب </th>
                <th>رقم   </th>
            </tr>
            </thead>
            <tbody>
            @php $i=1; @endphp
            @foreach($data as $transdata)
                <tr>
                    <td>{{  date( 'd/m/Y - h:i A',strtotime($transdata->created_at))}}</td>
                    <td>{{ $transdata->patients_id }}</td>
                    <td>{{ $transdata->Amount }} </td>
                    <td>{{ $transdata->user_id }}</td>
                    <td>{{ $transdata->notes }} </td>
                    <td>{{ $transdata->doctor_id }} </td>
                    <td>{{ $i }} </td>
                    @php $i=$i+1; @endphp
                </tr>
            @endforeach

            </tbody>
            <tfoot>
            <tr>
                <th> التاريخ والوقت</th>
                <th>  المريض</th>
                <th> المبلغ </th>
                <th>  المدخل</th>
                <th> الملاحظة </th>
                <th>اسم الطبيب </th>
                <th>رقم   </th>
            </tr>
            </tfoot>
        </table>



@section('js')
    <script src="{{asset('js/jquery-3.3.1.js')}}" ></script>
    <script src="{{asset('js/jquery.dataTables.min.js')}}" ></script>
    <script src="{{asset('js/dataTables.bootstrap4.min.js')}}" ></script>
    <script src="{{asset('js/dataTables.buttons.min.js')}}" ></script>
    <script src="{{asset('js/buttons.flash.min.js')}}" ></script>
    <script src="{{asset('js/jszip.min.js')}}" ></script>
    <script src="{{asset('js/pdfmake.min.js')}}" ></script>
    <script src="{{asset('js/vfs_fonts.js')}}" ></script>
    <script src="{{asset('js/buttons.html5.min.js')}}" ></script>
    <script src="{{asset('js/buttons.print.min.js')}}" ></script>
    <script>
        $(document).ready(function() {
            $('#example').DataTable( {
                dom: 'Bfrtip',
                buttons: [
                    'copyHtml5',
                    'excelHtml5'
                ]
            } );
        } );
    </script>
@stop
@endif

@stop
@section('css')
    <link href="{{asset('css/bootstrap.css')}}" />
    <link href="{{asset('css/dataTables.bootstrap4.min.css')}}" />
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



