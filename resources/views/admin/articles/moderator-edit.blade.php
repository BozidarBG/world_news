@extends('layouts.frontend.frontend')

@section('styles')
    @toastr_css
    <style>

    </style>
@endsection

@section('content')

    @include('admin.includes.errors')
<div class="row">
        <!-- ============= Post Content Area Start ============= -->
    <div class="col-12 col-lg-8">
        <div class="post-content-area mb-50">

            <!-- Catagory Area -->
            <div class="world-catagory-area">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="title">{{$article->category->title}}</li>
                </ul>

                <div class="single-blog-content mb-20">
                    <!-- Post Meta -->
                    <div class="post-meta mt-30">
                        <h2>{{$article->title}}</h2>
                    </div>
                    <!-- Post Content -->
                    <div class="post-content">
                        <img src="{{asset($article->photo)}}" alt="{{$article->title}}" class="mb-50">
                        <p> {!! $article->body !!}</p>
                        <!-- Post Meta -->
                        <div class="post-meta second-part">
                            <p><span href="#" class="post-author">{{$article->user->name}}</span> on <span class="post-date">{{$article->updated_at->format('d.m.Y')}}</span></p>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

<div class="col-md-4 ">
    <form action="{{route('articles.moderator-update', ['id'=>$article->id])}}" method="post" >
            {{csrf_field()}}
        <div class="card mb-4 mr-4">

            <div class="card-header bg-danger ">
                <h5 class="text-white text-center">{{$article->approved ? 'Unapprove' : 'Approve'}}</h5>
            </div>
            <div class="card text-center p-4">

                <br>

                <div class="text-center">
                    <button type="submit" name="submit" class="btn btn-info">Confirm</button>
                </div>
            </div>
        </div>
    </form>
</div>
    <!-- where --->
<div class="col-12 col-md-4">
<form action="{{route('articles.moderator-article-position', ['id'=>$article->id])}}" method="post" >
    {{csrf_field()}}
    <div class="card mb-4 mr-4">

        <div class="card-header bg-danger ">
            <h5 class="text-white text-center">{{$slider ? 'Remove from slider' : 'Put in Slider'}}</h5>
        </div>
        <div class="card text-center p-4">

            <br>
            <div class="text-center">
                <button type="submit" name="submit" class="btn btn-info">Confirm</button>
            </div>
        </div>
    </div>
</form>
</div>









@endsection



@section('scripts')

    @toastr_js
    <script>
        @if(Session::has('success'))
            toastr.options.hideMethod = 'slideUp';
        toastr.success("{{Session::get('success')}}");
        @endif

        @if(Session::has('info'))
            toastr.options.hideMethod = 'slideUp';
        toastr.info("{{Session::get('info')}}");
        @endif

        @if(Session::has('error'))
            toastr.options.hideMethod = 'slideUp';
        toastr.error("{{Session::get('error')}}");
        @endif
    </script>

@endsection



