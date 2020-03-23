@extends('adminlte::page')

@section('title', 'إضافة مرض جديد')

@section('content_header')

    <h1 class="text-center">إضافة مرض جديد</h1>
@stop

@section('content')

    <form method="post">{{csrf_field()}}



        @if(session('message'))
            <div class="alert alert-success alert-dismissible text-right">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h5><i class="icon fas fa-check"></i> تمت الإضافة</h5>
                 تمت إضافة المرض
            </div>
        @endif
        @if(session('messageError'))
            <div class="alert alert-warning alert-dismissible text-right">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h5><i class="icon fas fa-check"></i> رسالة خطأ</h5>
               هذا المرض مسجل من قبل
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
                            <label for="inputName">اسم المرض </label>
                            <input type="text" name="title" id="inputName" class="form-control text-right" required>
                        </div>
                        @if(isset($fetch) and $fetch == false)
                            <input type="hidden" name="center_id" value="{{$centers}}" />
                        @endif
                        @if(isset($fetch) and $fetch == true )
                        <div class="form-group">
                            <label for="inputStatus">المركز</label>
                            <select class="form-control custom-select"  name="center_id" id="e1" required>
                                @foreach($centers as $center)
                                    <option value="{{$center->id}}" >{{$center->center_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        @endif
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>

            <!-- /.card -->
        </div>
        <div class="row">
            <div class="col-12">
                <a href="/" class="btn btn-secondary">إلغاء</a>
                <input type="submit" value="إضافة" class="btn btn-success float-right">

            </div>
        </div>
    </form>
@stop
@section('js')
    <script>
        $(document).ready(function() {
            $("#e1").select2();
            $("#user").select2();
        });
    </script>
@stop

