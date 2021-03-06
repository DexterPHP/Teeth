@extends('adminlte::page')

@section('title', 'إضافة  موعد جديد')



@section('content')
@if(isset($daoctor_data))
@section('content_header')

    <h1 class="text-center"> اضافة موعد جديد  [{{$daoctor_data->doctor_fname}}]</h1>
@stop
    <form method="post">
        {{csrf_field()}}
   @if(session('message'))
            <div class="alert alert-success alert-dismissible text-right">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h5><i class="icon fas fa-stop"></i> تمت الإضافة</h5>
                لقد تمت إضافة الموعد بشكل سليم
            </div>
        @endif
        @if(session('timeoutare'))
            <div class="alert alert-warning alert-dismissible text-right">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h5><i class="icon fas fa-exclamation-triangle"></i> لم تتم الإضافة </h5>
                هناك خطأ وقت بداية الجلسة أكبر من وقت نهاية الجلسة
            </div>
        @endif
        @if(session('DateError'))
            <div class="alert alert-warning alert-dismissible text-right">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h5><i class="icon fas fa-exclamation-triangle"></i> لم تتم الإضافة </h5>
                التاريخ المدخل غير صحيح لقد اخترت موعد بتاريخ سابق
            </div>
        @endif
        @if(session('DateErrorTime'))
            <div class="alert alert-warning alert-dismissible text-right">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h5><i class="icon fas fa-exclamation-triangle"></i> لم تتم الإضافة </h5>
                موعد البداية غير صحيح الرجاء التأكد
            </div>
        @endif
        @if(session('messageError'))
            <div class="alert alert-danger alert-dismissible text-right">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h5><i class="icon fas fa-exclamation-triangle"></i> لم تتم الإضافة </h5>
                خطأ هناك موعد موجود مسبقاً بهذا التاريخ وهذا الوقت لهذا الطبيب يرجى اختيار موعد آخر
            </div>
        @endif


        <div class="row ">
            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title text-right">تفاصيل الموعد</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                <i class="fas fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="card-body  text-right">
                        <div class="form-group">
                            <label for="inputName1">المريض   </label>
                            <select class="form-control custom-select"  name="patients_id" id="e1">
                                <option selected="" value="">مريض غير مسجل  </option>
                               @if(isset($pations))
                                    @foreach($pations as $fom)
                                        <option value="{{$fom->id}}">{{$fom->username}} {{$fom->user_middel}} {{$fom->lastname}}</option>
                                    @endforeach
                                   @endif

                            </select>
                        </div>
                        <div class="form-group">
                            <label for="inputName1">عنوان للموعد  </label>
                            <input type="text" name="title" id="inputName1" class="form-control text-right" required>
                        </div>
                        <div class="form-group">
                            <label for="inputName2">يوم الموعد</label>
                            <input type="date" name="what_date" id="inputName2" class="form-control text-right " required>
                        </div>
                        <div class="form-group">
                            <label for="inputName4">وقت بداية الجلسة</label>
                            <div class='input-group date' id='datetimepicker3'>
                                <input type='text' class="form-control startTime" name="start_time" />
                                <div class="input-group-append input-group-addon" data-target="#timepicker" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="far fa-clock"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputName4">وقت انتهاء الجلسة</label>
                            <div class='input-group date' id='datetimepicker2'>
                                <input type='text' class="form-control EndTime" name="left_time" />
                                <div class="input-group-append input-group-addon" data-target="#timepicker" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="far fa-clock"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group text-right">
                            <label for="inputStatus">الأولوية</label>
                            <select class="form-control custom-select"  name="priority">
                                <option  value="0" selected="">مريض جديد</option>
                                <option value="1"> مريض محول</option>
                                <option value="2">مراجعة</option>
                                <option value="3">مستعجلة</option>
                            </select>
                        </div>
                        <input type="hidden" name="doctor_id" value="{{$daoctor_data->id}}">
                            <!-- /.form group -->
                        </div>

                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>

            <!-- /.card -->
        </div>

        <div class="row">
            <div class="col-12">
                <a href="#" class="btn btn-secondary">إلغاء</a>
                <input type="submit" value="أضف الآن" class="btn btn-success float-right">

            </div>
        </div>
    </form>
    @endif
@stop
@section('css')
    <link href="{{asset('css/bootstrap-datetimepicker.css')}}" rel="stylesheet">
@endsection
@section('js')
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
    <script src="{{asset('js/jquery-2.1.1.min.js')}}" ></script>
    <script src="{{asset('js/bootstrap.min.js')}}" ></script>
    <script src="{{asset('js/moment-with-locales.js')}}" ></script>
    <script src="{{asset('js/bootstrap-datetimepicker.js')}}" ></script>
    <script  type="text/javascript">
        $(function () {
            $("#e1").select2();
            $('#datetimepicker3,#timepicker').datetimepicker({
                format: 'LT'
            }).on('dp.change', function (e) {
                var SelectedValue = e.date.format('h:mm');
                //var ampm = e.date.format('H') < 12? 'AM' : 'PM';
                var test = e.date.format('A');
                result=addMinutesToTime(SelectedValue,30,test);
                //console.log(SelectedValue,' => ',result);
                $('.EndTime').val(result);
            });
            $('#datetimepicker2').datetimepicker({
                format: 'LT'
            });


            // Function Add Time
            function addMinutesToTime(time, minsAdd,test) {
                function z(n){
                    return (n<10? '0':'') + n;
                };
                var bits = time.split(':');
                var mins = bits[0]*60 + +bits[1] + +minsAdd;
                return z(mins%(24*60)/60 | 0) + ':' + z(mins%60)+ ' ' + test ;


            }





        });

    </script>
    <script src="{{asset('js/select2.min.js')}}"></script>
    <script  type="text/javascript">
        $(function () {$("#e1").select2();});
    </script>
    @endsection


