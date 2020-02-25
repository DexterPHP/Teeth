
@extends('adminlte::page')

@section('title', 'إضافة مخبر جديد')

@section('content_header')

    <h1 class="text-center">إضافة مخبر جديد</h1>
@stop

@section('content')

    <form method="post" dir="rtl">{{csrf_field()}}

        @if(session('message'))
            <div class="alert alert-success alert-dismissible text-right">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h5><i class="icon fas fa-check"></i> تمت الإضافة</h5>
                لقد تمت إضافة المريض بشكل سليم
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-warning alert-dismissible text-right">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h5><i class="icon fas fa-check"></i> لم تتم الإضافة </h5>
                اسم المركز موجود أو رقم الهاتف امدخل موجود لمركز آخر
            </div>
        @endif
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title text-right">معلومات أساسية</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                <i class="fas fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="card-body  text-right">
                        <div class="form-group">
                            <label for="inputName">أسم المخبر </label>
                            <input type="text" name="lab_name" id="inputName" class="form-control text-right" required>
                        </div>
                        <div class="form-group">
                            <label for="inputName">اختصاص المركز  </label>
                            <input type="text" name="lab_spi" id="inputName" class="form-control text-right" required>
                        </div>
                        <div class="form-group">
                            <label for="inputName"> هاتف المخبر</label>
                            <input type="text" name="lab_phone" id="inputName" class="form-control text-right" required>
                        </div>
                        <div class="form-group">
                            <label for="inputDescription">عنوان المخبر</label>
                            <input type="text" name="lab_location" id="inputName" class="form-control text-right" required>
                        </div>

                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>

        </div>
        <div class="row">
            <div class="col-12">
                <a href="#" class="btn btn-secondary">إلغاء</a>
                <input type="submit" value="أضف الآن" class="btn btn-success float-right">

            </div>
        </div>
    </form>
@stop

