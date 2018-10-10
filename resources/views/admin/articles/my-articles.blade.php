@extends('layouts.admin.adminlayout')
@section('styles')
    <style>
        .table th, .table td{
            font-size: 80%;
        }
        .draft-header{
            background: yellow;
        }
        .unapproved-header{
            background: orange;
        }
        .approved-header{
            background: green;
        }
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header draft-header">
                    Drafts Articles
                </div>
                <div class="card-body">
                    @if(count($drafts))
                        <table class="table table-sm table-hover table-striped">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Category</th>
                                <th>Title</th>
                                <th>Status</th>
                                <th>Approved By</th>
                                <th>Last Change</th>
                                <th>Edit</th>
                                <th>Trash</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($drafts as $draft)
                                <tr>
                                    <td>{{$draft->id}}</td>
                                    <td>{{$draft->category->title}}</td>
                                    <td>{{$draft->title}}</td>
                                    <td>{{$draft->approved()}}</td>
                                    <td>{{$draft->approvedBy()}}</td>
                                    <td>{{$draft->updated_at->format('d.m.Y')}}
                                        <br>
                                        {{$draft->updated_at->format('H:i:s')}}
                                    </td>
                                    <td><a href="{{route('articles.edit', $draft->slug)}}" class="btn btn-info btn-sm">Edit</a></td>
                                    <td>
                                        <form method="POST"
                                              action="{{route('articles.destroy', ['slug'=> $draft->slug])}}" >

                                            {!! csrf_field() !!}
                                            <input type="submit" class="btn btn-danger btn-sm" value="Del" name="submit"
                                                   onclick=" return confirm('Are you sure that you want to send this article to trash?')">
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                    @else
                        <div class="card-body">
                            There are no articles for this query
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-2">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-warning">
                    Unapproved Articles
                </div>
                <div class="card-body">
                    @if(count($unapproved_articles))
                        <table class="table table-sm table-hover table-striped">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Category</th>
                                <th>Title</th>
                                <th>Last Change</th>
                                <th>Edit</th>
                                <th>Trash</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($unapproved_articles as $article)
                                <tr>
                                    <td>{{$article->id}}</td>
                                    <td>{{$article->category->title}}</td>
                                    <td>{{$article->title}}</td>
                                    <td>{{$article->updated_at->format('d.m.Y')}}
                                        <br>
                                        {{$article->updated_at->format('H:i:s')}}
                                    </td>
                                    <td><a href="{{route('articles.edit', $article->slug)}}" class="btn btn-info btn-sm">Edit</a></td>
                                    <td>
                                        <form method="POST"
                                              action="{{route('articles.destroy', ['slug'=> $article->slug])}}" >

                                            {!! csrf_field() !!}
                                            <input type="submit" class="btn btn-danger btn-sm" value="Del" name="submit"
                                                   onclick=" return confirm('Are you sure that you want to send this article to trash?')">
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                    @else
                        <div class="card-body">
                            There are no articles for this query
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-2">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-success">
                    Approved Articles
                </div>
                <div class="card-body">
                    @if(count($approved_articles))
                        <table class="table table-sm table-hover table-striped">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Category</th>
                                <th>Title</th>
                                <th>Approved by</th>
                                <th>Last Change</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($approved_articles as $article)
                                <tr>
                                    <td>{{$article->id}}</td>
                                    <td>{{$article->category->title}}</td>
                                    <td>{{$article->title}}</td>
                                    <td>{{$article->approvedBy()}}</td>
                                    <td>{{$article->updated_at->format('d.m.Y')}}
                                        <br>
                                        {{$article->updated_at->format('H:i:s')}}
                                    </td>

                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        @if($approved_articles->perPage()<$approved_articles->total())
                            <nav class="text-center">
                                <ul class="pagination justify-content-center">
                                    {{$approved_articles->render()}}
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