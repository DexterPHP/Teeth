@extends('adminlte::page')

@section('title', 'محاسبة | العمليات المحاسبية')

@section('content_header')
    <h1 class="text-center">اختيار نوع الأجراء المحاسبي
        ( {{$center->center_name}} )
    </h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title text-right">صندوق    {{$center->center_name}}</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                            <i class="fas fa-minus"></i></button>
                    </div>
                </div>
                <div class="card-body  text-center">
                    <!-- small card -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>أيداع</h3>

                            <p>صندوق</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-balance-scale-right"></i>
                        </div>
                        <a href="center/income/{{$center->uuid}}" class="small-box-footer">
                            تنفيذ <i class="fas fa-arrow-circle-down"></i>
                        </a>
                    </div>
                    <!-- small card -->
                    <div class="small-box bg-danger">
                        <div class="icon left">
                            <i class="fas fa-balance-scale-left"></i>
                        </div>
                        <div class="inner">
                            <h3>سحب</h3>
                            <p>صندوق</p>
                        </div>

                        <a href="center/expense/{{$center->uuid}}" class="small-box-footer">
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
                    <h3 class="card-title">أطباء  {{$center->center_name}}</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                            <i class="fas fa-minus"></i></button>
                    </div>
                </div>
                <div class="card-body text-center">
                    <!-- small card -->
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>أيداع</h3>

                            <p>في حساب الطبيب
                                {{$doctor->doctor_fname}}
                            </p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-balance-scale-right"></i>
                        </div>
                        <a href="doctors/income/push/{{$doctor->uuid}}" class="small-box-footer">
                            تنفيذ <i class="fas fa-arrow-circle-down"></i>
                        </a>
                    </div>
                    <!-- small card -->
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>سحب</h3>

                            <p>في حساب الطبيب
                                {{$doctor->doctor_fname}}
                            </p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-balance-scale-left"></i>
                        </div>
                        <a href="doctors/expense/pull/{{$doctor->uuid}}" class="small-box-footer">
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

@stop
