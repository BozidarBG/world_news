<?php
$layout;

if(Auth::user()->role_id ===1){
    $layout="layouts.frontend.frontend";
}elseif(Auth::user()->role_id ===2 || Auth::user()->role_id ===3 || Auth::user()->role_id ===4){
    $layout="layouts.admin.adminlayout";
}
?>
@extends($layout)

@section('content')
    <div class="row">
        <div class="col-12 col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Welcome {{Auth::user()->name}}</h4>
                </div>
                <div class="card-body">
                    <form action="{{route('profile.update')}}" method="post">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label for="password">Update your password</label>
                            <input type="password" class="form-control" name="password">
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-success" name="submit">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endsection