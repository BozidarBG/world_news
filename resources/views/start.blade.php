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
                <li class="title">Most important news</li>

            </ul>

            <div class="tab-content" id="myTabContent">

                <div class="tab-pane fade show active" id="world-tab-1" role="tabpanel" aria-labelledby="tab1">
                    <div class="row">
                        <!--start slajder------------------------------------------->
                        <div class="col-12 col-md-6">
                            <div class="world-catagory-slider owl-carousel wow fadeInUpBig" data-wow-delay="0.1s">
                                @if($fr_slider)

                                @foreach($fr_slider as $slide)
                                <!-- Single Blog Post -->
                                <div class="single-blog-post">
                                    <!-- Post Thumbnail -->
                                    <div class="post-thumbnail">
                                        <img src="{{$slide->article->photo}}" alt="{{$slide->article->title}}">
                                        <!-- Catagory -->
                                        <div class="post-cta"><a href="{{route('category',['slug'=>$slide->article->category->slug])}}">{{$slide->article->category->title}}</a></div>
                                    </div>
                                    <!-- Post Content -->
                                    <div class="post-content">
                                        <a href="{{route('show', ['category_slug'=>$slide->article->category->slug, 'article_slug'=>$slide->article->slug ])}}" class="headline">
                                            <h5>{{$slide->article->title}}</h5>
                                        </a>
                                        <p>{{$slide->article->shortenText(10)}}</p>
                                        <!-- Post Meta -->
                                        <div class="post-meta">
                                            <p><span class="post-author">{{$slide->article->user->name}}</span> on <span class="post-date">{{$slide->article->showDate()}}</span></p>
                                        </div>
                                    </div>
                                </div>

                                @endforeach
                                @endif




                            </div>
                        </div>
                        <!--end slajder------------------------------------------------------->
                        <!--pored slajdera-->
                        <div class="col-12 col-md-6">
                            <!-- Single Blog Post -->
                            @if($asideslider->count())
                                <?php $sec=0.2; ?>
                                @foreach($asideslider as $article)
                            <div class="single-blog-post post-style-2 d-flex align-items-center wow fadeInUpBig" data-wow-delay="$sec.s">
                                <!-- Post Thumbnail -->
                                <div class="post-thumbnail">
                                    <img src="{{asset($article->photo)}}" alt="{{$article->title}}" width="150px">
                                </div>
                                <!-- Post Content -->
                                <div class="post-content pt-4 pb-5">
                                    <a href="{{route('show', ['category_slug'=>$article->category->slug, 'article_slug'=>$article->slug ])}}" class="headline">
                                        <h5>{{$article->title}}</h5>
                                    </a>
                                    <!-- Post Meta -->
                                    <div class="post-meta">
                                        <p><span class="post-author">{{$article->user->name}}</span> on <span class="post-date">{{$article->showDate()}}</span></p>
                                    </div>
                                </div>
                            </div>
                            <?php $sec+=0.1; ?>
                            @endforeach
                            @endif

                        </div>
                    </div>
                </div>
                <!--kraj pored slajdera -------------------------------->


            </div>
        </div>


    </div>
</div>

<!-- ========== Sidebar Area ========== -->
@include('layouts.frontend.sidebar')



<!-- 4 articles by category, left and right ------------------------------------------------>
<div class="world-latest-articles">
    <div class="row">
        @for($i=0; $i<count($data); $i++)

        <div class="col-12 col-lg-6">
            <div class="title">
                <h5>{{$data[$i]['category']['title']}}</h5>
            </div>
            <?php $seconds=0.2; ?>

                @for($x=0; $x<count($data[$i]['articles']); $x++)
            <!-- Single Blog Post -->
            <div class="single-blog-post post-style-4 d-flex align-items-center single-height wow fadeInUpBig" data-wow-delay="$seconds.s">
                <!-- Post Thumbnail -->
                <div class="post-thumbnail">
                    <img src="{{asset($data[$i]['articles'][$x]['photo'])}}" alt="{{$data[$i]['articles'][$x]['title']}}">
                </div>
                <!-- Post Content -->
                <div class="post-content">
                    <a href="{{route('show', ['category_slug'=>$data[$i]['category']['slug'], 'article_slug'=>$data[$i]['articles'][$x]['slug'] ])}}" class="headline">
                        <h5>{{$data[$i]['articles'][$x]['title']}}</h5>
                    </a>
                    <p>{{substr($data[$i]['articles'][$x]['body'], 0, 60).'...'}}</p>
                    <!-- Post Meta -->
                    <div class="post-meta">
                        <p><span class="post-author">{{$data[$i]['articles'][$x]['user']['name']}}</span> on <span class="post-date">{{$data[$i]['articles'][$x]['updated_at']}}</span></p>
                    </div>
                </div>
            </div>
            <?php $seconds+=0.1; ?>
            @endfor

        </div>
@endfor

    </div>
</div>
<!--- end 4 articles by category, left and right ------------------------------------------------------>

    @endsection