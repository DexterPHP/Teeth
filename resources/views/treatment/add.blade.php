@extends('adminlte::page')

@section('title', 'إضافة  نوع معالجة جديد')

@section('content_header')

    <h1 class="text-center">إضافة نوع معالجة جديد</h1>
@stop

@section('content')


    <form method="post">
        {{csrf_field()}}
        @if(session('Greate'))
            <div class="alert alert-success alert-dismissible text-right">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h5><i class="icon fas fa-check"></i> تمت الإضافة</h5>
                لقد تمت إضافة المركز بشكل سليم
            </div>
        @endif
        @if(session('exsist'))
            <div class="alert alert-danger alert-dismissible text-right">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h5><i class="icon fas fa-check"></i>  خطأ</h5>
                لم تتم اللإضافة فنوع المعالجة هذا موجود مسبقاً
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
                            <label for="inputName"> عنوان المعالجة </label>
                            <input type="text" name="title" id="inputName" class="form-control text-right" required>
                        </div>

                        <div class="form-group">
                            <label for="inputName">سعر المعالجة </label>
                            <input type="number" min="0" name="price" id="inputName" class="form-control text-left" required>
                        </div>

                    @if(isset($Admin) and $Admin = true)

                            <div class="form-group">
                                <label for="inputStatus">المركز</label>
                                <select class="form-control custom-select text-right" name="center_id" id="e1" required>
                                    <option selected disabled>الرجاء الإختيار</option>
                                    @foreach($center as $centerx)
                                        <option  value="{{$centerx->id}}" class="form-control text-right">{{$centerx->center_name}}</option>
                                     @endforeach
                                 </select>
                            </div>
                        </div>
                    @else
                        <input type="hidden" name="center_id" value="{{ $center }}" />
                    @endif
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


