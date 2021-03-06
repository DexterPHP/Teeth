@extends('adminlte::page')

@section('title', 'تعديل المعالجات')

@section('content_header')

    <h1 class="text-center">لائحة بالمعالجات من أجل التعديل </h1>
@stop

@section('content')


    @if(isset($disease))
        <table id="example" class="table table-striped table-bordered display text-center" style="width:100%">
            <thead>
            <tr>
                <th>التحكم</th>
                @if(isset($main) and $main != Null) <th>المركز</th> @endif
                <th> القيمة</th>
                <th> اسم المعالجة</th>
                <th>رقم  الخاص</th>
            </tr>
            </thead>
            <tbody>
            @foreach($disease as $dises)
                <tr>
                    <td><a href="./update/{{ $dises->uuid }}" title="تعديل"><i class="fas fa-id-card"></i></a></td>
                    @if(isset($main) and $main != Null)   <td>yy</td> @endif
                    <td>{{ $dises->price}} </td>
                    <td>{{ $dises->title}} </td>
                    <td>{{ $dises->id }} </td>
                </tr>
            @endforeach

            </tbody>
            <tfoot>
            <tr>
                <th>التحكم</th>
                @if(isset($main) and $main != Null) <th>المركز</th> @endif
                <th> القيمة</th>
                <th> اسم المعالجة</th>
                <th>رقم  الخاص</th>
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
