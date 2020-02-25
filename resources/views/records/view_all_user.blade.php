@extends('adminlte::page')

@section('title', '  البحث عن مريض لادخال سجل')

@section('content_header')

    <h1 class="text-center"> اضافة سجل أو البحث عن سجلات مريض  </h1>
@stop

@section('content')


    @if(isset($data))
        <table id="example" class="table table-striped table-bordered display text-center" style="width:100%">
            <thead>
            <tr>
                <th>إضافة سجل جديد</th>
                <th>السجلات</th>
                <th>عدد السجلات</th>
                <th>رقم الهاتف</th>
                <th>الطبيبب المشرف حالياً</th>
                <th>اسم المريض كاملاً</th>
                <th>رقم المريض الخاص</th>
            </tr>
            </thead>
            <tbody>
            @foreach($data as $user)
                <tr>
                   <th><a href="add/{{ $user->uuid }}" title="إضافة  سجل جديد"><i class="fas fa-id-card-alt"></i></a></th>
                   <th><a href="view/{{ $user->uuid }}" title="عرض  سجلات المريض"><i class="fas fa-id-card"></i></a></th>
                   <th>{{ count(\App\Models\Record::where('patient_id','=',$user->id)->get()) }}</th>
                   <td>{{ $user->user_mobile }}</td>
                   <td>{{ \App\Models\Doctor::find($user->doctors_id)->doctor_fname }} </td>
                   <td>{{ $user->username }} {{$user->user_middel }} {{ $user->lastname }}</td>
                   <td>{{ $user->id }} </td>

                </tr>
            @endforeach

            </tbody>
            <tfoot>
            <tr>
                <th>إضافة سجل جديد</th>
                <th>السجلات</th>
                <th>عدد السجلات</th>
                <th>رقم الهاتف</th>
                <th>الطبيبب المشرف حالياً</th>
                <th>اسم المريض كاملاً</th>
                <th>رقم المريض الخاص</th>
            </tr>
            </tfoot>
        </table>

    @endif

@stop

@section('js')

    <script src="{{asset('js/jquery-3.3.1.js')}}" ></script>
    <script src="{{asset('js/jquery.dataTables.min.js')}}" ></script>
    <script src="{{asset('js/dataTables.bootstrap4.min.js')}}" ></script>
    <script src="{{asset('js/dataTables.buttons.min.js')}}" ></script>
    <script src="{{asset('js/buttons.flash.min.js')}}" ></script>
    <script src="{{asset('js/jszip.min.js')}}" ></script>
    <script src="{{asset('js/pdfmake.min.js')}}" ></script>
    <script src="{{asset('js/vfs_fonts.js')}}" ></script>
    <script src="{{asset('js/buttons.html5.min.js')}}" ></script>
    <script src="{{asset('js/buttons.print.min.js')}}" ></script>
        <script>
        $(document).ready(function() {
            $('#example').DataTable( {
                dom: 'Bfrtip',
                buttons: [
                    'copyHtml5',
                    'excelHtml5'
                ]
            } );
        } );
    </script>
@stop
@section('css')
    <link href="{{asset('css/bootstrap.css')}}" />
    <link href="{{asset('css/dataTables.bootstrap4.min.css')}}" />
@stop
