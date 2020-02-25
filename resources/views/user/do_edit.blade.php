@extends('adminlte::page')

@section('title', 'تعديل مريض  ')

@section('content_header')

    <h1 class="text-center">تعديل مريض  </h1>
@stop

@section('content')
    @if(session('upDATE'))
        <div class="alert alert-success alert-dismissible text-right">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h5><i class="icon fas fa-check text-right"></i> تمت العملية بنجاح</h5>
            تم تعديل معلومات المريض بشكل سليم
        </div>
    @endif
@if(isset($user))


    <form method="post" class="text-right" enctype="multipart/form-data" dir="rtl">
        {{csrf_field()}}

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
                            <input type="text" name="username" value="{{$user->username}}" id="inputName" class="text-right form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="inputName">أسم الأب </label>
                            <input type="text" name="user_middel" value="{{$user->user_middel}}" id="inputName" class="form-control text-right" required>
                        </div>
                        <div class="form-group">
                            <label for="inputName"> الكنية</label>
                            <input type="text" name="lastname" value="{{$user->lastname}}" id="inputName" class="form-control text-right" required>
                        </div>
                        <div class="form-group">
                            <label for="inputDescription">معلومات</label>
                            <input type="text" name="notes" value="{{$user->notes}}" id="inputName" class="form-control text-right" required>
                        </div>
                        <div class="form-group">
                            <label for="inputName">العمر</label>
                            <input type="number" name="user_age" value="{{$user->user_age}}" id="inputName" class="form-control text-right" required>
                        </div>
                        <div class="form-group">
                            <label for="inputClientCompany">تاريخ الميلاد</label>
                            <input type="date" name="birthday" value="{{$user->birthday}}" id="inputClientCompany" class="form-control text-right" required>
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
                            <label for="inputStatus">الجنس</label>
                            <select class="form-control custom-select" name="gender">
                                <option  disabled>الرجاء الختيار</option>

                                <option {{ ($user->gender) == "ذكر" ? 'selected' : '' }} value="ذكر"  >ذكر</option>
                                <option {{ ($user->gender) == "أنثى" ? 'selected' : '' }} value="أنثى">إنثى</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="inputEstimatedBudget">رقم الموبايل</label>
                            <input type="tel" name="user_mobile" value="{{$user->user_mobile}}" id="inputEstimatedBudget" class="form-control text-right" required>
                        </div>
                        <div class="form-group">
                            <label for="inputStatus">هل يعاني من الضغط ؟</label>
                            <select class="form-control custom-select"  name="depress">

                                <option {{ ($user->depress) == 0 ? 'selected' : '' }} value="0" >لا</option>
                                <option {{ ($user->depress) == 1 ? 'selected' : '' }} value="1" >نعم</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="inputStatus">هل هو مريض سكري ؟</label>
                            <select class="form-control custom-select"  name="shoug">

                                <option {{ ($user->shoug) == 0 ? 'selected' : '' }} value="0"  >لا</option>
                                <option {{ ($user->shoug) == 1 ? 'selected' : '' }} value="1" >نعم</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="inputStatus">هل هو مدخن ؟؟</label>
                            <select class="form-control custom-select"  name="smoking">

                                <option {{ ($user->smoking) == 0 ? 'selected' : '' }} value="0" >لا</option>
                                <option {{ ($user->smoking) == 1 ? 'selected' : '' }} value="1" >نعم</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="inputClientCompany">صورة </label>
                            <input type="file" name="user_image" {{ ($user->user_image) == null ? 'require' : ''  }} id="inputClientCompany" class="form-control text-right" >
                        </div>



                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <a href="#" class="btn btn-secondary float-left">إلغاء</a>
                <input type="submit" value="تحديث  الآن" class="btn btn-success float-right">

            </div>
        </div>
    </form>
    @endif
@stop
