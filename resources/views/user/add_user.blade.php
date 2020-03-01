@extends('adminlte::page')

@section('title', 'إضافة مريض جديد')

@section('content_header')

    <h1 class="text-center">إضافة مريض جديد</h1>
@stop

@section('content')

    <form method="post" dir="rtl">{{csrf_field()}}
 @if(session('message'))
            <div class="alert alert-success alert-dismissible text-right">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h5><i class="icon fas fa-alert"></i> تمت الإضافة</h5>
                لقد تمت إضافة المريض بشكل سليم
            </div>
        @endif
        @if(session('userExists'))

            <div class="alert alert-danger alert-dismissible text-right">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h5><i class="icon fas fa-check"></i>  لم يتم اسجيل المريض</h5>
                إن هذا المريض لديه مسجل من قبل
            </div>
        @endif
        <div class="row">
            <div class="col-md-12 text-right">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title float-right"> الطبيب</h3>

                    </div>
                    <div class="card-body text-right">
                        <div class="form-group">

                            <select class="form-control custom-select text-right" name="doctors_id" id="e1" required>
                                <option selected disabled>الرجاء الإختيار</option>
                                @foreach($doctors as $doctor)
                                    <option  value="{{$doctor->id}}">{{$doctor->doctor_fname}}</option>
                                @endforeach

                            </select>
                        </div>
                    </div>

                </div>
        </div>


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
                            <input type="text" value="{{session('_old_input')['username']}}" name="username" id="inputName" class="form-control text-right" required>
                        </div>
                        <div class="form-group">
                            <label for="inputName"> الكنية</label>
                            <input type="text" value="{{session('_old_input')['lastname']}}" name="lastname" id="inputName" class="form-control text-right" required>
                        </div>
                        <div class="form-group">
                            <label for="inputName">أسم الأب </label>
                            <input type="text" value="{{session('_old_input')['user_middel']}}" name="user_middel" id="inputName" class="form-control text-right" required>
                        </div>
                        <div class="form-group">
                            <label for="inputClientCompany">تاريخ الميلاد</label>
                            <input type="date"  value="{{session('_old_input')['birthday']}}" name="birthday" id="birthday" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="inputName">العمر</label>
                            <input disabled type="text" value="{{session('_old_input')['user_age']}}" min="3" name="user_age" id="age" class="form-control text-right" required>
                        </div>
                        <div class="form-group">
                            <label for="inputClientCompany">رقم بطاقة المريض  </label>
                            <input type="text" value="{{session('_old_input')['card_number']}}" name="card_number" id="inputClientCompany" class="form-control" >
                        </div>
                        <div class="form-group">
                            <label for="inputDescription">معلومات</label>
                            <input type="text" value="{{session('_old_input')['notes']}}" name="notes" id="inputName" class="form-control text-right" required>
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
                            <select class="form-control custom-select" name="doctors_id" id="e1" required>
                                <option selected disabled>الرجاء الإختيار</option>
                                @foreach($doctors as $doctor)
                                    <option value="{{$doctor->id}}">{{$doctor->doctor_fname}}</option>
                                @endforeach

                            </select>
                        </div>

                        <div class="form-group">
                            <label for="inputStatus">الجنس</label>
                            <select class="form-control custom-select" name="gender" required>
                                <option selected disabled>الرجاء الختيار</option>
                                <option value="ذكر"  selected="selected">ذكر</option>
                                <option value="أنثى">إنثى</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="inputEstimatedBudget">رقم هاتف المريض</label>
                            <input type="tel" value="{{session('_old_input')['user_mobile']}}" name="user_mobile" id="inputEstimatedBudget" class="form-control" required>
                        </div>

                                <input type="hidden" name="depress" value="0" />
                                <input type="hidden" name="smoking" value="0" />
                                <input type="hidden" name="shoug" value="0"  />
                        <div class="form-group">
                            <label>الأمراض</label>
                            <select class="form-control custom-select js-example-basic-multiple" name="diseases[]" multiple="multiple">

                                @foreach($diseasei as $dis)
                                    <option value="{{$dis->id}}">{{$dis->title}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="inputDescription">معلومات طبية</label>
                            <textarea cols="10" rows="3"  name="medical_notes" class="form-control text-right"></textarea>

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

@section('js')
    <script>
        $(document).ready(function() { $("#e1").select2(); });
        function getAge(dateString) {
            var today = new Date();
            var birthDate = new Date(dateString);
            var age = today.getFullYear() - birthDate.getFullYear();
            var m = today.getMonth() - birthDate.getMonth();
            if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
                age--;
            }
            return age+1;
        }
        function format(inputDate) {
            var date = new Date(inputDate);
            if (!isNaN(date.getTime())) {
                // Months use 0 index.
                return date.getFullYear() + 1 + '/' + date.getDate() + '/' + date.getMonth();
            }
        }
        $(function() {
            $('#birthday').on('change', function () {
                var birth = $('#birthday').val();
                var Newbirth = format(birth);
                $('#age:disabled').val(getAge(Newbirth));
            });
        });
    </script>
    <script >
        $(document).ready(function() {
            $('.js-example-basic-multiple').select2();
        });
    </script>
@stop
