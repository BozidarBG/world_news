<div class="world-latest-articles">
    <div class="row">
        @foreach($categories as $category)
            <div class="col-12 col-lg-6">
                <div class="title">
                    <h5>{{$category->title}}</h5>
                </div>
                <?php $seconds=0.2; ?>
                @foreach($category->latestFourArticles() as $article)
                        <!-- Single Blog Post -->
                <div class="single-blog-post post-style-4 d-flex align-items-center single-height wow fadeInUpBig" data-wow-delay="$seconds.s">
                    <!-- Post Thumbnail -->
                    <div class="post-thumbnail">
                        <img src="{{$article->photo}}" alt="{{$article->title}}">
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
                <?php $seconds+=0.1; ?>
                @endforeach

            </div>
        @endforeach

    </div>
</div>