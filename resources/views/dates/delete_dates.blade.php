@extends('adminlte::page')

@section('title', 'حذف موعد')

@section('content')

@section('content_header')

    <h1 class="text-center">حذف موعد   💢</h1>
@stop
@if(isset($thidis) && isset($Doctor))
    <form method="post" class="text-right">
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
                <div class="card card-danger">
                    <div class="card-header">
                        <h3 class="card-title text-right">تفاصيل الموعد</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                <i class="fas fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="callout callout-danger">
                        <h5>هل أنت متأكد من حذف الموعد</h5>

                        <p class="text-right">
                            هنالك موعد للدكتور
                            <b>[  {{$Doctor->doctor_fname}}  ]</b>
                            في يوم
                            <b>(  {{date( 'd/m/Y',strtotime($thidis->what_date))}} )</b>
                            ما بين الساعة
                            <b>( {{date( 'h:i',strtotime($thidis->start_time))}} )</b>
                            والساعة
                            <b>( {{date( 'h:i',strtotime($thidis->left_time))}} )</b>
                            هل تريد حقاً حذفه ؟ 🤔
                            حيث لن تستطيع بعد الحذف استرجاع الموعد ابداً
                        </p>
                    </div>

                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>

        <!-- /.card -->

        <div class="row">
            <div class="col-12">
                <a href="/" class="btn btn-success"> العودة للرئيسية</a>
                <input name="theid" type="hidden" value="{{$thidis->id}}"/>
                <input type="submit" value=" تأكيد الحذف " class="btn btn-danger float-left">
            </div>
        </div>
    </form>
@endif
@stop



