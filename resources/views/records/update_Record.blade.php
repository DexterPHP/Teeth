@extends('adminlte::page')

@section('title', 'تعديل سجل مريض')



@section('content')
    @if(isset($TheRecord))
        <form method="post" dir="rtl">
            {{csrf_field()}}
            @if(session('message'))
                <div class="alert alert-success alert-dismissible text-right">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h5><i class="icon fas fa-check"></i> تم التعديل </h5>
                    لقد تم التحديث بشكل سليم
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
                                <input type="text"  value="{{$TheRecord->Patient_data->username}} {{$TheRecord->Patient_data->user_middel}} {{$TheRecord->Patient_data->lastname}}" id="inputName" class="form-control text-right" disabled required>
                                <input type="hidden" name="patient_id" value="{{$TheRecord->Patient_data->id}}" />

                            </div>


                            <div class="form-group">
                                <label for="inputEstimatedBudget">السن   </label>
                                <textarea readonly name="teeth_work_name"  id="Teethes" class="form-control" required style="resize: none;">{{trim($TheRecord->teeth_work_name)}}</textarea>
                            </div>

                            <div class="form-group">
                                <label for="inputEstimatedBudget">اسم العمل </label>
                                <input type="tel" value="{{$TheRecord->working_teeth}}" name="working_teeth" id="inputEstimatedBudget" class="form-control" required>
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
                                <label for="inputStatus">الطبيب</label>

                                <input type="text"  value="{{$doctor['doctor_fname']}}" id="inputName" class="form-control text-right" disabled required>
                                <input type="hidden" name="doctor_id" value="{{$doctor['id']}}" />

                            </div>
                            <div class="form-group">
                                <label for="inputStatus">المخبر</label>
                                <select class="form-control custom-select" id="e2" name="teeth_lab">
                                    <option  value="">لا يتطلب مخبر </option>
                                    @foreach($lab as $labs)
                                        <option {{ ($TheRecord->teeth_lab) == $labs->id ? 'selected' : '' }} value="{{$labs->id}}" >{{$labs->lab_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="inputName"> ملاحظة</label>
                                <input type="text" value="{{$TheRecord->set_note}}" name="set_note" id="inputName" class="form-control text-right" required>
                            </div>
                            <input type="hidden" value="{{$TheRecord->set_total}}"  name="set_total"  id="inputName" class="form-control text-right" >
                            <input type="hidden" value="{{$TheRecord->set_payment}}" name="set_payment"  id="inputName" class="form-control text-right" >



                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <a href="#" class="btn btn-secondary">إلغاء</a>
                    <input type="submit" value="تحديث الآن" class="btn btn-success float-right">

                </div>
            </div>
        </form>

@section('content_header')
    <h1 class="text-center">سجل
        <br />
        {{$TheRecord->Patient_data->username}} {{$TheRecord->Patient_data->user_middel}} {{$TheRecord->Patient_data->lastname}}
        <br />   بتاريخ :
        {{$TheRecord->created_at->format('Y/m/d')}}
  ||
        {{$TheRecord->created_at->format('H:i')}}
    </h1>
@stop
@include('records.Teethes')
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
