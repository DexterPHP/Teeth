@extends('adminlte::page')

@section('title', 'محادثات       ')

@section('content_header')

    <h1 class="text-center">     المحادثات   </h1>
@stop

@section('content')
    <div class="card direct-chat direct-chat-primary">
        <div class="card-header ui-sortable-handle" style="cursor: move;">
            <h3 class="card-title">{{$user->name}}</h3>

            <div class="card-tools">
                <span data-toggle="tooltip" title="3 New Messages" class="badge badge-primary">3</span>
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-toggle="tooltip" title="Contacts" data-widget="chat-pane-toggle">
                    <i class="fas fa-comments"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <!-- Conversations are loaded here -->
            <div class="direct-chat-messages">
                <!-- Message. Default to the left -->
                <div class="direct-chat-msg">
                    <div class="direct-chat-infos clearfix">
                        <span class="direct-chat-name float-left">Alexander Pierce</span>
                        <span class="direct-chat-timestamp float-right">23 Jan 2:00 pm</span>
                    </div>
                    <!-- /.direct-chat-infos -->
                    <img class="direct-chat-img" src="https://via.placeholder.com/128?text=Hello+From+Dexter" alt="message user image">
                    <!-- /.direct-chat-img -->
                    <div class="direct-chat-text">
                        Is this template really for free? That's unbelievable!
                    </div>
                    <!-- /.direct-chat-text -->
                </div>
                <!-- /.direct-chat-msg -->

                <!-- Message to the right -->
                <div class="direct-chat-msg right">
                    <div class="direct-chat-infos clearfix">
                        <span class="direct-chat-name float-right">Sarah Bullock</span>
                        <span class="direct-chat-timestamp float-left">23 Jan 2:05 pm</span>
                    </div>
                    <!-- /.direct-chat-infos -->
                    <img class="direct-chat-img" src="https://via.placeholder.com/128?text=Hello+From+Dexter" alt="message user image">
                    <!-- /.direct-chat-img -->
                    <div class="direct-chat-text">
                        You better believe it!
                    </div>
                    <!-- /.direct-chat-text -->
                </div>
                <!-- /.direct-chat-msg -->



            </div>
            <!--/.direct-chat-messages-->


            <!-- User List -->
            <!-- Contacts are loaded here -->
            <div class="direct-chat-contacts">
                <ul class="contacts-list">
                    @foreach($AllUser as $alsuser)
                        @if($user->id != $alsuser->id)
                            <li>
                                <a href="#">
                                    <img class="contacts-list-img" src="https://via.placeholder.com/128?text=Hello+From+Dexter">
                                    <div class="contacts-list-info">
                                  <span class="contacts-list-name">
                                    {{$alsuser->name}}
                                    <small class="contacts-list-date float-right">{{$alsuser->created_at}}</small>
                                  </span>
                                        <span class="contacts-list-msg">{{$alsuser->name}}</span>
                                    </div>
                                    <!-- /.contacts-list-info -->
                                </a>
                            </li>
                        @endif
                    @endforeach

                </ul>
                <!-- /.contacts-list -->
            </div>
            <!-- /.direct-chat-pane -->



        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            <form action="#" method="post">
                <div class="input-group">
                    <input type="text" name="message" placeholder="Type Message ..." class="form-control">
                    <span class="input-group-append">
                      <button type="button" class="btn btn-primary">Send</button>
                    </span>
                </div>
            </form>
        </div>
        <!-- /.card-footer-->
    </div>
@stop

@section('js')

@stop
@section('css')

@stop
