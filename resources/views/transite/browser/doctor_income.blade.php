@extends('adminlte::page')

@section('title', 'استعراض حركات محاسبة |  مدخلات طبيب    ')

@section('content_header')

    <h1 class="text-center">   الرجاء اختيار المركز   </h1>
@stop

@section('content')

    @if(isset($center) and isset($CenterData))
        <table id="example" class="table table-striped table-bordered display text-center" style="width:100%">
            <thead>
            <tr>
                <th>حركات السحب</th>
                <th>اسم المركز </th>
                <th>أطباء المركز</th>
            </tr>
            </thead>
            <tbody>
            @if(isset($admin) and $center == 1)
                @foreach($CenterData as $center)
                    <tr>
                        <th><a href="in/{{ $center->uuid }}" title="عرض كافة السجلات "><i class="fas fa-id-card"></i></a></th>
                        <th>{{ $center->center_name }}</th>
                        <td>
                            @foreach($center->Doctors as $doctors)
                                {{ $doctors->doctor_fname }} ,
                            @endforeach
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <th><a href="in/{{ $center->uuid }}" title="عرض كافة السجلات "><i class="fas fa-id-card"></i></a></th>
                    <th>{{ $center->center_name }}</th>
                    <td>
                        @foreach($CenterData as $doctors)
                            <b>{{ $doctors->doctor_fname }}</b> ,
                        @endforeach
                    </td>
                </tr>

            @endif

            </tbody>
            <tfoot>
            <tr>
                <th>حركات السحب</th>
                <th>اسم المركز </th>
                <th>أطباء المركز</th>
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
