@extends('adminlte::page')

@section('title', 'إضافة سجل جديد')

@section('content_header')

    <h1 class="text-center">إضافة سجل جديد</h1>
@stop

@section('content')
@if(isset($user_data))
    <form method="post" dir="rtl">
        {{csrf_field()}}
        @if(session('message'))
            <div class="alert alert-success alert-dismissible text-right">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h5><i class="icon fas fa-check"></i> تمت الإضافة</h5>
                لقد تمت إضافة سجل جديد للمريض بشكل سليم
            </div>
        @endif
        @if(session('totalError'))
            <div class="alert alert-danger alert-dismissible text-right">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h5><i class="icon fas fa-eraser"></i>خطأ </h5>
                رصيد المريض موجب وانت تدخل دفعة أكبر من المبلغ المطلوب
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
                            <label for="inputName">أسم المريض </label>
                            <input type="text"  value="{{$user_data->username}} {{$user_data->user_middel}} {{$user_data->lastname}}" id="inputName" class="form-control text-right" disabled required>
                            <input type="hidden" name="patient_id" value="{{$user_data->id}}" />
                        </div>

                        <div class="form-group">
                            <label for="inputEstimatedBudget">السن   </label>
                            <input type="tel" name="teeth_work_name"  id="inputEstimatedBudget" class="form-control" required>
                        </div>


                        <div class="form-group">
                            <label for="inputEstimatedBudget">   اسم العمل [ نوع المعالجة] </label>
                            <select class="form-control custom-select" name="working_teeth" id="e1">
                                <option  disabled>الرجاء الأختيار</option>
                                @foreach($Treatment as $Treatmente)
                                    <option value="{{$Treatmente->id}}" >{{$Treatmente->title}} [ {{ $Treatmente->price  }} ]</option>
                                @endforeach
                            </select>
                        </div>



                        <div class="form-group">
                            <label for="inputStatus">الطبيب</label>
                            <select class="form-control custom-select" name="doctor_id" id="e1">
                                <option  disabled>الرجاء الأختيار</option>
                                @foreach($doctor_data as $doctor)
                                    <option {{ ($user_data->doctors_id) == $doctor->id ? 'selected' : '' }} value="{{$doctor->id}}" >{{$doctor->doctor_fname}}</option>
                                @endforeach
                            </select>
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
                            <label for="inputName"> ملاحظة</label>
                            <input type="text" name="set_note" id="inputName" class="form-control text-right" required>
                        </div>

                        <div class="form-group">
                            <label for="inputName">المبلغ المطلوب</label>
                            <input type="number"  name="set_total" id="inputName" min="0" class="form-control text-right" placeholder="0" required>
                        </div>

                        <div class="form-group">
                            <label for="inputName">الدفعة</label>
                            <input type="number" name="set_payment" min="0" id="inputName" class="form-control text-right" placeholder="0" required>
                        </div>

                        <div class="form-group">
                            <label for="inputStatus">المخبر</label>
                            <select class="form-control custom-select" id="e2" name="teeth_lab">
                                <option   value="">لا يتطلب مخبر </option>
                                @foreach($lab as $labs)
                                    <option value="{{$labs->id}}" >{{$labs->lab_name}}</option>
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

@section('js')
    <script>
        $(document).ready(function() {
            $("#e1").select2();
            $("#e2").select2({minimumInputLength: 2});
        });
    </script>
@stop
