@extends('layouts.admin.adminlayout')
@section('styles')
    <style>
        .table th, .table td{
            font-size: 80%;
        }
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-2">
                            @if(isset($page_name))
                                {{$page_name}}
                            @endif
                            Articles
                        </div>
                        <div class="col-md-4">

                        </div>
                        <div class="col-md-6 ">
                            <form class="form-inline float-right">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="title_search" placeholder="Search by title">
                                </div>&nbsp;
                                <div class="form-group">
                                    <input type="submit" name="user_search" value="Search" class="form-control btn-success">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if(count($articles))
                        <table class="table table-sm table-hover table-striped">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Category</th>
                                <th>Title</th>
                                <th>Journalist</th>
                                <th>Status</th>
                                <th>Approved By</th>
                                <th>Last Change</th>
                                <th>Edit</th>
                                <th>Destroy</th>
                                <th>Restore</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($articles as $article)
                                <tr>
                                    <td>{{$article->id}}</td>
                                    <td>{{$article->category->title}}</td>
                                    <td>{{$article->title}}</td>
                                    <td>{{$article->user->name}}</td>
                                    <td>{{$article->approved()}}</td>
                                    <td>{{$article->approvedBy()}}</td>
                                    <td>{{$article->updated_at->format('d.m.Y')}}
                                        <br>
                                        {{$article->updated_at->format('H:i:s')}}</td>
                                    @if(Auth::user()->isJournalist())
                                        <td><a href="{{route('articles.edit', $article->slug)}}" class="btn btn-info btn-xs">Edit</a></td>
                                        <td>
                                            <form method="POST"
                                                  action="{{route('articles.kill', ['slug'=> $article->slug])}}" >

                                                {!! csrf_field() !!}
                                                <input type="submit" class="btn btn-danger btn-xs" value="Kill" name="submit"
                                                       onclick=" return confirm('Are you sure that you want to permanently delete this article?')">
                                            </form>
                                        </td>

                                    @elseif(Auth::user()->isModerator())
                                        <td><a href="{{route('articles.moderator-edit', $article->slug)}}"
                                               class="btn btn-info btn-xs">Edit</a>
                                        <td>
                                            <form method="POST"
                                                  action="{{route('articles.moderator-kill', ['slug'=> $article->slug])}}" >

                                                {!! csrf_field() !!}
                                                <input type="submit" class="btn btn-danger btn-xs" value="Kill" name="submit"
                                                       onclick=" return confirm('Are you sure that you want to permanently delete this article?')">
                                            </form>
                                        </td>
                                    @endif
                                    @if(!Auth::user()->isAdministrator())
                                        <td><a href="{{route('articles.restore', $article->slug)}}"
                                               class="btn btn-success btn-xs">Restore</a></td>

                                    @endif

                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        @if($articles->perPage()<$articles->total())
                            <nav class="text-center">
                                <ul class="pagination justify-content-center">
                                    {{$articles->render()}}
                                </ul>
                            </nav>
                        @endif
                    @else
                        <div class="card-body">
                            There are no articles for this query
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection

