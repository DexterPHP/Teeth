@extends('adminlte::page')

@section('title', ' تعديل الطبيب')

@section('content_header')
    <h1 class="text-center">{{$daoctor->doctor_fname}}   تعديل الطبيب</h1>
@stop

@section('content')

    <form method="post">
        {{csrf_field()}}
   @if(session('message'))
            <div class="alert alert-success alert-dismissible text-right">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h5><i class="icon fas fa-check"></i> تمت الإضافة</h5>
                لقد تمت إضافة الطبيب بشكل سليم
            </div>
   @endif
        @if(session('messageError'))
            <div class="alert alert-warning alert-dismissible text-right">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h5><i class="icon fas fa-check"></i> لم تتم الإضافة </h5>
                إن اسم المستخدم قيد الأستخدام وموجود من قبل
            </div>
        @endif
        <div class="row">
            <div class="col-md-6">
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
                            <label for="inputName">أسم الطبيب </label>
                            <input type="text" name="doctor_fname" value="{{$daoctor->doctor_fname}}" id="inputName" class="form-control text-right" required>
                        </div>
                        <div class="form-group">
                            <label for="inputName">أسم المستخدم للطبيب </label>
                            <input type="text" name="doctor_username" value="{{$daoctor->doctor_username}}" id="inputName" class="form-control text-right" required>
                        </div>
                        <div class="form-group">
                            <label for="inputName"> رقم الهاتف</label>
                            <input type="tele" name="doctor_mobile" value="{{$daoctor->doctor_mobile}}" id="inputName" class="form-control text-right" >
                        </div>


                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <div class="col-md-6">
                <div class="card card-secondary">
                    <div class="card-header">
                        <h3 class="card-title">معلومات إضافية</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                <i class="fas fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="card-body text-right">


                        <div class="form-group">
                            <label for="inputEstimatedBudget">التخصص </label>
                            <input type="text" name="doctor_spicalest" value="{{$daoctor->doctor_spicalest}}" id="inputEstimatedBudget" class="form-control text-right" required>
                        </div>


                        <div class="form-group">
                            <label for="inputStatus">المحاسب</label>
                            <select class="form-control custom-select "  name="doctoe_accounter">
                                <option value="0" selected>لا يوجد</option>
                                @foreach($acc as $accounter)
                                    <option @if($daoctor->doctor_spicalest == $accounter->id) selected @endif value="{{$accounter->id}}" >{{$accounter->accounter_fname}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="inputStatus">المركز</label>
                            <select class="form-control custom-select"  name="center_id">

                                @foreach($doc as $center)
                                    <option @if($daoctor->center_id == $center->id) selected @endif value="{{$center->id}}" >{{$center->center_name}}</option>
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
                <input type="submit" value="تعديل الآن" class="btn btn-success float-right">

            </div>
        </div>
    </form>
@stop
