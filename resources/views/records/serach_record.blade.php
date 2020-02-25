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
                    <th><a href="user/{{ $user->Patient_data->uuid }}" title="عرض كافة السجلات "><i class="fas fa-id-card"></i></a></th>
                    <th>{{ count(\App\Models\Record::where('patient_id','=',$user->id)->get()) }}</th>
                    <td> {{$user->Patient_data->user_mobile}} </td>
                    <td>{{ (\App\Models\Doctor::where('id',$user->doctor_id)->first())->doctor_fname }} </td>
                    <td>{{ $user->Patient_data->username }}  {{$user->Patient_data->user_middel }} {{ $user->Patient_data->lastname }}</td>
                    <td>{{ isset($user->card_number) ? $user->card_number : " لا يوجد " }} </td>
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

    <script src="https://code.jquery.com/jquery-3.3.1.js" ></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" ></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" ></script>
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
