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
                    <h5>Read email</h5>
                </div>
                <div class="col-md-4 form-group">
                    <a href="{{route('email.reply', ['hashid'=>$email->hashid])}}" class="btn btn-primary btn-sm float-left"><i class="fas fa-reply"></i>&nbsp;Reply</a>
                    <a href="{{route('email.forward', ['hashid'=>$email->hashid])}}" class="btn btn-primary btn-sm float-right"><i class="fas fa-share"></i>&nbsp;Forward</a>
                </div>

                <div class="card-body">
                    <h6>Subject: {{$email->title}}</h6>
                    <h6>From: {{$email->getUsersName($email->sender)}}</h6>
                    <h6>To: {{$email->getUsersName($email->receiver)}}</h6>
                    <h6>On: {{$email->showDate(true)}}</h6>
                    <div class="card mb-3">
                        <p class="card-text">{!! $email->body !!}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection


@section('scripts')

@endsection