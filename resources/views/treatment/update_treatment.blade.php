@extends('adminlte::page')

@section('title', 'تعديل بيانات معالجة')

@section('content_header')

    <h1 class="text-center">تعديل معالجة</h1>
@stop

@section('content')

@if(isset($disease))
    <form method="post">
        {{csrf_field()}}
        @if(session('Greate'))
            <div class="alert alert-success alert-dismissible text-right">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h5><i class="icon fas fa-check"></i> تم التعديل </h5>
                لقد تم تعديل المعالجة بشكل سليم
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
                            <input type="text" name="title" value="{{$disease->title}}" id="inputName" class="form-control text-right" required>
                        </div>

                        <div class="form-group">
                            <label for="inputName">سعر المعالجة </label>
                            <input type="number" min="0"  value="{{$disease->price}}"  name="price" id="inputName" class="form-control text-left" required>
                        </div>


                    <!-- /.card-body -->
                    </div>
                </div>
                <!-- /.card -->
            </div>

        </div>
        <div class="row">
            <div class="col-12">
                <a href="#" class="btn btn-secondary">إلغاء</a>
                <input type="submit" value="تحديث" class="btn btn-success float-right">

            </div>
        </div>
    </form>
    @endif
@stop


