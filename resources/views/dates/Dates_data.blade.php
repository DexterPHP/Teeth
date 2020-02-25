@extends('adminlte::page')

@section('title', 'تعديل موعد   ')

@section('content')

@section('content_header')

    <h1 class="text-center">تعديل موعد </h1>
@stop
@if(isset($viewData))
<form method="post">
    {{csrf_field()}}
    @if(session('message'))
        <div class="alert alert-success alert-dismissible text-right">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h5><i class="icon fas fa-stop"></i> تم التحديث  </h5>
            تمت عملية التحديث بشكل سليم
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
                        <select class="form-control custom-select"  name="priority" id="e1">
                            <option {{ $viewData->patients_id == Null ? 'selected="selected"' : ''  }}>مريض غير مسجل  </option>
                            @if(isset($allPeation))
                                @foreach($allPeation as $fom)
                                    <option {{ $viewData->patients_id == $fom->id  ? 'selected="selected"' : '' }} value="{{$fom->id}}">{{$fom->username}} {{$fom->user_middel}} {{$fom->lastname}}</option>
                                @endforeach
                            @endif

                        </select>
                    </div>
                    <div class="form-group">
                        <label for="inputName1">عنوان للموعد  </label>
                        <input type="text" value="{{$viewData->title}}" name="title" id="inputName1" class="form-control text-right" required>
                    </div>
                    <div class="form-group">
                        <label for="inputName2">يوم الموعد</label>
                        <input type="date" value="{{date('Y-m-d', strtotime($viewData->what_date))}}" name="what_date" id="inputName2" class="form-control text-right " required>
                    </div>
                    <div class="form-group">
                        <label for="inputName4">وقت بداية الجلسة</label>
                        <div class='input-group date' id='datetimepicker3'>
                            <input type='text' value="{{$viewData->start_time}}" class="form-control" name="start_time" />
                            <div class="input-group-append input-group-addon" data-target="#timepicker" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="far fa-clock"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputName4">وقت انتهاء الجلسة</label>
                        <div class='input-group date' id='datetimepicker3'>
                            <input type='text'  value="{{$viewData->left_time}}" class="form-control" name="left_time" />
                            <div class="input-group-append input-group-addon" data-target="#timepicker" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="far fa-clock"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group text-right">
                        <label for="inputStatus">الأولوية</label>
                        <select class="form-control custom-select"  name="priority">
                            <option {{$viewData->priority == '#17a2b8' ? 'selected' : ''}} value="0" >جديدة</option>
                            <option {{$viewData->priority == '#007bff'? 'selected' : ''}} value="1">زيارة مريض</option>
                            <option {{$viewData->priority == '#ffc107' ? 'selected' : ''}} value="2">مراجعة</option>
                            <option {{$viewData->priority == '#dc3545' ? 'selected' : ''}} value="3">مستعجلة</option>
                        </select>
                    </div>
                    <input type="hidden" name="doctor_id" value="{{$doctorid}}">
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
            <a class="btn btn-danger float-left"  onclick="return confirm('هل أنت متأكد من حذف هذا الموعد?')" href="{{route('delete_dates', $viewData->uuid)}}"><i class="fa fa-trash"></i> حذف</a>
            <input type="submit" value=" تحديث الموعد" class="btn btn-success float-right">

        </div>
    </div>
</form>
@endif
@stop
@section('css')
    <link href="//cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/build/css/bootstrap-datetimepicker.css" rel="stylesheet">
@endsection
@section('js')
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
    <script type="text/javascript" src="//code.jquery.com/jquery-2.1.1.min.js"></script>
    <script type="text/javascript" src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js"></script>
    <script src="//cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/src/js/bootstrap-datetimepicker.js"></script>
    <script  type="text/javascript">
        $(function () {
            $('#datetimepicker3,#timepicker').datetimepicker({
                format: 'LT'
            });
        });


    </script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
    <script  type="text/javascript">
        $(function () {$("#e1").select2();});
    </script>
@endsection


