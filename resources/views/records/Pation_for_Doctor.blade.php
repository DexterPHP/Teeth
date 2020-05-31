@extends('adminlte::page')

@section('title', 'تعديل سجل مريض')

@section('content_header')

    <h1 class="text-center">تعديل سجل مريض</h1>
@stop

@section('content')


    @if(isset($All))
        <table id="example" class="table table-striped table-bordered display text-center" style="width:100%">
            <thead>
            <tr>
                <th>السجلات</th>
                <th>عدد السجلات</th>
                <th>رقم الهاتف</th>
                <th>الطبيبب المشرف حالياً</th>
                <th>اسم المريض كاملاً</th>
                <th>رقم المريض الخاص</th>
            </tr>
            </thead>
            <tbody>
            @foreach($All as $user)
                <tr>
                    <td><a href="../user/{{ $user['pation']->uuid }}" title="عرض كافة السجلات "><i class="fas fa-id-card"></i></a></td>
                    <td>{{ count($user['Records']) }}</td>
                    <td>{{ $user['pation']->user_mobile }}</td>
                    <td>{{ (\App\Models\Doctor::where('id',$user['pation']->doctors_id)->first())->doctor_fname }}</td>
                    <td>{{ $user['pation']->username}} </td>
                    <td>{{ isset($user['pation']->card_number) ? $user['pation']->card_number : " لا يوجد " }} </td>
                </tr>
            @endforeach

            </tbody>
            <tfoot>
            <tr>
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
    <script>
        $(document).ready(function() {
            $('#example').DataTable();
        } );
    </script>
@stop
@section('css')
    <link href="{{asset('css/bootstrap.css')}}" />
    <link href="{{asset('css/dataTables.bootstrap4.min.css')}}" />
@stop
