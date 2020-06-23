@extends('adminlte::page')

@section('title', ' تعديل معلومات المريض ')

@section('content_header')

    <h1 class="text-center">تعديل معلومات   </h1>
@stop

@section('content')

    {{csrf_field()}}
    @if(isset($usersm))
        <table id="example" class="table table-striped table-bordered display text-center" style="width:100%">
            <thead>
            <tr>
                <th>التحكم </th>
                <th>تاريخ التسجيل</th>
                <th>ملاحظات</th>
                <th>رقم الهاتف</th>
                <th>العمر </th>
                <th>الأسم</th>
                <th>رقم البطاقة</th>
            </tr>
            </thead>
            <tbody>
            @foreach($usersm as $user)
                <tr>
                    <td>
                        @if (isset($editable) and $editable == true)
                            <a href="edit/{{$user->uuid}}" title="تعديل معلومات المريض"><i class="fas fa-user-injured"></i></a>
                        @endif
                    </td>
                    <td>{{ $user->created_at->format('Y/m/d') }}</td>
                    <td>{{ $user->notes }}</td>
                    <td>{{ $user->user_mobile }}</td>
                    <td>{{ $user->user_age }}  </td>
                    <td>{{ $user->username }} {{$user->user_middel }} {{ $user->lastname }}</td>
                    <td> @if(strlen($user->card_number)>0) {{$user->card_number}} @else  لا يوجد  @endif</td>
                </tr>
            @endforeach

            </tbody>
            <tfoot>
            <tr>
                <th>التحكم </th>
                <th>تاريخ التسجيل</th>
                <th>ملاحظات</th>
                <th>رقم الهاتف</th>
                <th>العمر </th>
                <th>الأسم</th>
                <th>رقم البطاقة</th>
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
