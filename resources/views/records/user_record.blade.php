@extends('adminlte::page')

@section('title', 'تعديل سجل مريض')



@section('content')


    @if(isset($data))
        <table id="example" class="table table-striped table-bordered display text-center" style="width:100%">
            <thead>
            <tr>
                <th>التحكم</th>
                <th>دفعة</th>
                <th>المبلغ المطلوب</th>
                <th>اسم العمل</th>
                <th>السن</th>
                <th>تاريخ الزيارة</th>
                <th> الطبيب  </th>
                <th>رقم المريض الخاص</th>
            </tr>
            </thead>
            <tbody>
            @foreach($data as $user)
                <tr>
                    <!-- <th><a href="../change/{{ $user->uuid }}" title="  تعديل "><i class="fas fa-edit"></i></a></th> -->
                    <th><a href="#" title="  تعديل "><i class="fas fa-edit"></i> Soon </a></th>
                    <td class="text-danger"> {{$user->set_total}} </td>
                    <td class="text-success"> {{$user->set_payment}} </td>
                    <td> {{$user->teeth_work_name}} </td>
                    <td> {{$user->working_teeth}} </td>
                    <td>{{ ($user->created_at)->format('d/m/Y') }} ||  {{($user->created_at)->format('h:i A')}}</td>
                    <td>{{ (\App\Models\Doctor::where('id',$user->doctor_id)->first())->doctor_fname }} </td>
                    <td>{{ isset($user->card_number) ? $user->card_number : " لا يوجد " }} </td>
                </tr>
            @endforeach
            </tbody>
            <tfoot>
            <tr>
                <th>التحكم</th>
                <th>دفعة</th>
                <th>المبلغ المطلوب</th>
                <th>اسم العمل</th>
                <th>السن</th>
                <th>تاريخ الزيارة</th>
                <th> الطبيب  </th>
                <th>رقم المريض الخاص</th>
            </tr>
            </tfoot>
        </table>

@section('content_header')
    <h1 class="text-center">  سجلات المريض {{$userdata->username}} {{$userdata->user_middel}} {{$userdata->lastname}}</h1>
@stop

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
