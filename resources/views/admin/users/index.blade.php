@extends('layouts.admin.adminlayout')

@section('content')

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <p class="float-left">Users</p>
                        @if(Auth::user()->isAdministrator())
                        <a href="{{route('users.create')}}" role="button" class="btn btn-sm btn-primary float-right">Create new user</a>
                        @endif
                    </div>
                    @if(count($users))
                    <div class="card-body">
                        <table class="table table-responsive table-hover">
                            <thead class="thead-dark">
                            <tr >
                                <th class="w100">Name</th>
                                <th class="w100 d-sm-none d-md-block">Email</th>
                                <th class="w100">Permission</th>
                                @if(Auth::user()->isAdministrator())
                                    <th class="w100">Edit</th>
                                @endif
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td>{{$user->name}}</td>
                                    <td class="d-sm-none d-md-block">{{$user->email}}</td>
                                    <td>{{$user->role->name}}</td>
                                    @if(Auth::user()->isAdministrator())
                                        <td><a href="{{route('users.edit', ['hashid'=>$user->hashid])}}" role="button" class="btn btn-primary btn-sm">Edit</a></td>
                                    @endif
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif
                </div>
            </div>
        </div>

@endsection