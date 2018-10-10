<div class="hero-area">

    <!-- Hero Slides Area -->
    <div class="hero-slides owl-carousel">
        <!-- Single Slide -->

        <div class="single-hero-slide bg-img background-overlay" style="background-image: url('<?php echo asset('img/blog-img/bg1.jpg'); ?>');"></div>
        <!-- Single Slide -->
        <div class="single-hero-slide bg-img background-overlay" style="background-image: url('<?php echo asset('img/blog-img/bg2.jpg'); ?>');"></div>
    </div>

    <!-- Hero Post Slide -->
    <div class="hero-post-area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="hero-post-slide">

                        @if($fr_slider)
                            <?php $i=1; ?>
                            @foreach($fr_slider as $slide)
                        <!-- Single Slide -->
                            <div class="single-slide d-flex align-items-center">
                                <div class="post-number">
                                    <p>{{$i}}</p>
                                </div>
                                <div class="post-title">
                                    <a href="{{route('show', ['category_slug'=>$slide->article->category->slug, 'article_slug'=>$slide->article->slug ])}}">{{$slide->article->title}}</a>
                                </div>
                            </div>
                            <?php $i++; ?>
                            @endforeach
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>