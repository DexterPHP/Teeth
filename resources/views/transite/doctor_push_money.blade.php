@extends('adminlte::page')

@section('title', 'إضافة مبلغ لصندوق المركز')

@if(isset($DoctorData))
@section('content_header')
    <h1 class="text-center">أيداع مال في حساب طبيب
    <b class="text-danger">{{$DoctorData->doctor_fname}}</b>
    </h1>
    <h3 class="text-center text-center">
       في حساب الطبيب
        <b class="text-warning">{{$DoctorData->moneybox}}</b> ليرة سورية
    </h3>
    <h4 class="text-center">نوع العملية الحسابية
        <b class="text-blue">أيداع</b>
    </h4>


@stop

@section('content')
    <form method="post">
        {{csrf_field()}}
        @if(session('Greate'))
            <div class="alert alert-success alert-dismissible text-right">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h5><i class="icon fas fa-check"></i> تمت الإضافة</h5>
                لقد تمت أضافة المبلغ بشكل سليم
            </div>
        @endif
        @if(session('WithError'))
            <div class="alert alert-warning alert-dismissible text-right">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h5><i class="icon fas fa-check"></i> توقف </h5>
                لقد حصل خطأ في تسجيل هذه العملية
            </div>
        @endif


        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title text-right">بيانات </h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                <i class="fas fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="card-body  text-right">
                        <div class="form-group">
                            <label for="inputName">المبلغ  </label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">ليرة سورية</span>
                                </div>
                                <input type="number" name="howchange" id="inputName" class="form-control text-right" required>
                                <div class="input-group-append">
                                    <span class="input-group-text">.00</span>
                                    <input type="hidden" value="{{$DoctorData->uuid}}" name="center_id" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputStatus">المريض</label>
                            <select class="form-control custom-select" name="Patieon_id" id="e1">
                                <option  disabled>الرجاء الأختيار</option>
                                <option value="">لا يوجد</option>
                                @foreach($Patiens as $Patien)
                                    <option value="{{$Patien->id}}" >{{$Patien->username}} {{$Patien->user_middel}} {{$Patien->lastname}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="inputName">ملاحظة  </label>
                            <input type="text" name="notes" id="inputName" class="form-control text-right" required>
                        </div>

                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>

        </div>
        <div class="row">
            <div class="col-12">
                <a href="/" class="btn btn-danger">إلغاء</a>
                <input type="submit" value="إضافة إلى حساب الطبيب " class="btn btn-success float-right">
            </div>
        </div>
    </form>
@stop
@section('js')
    <script>
        $(document).ready(function() {
            $("#e1").select2();
        });
    </script>
@stop
@endif

