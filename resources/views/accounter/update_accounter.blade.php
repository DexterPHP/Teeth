@extends('adminlte::page')

@section('title', 'تعديل محاسب  ')

@section('content_header')

    <h1 class="text-center">تعديل محاسب </h1>
@stop

@section('content')
@if(isset($accounter_data_is))
    <form method="post">
        {{ csrf_field() }}



        @if(session('done'))
            <div class="alert alert-success alert-dismissible text-right">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h5><i class="icon fas fa-check"></i> تم التعديل</h5>
                لقد تم تعديل بيانات المحاسب بشكل سليم
            </div>
        @endif

        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title text-right">معلومات المحاسب</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool text-right" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                <i class="fas fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="card-body  text-right">
                        <div class="form-group">
                            <label for="inputName">أسم المحاسب </label>
                            <input type="text" name="accounter_fname" value="{{ $accounter_data_is->accounter_fname }}" id="inputName" class="form-control text-right" required>
                        </div>

                        <div class="form-group">
                            <label for="inputName"> رقم الهاتف</label>
                            <input type="tele" name="accounter_phone" value="{{ $accounter_data_is->accounter_phone }}"  id="inputName  text-right" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="inputStatus">المراكز</label>
                            <select class="form-control custom-select text-right" name="center_id">
                                <option  disabled>الرجاء الختيار</option>
                                @foreach($centersx as $center)
                                    <option @if($accounter_data_is->center_id == $center->id ) selected @endif value="{{$center->id}}">{{$center->center_name}}</option>
                                @endforeach

                            </select>
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
    @endif
@stop

