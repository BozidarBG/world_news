@extends('layouts.frontend.frontend')
@section('styles')
    <style>

    </style>
    @endsection
@section('content')
            <!-- ============= Post Content Area Start ============= -->
    <div class="col-12 col-lg-8">
        <div class="post-content-area mb-50">
            <!-- Catagory Area -->
            <div class="world-catagory-area">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="title">{{$category_title}}</li>
                </ul>

                <div class="tab-content" id="myTabContent">
                @foreach($articles as $article)
                    <div class="tab-pane fade show active" id="world-tab-1" role="tabpanel" aria-labelledby="tab1">
                        <!-- Single Blog Post -->
                        <div class="single-blog-post post-style-4 d-flex align-items-center single-height">
                            <!-- Post Thumbnail -->
                            <div class="post-thumbnail">
                                <img src="{{asset($article->photo)}}" alt="{{$article->title}}">
                            </div>
                            <!-- Post Content -->
                            <div class="post-content">
                                <a href="{{route('show', ['category_slug'=>$article->category->slug, 'article_slug'=>$article->slug ])}}" class="headline">
                                    <h5>{{$article->title}}</h5>
                                </a>
                                <p>{{$article->shortenText(10)}}</p>
                                <!-- Post Meta -->
                                <div class="post-meta">
                                    <p><span class="post-author">{{$article->user->name}}</span> on <span class="post-date">{{$article->showDate()}}</span></p>
                                </div>
                            </div>
                        </div>

                    </div>
                @endforeach


                </div>
            </div>
            @if($articles->perPage()<$articles->total())
                <nav class="text-center ">
                    <ul class="pagination justify-content-center mt-5">
                        {{$articles->render()}}
                    </ul>
                </nav>
            @endif
        </div>
    </div>

    <!-- ========== Sidebar Area ========== -->
    @include('layouts.frontend.sidebar')
@endsection