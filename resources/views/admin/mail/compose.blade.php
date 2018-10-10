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
            <div class="card">
                <div class="card-header">
                    <h5>Compose new email</h5>
                </div>
                <div class="card-body p-2">
                    <form action="{{route('email.store')}}" method="POST" class="form-horizontal">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label for="receiver">Select receiver</label>
                            <select name="receiver" class="form-control" name="receiver">
                                <option value="">Select recipient</option>
                                @foreach($users as $user)
                                <option value="{{$user->hashid}}">{{$user->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="title">Enter the title of your message</label>
                            <input type="text" class="form-control" name="title" placeholder="Enter subject" value="{{old('title')}}">
                        </div>
                        <div class="form-group" >
                            <label for="body">Enter the body of your message</label>
                            <textarea name="body"  class="form-control">{!! old('body') !!}</textarea>
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