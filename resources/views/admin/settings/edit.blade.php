@extends('layouts.admin.adminlayout')

@section('styles')


@endsection

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                Edit Web Site Settings
            </div>
            <div class="card-body">
                @include('admin.includes.errors')
                <form action="{{route('settings.update')}}" method="post" enctype="multipart/form-data">
                    {{csrf_field()}}

                    <div class="form-group">
                        <label for="name">Website Name</label>
                        <input type="text" name="name" class="form-control" value="{{$settings->name}}">
                    </div>

                    <div class="form-group">
                        <label for="address">Address</label>
                        <textarea name="address" class="form-control">{{$settings->address}}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="email">Website email</label>
                        <input type="text" name="email" class="form-control" value="{{$settings->email}}">
                    </div>

                    <div class="form-group" >
                        <label for="about">About</label>
                        <textarea name="about" class="form-control">{!! $settings->about !!}</textarea>
                    </div>


                    <div class="form-group">
                        <div class="text-center">
                            <button type="submit" name="submit" class="btn btn-info">Update</button>
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
        CKEDITOR.replace( 'about' );
        CKEDITOR.replace( 'address' );
        CKEDITOR.config.removePlugins = 'image';
    </script>

@endsection