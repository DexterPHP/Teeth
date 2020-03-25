@extends('adminlte::page')

@section('title', 'محادثات       ')

@section('content_header')

    <h1 class="text-center">     المحادثات   </h1>
@stop

@section('content')
    <div class="row justify-content-center">
        <div class="col-sm-12" >
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Welcome To Chat App [Dexter]</h3>

                    <div class="card-tools">
                        <span data-toggle="tooltip" title="3 New Messages" class="badge badge-warning">3</span>
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-toggle="tooltip" title="Contacts" data-widget="chat-pane-toggle">
                            <i class="fas fa-comments"></i></button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body" id="app">
                    <chat-app :user="{{ auth()->user() }}"></chat-app>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script src="{{asset('js/app.js')}}" ></script>
@stop
@section('css')

@stop
