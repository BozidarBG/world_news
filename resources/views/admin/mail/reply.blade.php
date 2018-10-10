@extends('layouts.admin.adminlayout')

@section('styles')
    <link rel="stylesheet" href="{{asset('css/email.css')}}">
    <style>

    </style>

@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            @include('admin.includes.errors')

            <div class="card mb-3">
                <div class="card-header">
                    <h5>{{$page_name}}</h5>
                </div>
            </div>

            <div class="card">
                <div class="card-body p-2">
                    <form action="{{route('email.store')}}" method="POST" class="form-horizontal">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label for="receiver">
                                @if($page_name==="Reply page")
                                    Reply to:
                                @elseif($page_name==="Forward page")
                                    Forward to:
                                    @endif
                            </label>
                            @if($page_name==="Forward page")

                            <select name="receiver" class="form-control" name="receiver">
                                <option value="" disabled selected>Select recipient</option>
                                @foreach($users as $user)
                                    <option value="{{$user->hashid}}">{{$user->name}}</option>
                                @endforeach
                            </select>
                            @else
                            <input type="text" class="form-control" value="{{$email->getUsersName($email->sender)}}" disabled>
                            <input type="hidden" value="{{$email->getUsersHashid($email->sender)}}" name="receiver">
                            @endif
                            <input type="hidden" value="{{$email->hashid}}" name="previous">
                        </div>
                        <div class="form-group">
                            <label for="title">Enter the title of your message</label>
                            <input type="text" class="form-control" name="title" value="{{$page_name==="Reply page" ? "Re:" : "Fw:"}} {{$email->title}}">
                        </div>
                        <div class="form-group" >
                            <label for="body">Enter the body of your message</label>
                            <textarea name="body"  class="form-control">
                                <br>
                                <hr>
                                <p>Subject: {{$email->title}}</p>
                                <p>From: {{$email->getUsersName($email->sender)}}</p>
                                <p>To: {{$email->getUsersName($email->receiver)}}</p>
                                <p>On: {{$email->showDate(true)}}</p>
                                <p><strong>Previous message(s):</strong></p>
                                {!! $email->body !!}

                            </textarea>
                        </div>

                        <div class="form-group">
                            <div class="text-center">
                                <button type="submit" name="send" class="btn btn-success">Send</button>
                                <button type="submit" name="save" class="btn btn-primary">Save to drafts</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>

@endsection


@section('scripts')


    <script src="https://cdn.ckeditor.com/4.10.1/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace( 'body' );
        CKEDITOR.config.removePlugins = 'image';
    </script>


@endsection