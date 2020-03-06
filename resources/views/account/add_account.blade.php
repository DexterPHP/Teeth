@extends('adminlte::page')

@section('title', 'إضافة مستخدم جديد')

@section('content_header')
    <h1 class="text-center">إضافة مستخدم جديد  </h1>
@stop

@section('content')

    <form method="post" dir="rtl">{{csrf_field()}}
        @if(session('message'))
            <div class="alert alert-success alert-dismissible text-right">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h5><i class="icon fas fa-alert"></i> تمت الإضافة</h5>
                لقد تمت إضافة المستخدم بشكل سليم
            </div>
        @endif
        @if(session('userExists'))

            <div class="alert alert-danger alert-dismissible text-right">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h5><i class="icon fas fa-check"></i>خطأ </h5>
               هناك خطأ
            </div>
        @endif
        @if(session('errorPass'))

            <div class="alert alert-danger alert-dismissible text-right">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h5><i class="icon fas fa-check"></i>خطأ </h5>
               كلمة المرور والتأكيد غير متطابقتان
            </div>
        @endif
        @if(session('TheError'))

            <div class="alert alert-warning alert-dismissible text-right">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h5><i class="icon fas fa-bug"></i>خطأ </h5>
               {{session('TheError')}}
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
                            <label for="inputName">أسم المستخدم للعرض </label>
                            <input type="text" name="name" id="inputName" class="form-control text-right" required>
                        </div>
                        <div class="form-group">
                            <label for="inputName">البريد الإلكتروني (مطلوب لتسجيل الدخول عبره)  </label>
                            <input type="email" name="email" id="inputName" class="form-control text-right" required>
                        </div>
                        <div class="form-group">
                            <label for="inputName"> كلمة المرور</label>
                            <input type="password" min=""8" name="password" id="inputName" class="form-control text-right" required>
                        </div>
                        <div class="form-group">
                            <label for="inputName">تأكيد كلمة المرور</label>
                            <input type="password" min="8" name="password2" id="inputName" class="form-control text-right" required>
                        </div>
                        <div class="form-group">
                            <label for="inputStatus">الصلاحية</label>
                            <select class="form-control custom-select" name="role_user" required>
                                <option  disabled>الرجاء الختيار</option>
                                @foreach($roles_list as $role)
                                    <option value="{{$role->id}}">{{$role->name}}</option>
                                @endforeach

                            </select>
                        </div>

                        <div class="form-group">
                            <label for="inputStatus">المركز</label>
                            <select class="form-control custom-select" name="center_id" required>
                                <option  disabled>الرجاء الختيار</option>
                                @foreach($centers as $center)
                                    <option value="{{$center->id}}">{{$center->center_name}}</option>
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
@stop

@section('js')
    <script>
        $(document).ready(function() { $("#e1").select2(); });
    </script>
@stop
