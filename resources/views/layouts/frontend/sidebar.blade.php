<div class="col-12 col-md-8 col-lg-4">
    <div class="post-sidebar-area wow fadeInUpBig" data-wow-delay="0.2s">

        <!-- Widget Area -->
        <div class="sidebar-widget-area">
            <h5 class="title">Most viewed news</h5>
            <div class="widget-content">
                @if($sidebar_articles)
                @foreach($sidebar_articles as $article)
                <!-- Single Blog Post -->
                <div class="single-blog-post post-style-2 d-flex align-items-center widget-post">
                    <!-- Post Thumbnail -->
                    <div class="post-thumbnail pt-3 pb-3">
                        <img src="{{asset($article->photo)}}" alt="{{$article->title}}">
                    </div>
                    <!-- Post Content -->
                    <div class="post-content">
                        <a href="{{route('show', ['category_slug'=>$article->category->slug, 'article_slug'=>$article->slug ])}}" class="headline">
                            <h5 class="mb-0">{{$article->title}}</h5>
                        </a>
                    </div>
                </div>
                @endforeach
                @else

                @endif



            </div>
        </div>


    </div>
</div>