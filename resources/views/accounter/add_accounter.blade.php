@extends('adminlte::page')

@section('title', 'إضافة محاسب  جديد')

@section('content_header')

    <h1 class="text-center">إضافة محاسب جديد</h1>
@stop

@section('content')

    <form method="post">
        {{ csrf_field() }}



        @if(session('Essia'))
            <div class="alert alert-success alert-dismissible text-right">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h5><i class="icon fas fa-check"></i> تمت الإضافة</h5>
                لقد تمت إضافة المحاسب بشكل سليم
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
                            <input type="text" name="accounter_fname" id="inputName" class="form-control text-right" required>
                        </div>
                        <div class="form-group">
                            <label for="inputName">كلمة السر  </label>
                            <input type="password" name="accounter_pass" id="inputName  text-right" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="inputName"> رقم الهاتف</label>
                            <input type="tele" name="accounter_phone" id="inputName  text-right" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="inputStatus">المراكز</label>
                            <select class="form-control custom-select text-right" name="center_id" id="e1">
                                <option  disabled>الرجاء الختيار</option>
                                @foreach($centersx as $center)
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
    @endsection

