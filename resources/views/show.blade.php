@extends('layouts.frontend.frontend')
@section('styles')
    <link rel="stylesheet" href="{{asset('css.toastr.css')}}">
    @toastr_css
<style>


</style>
@endsection
@section('content')
        <!-- ============= Post Content Area Start ============= -->
<div class="col-12 col-lg-8">
    <div class="post-content-area mb-30">

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
                        <p><span  class="post-author">{{$article->user->name}}</span> on <span class="post-date">{{$article->showDate( true)}}</span></p>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>



<!-- ========== Sidebar Area ========== -->
@include('layouts.frontend.sidebar')

<!-- comments ------------------------------->
<div class="row">
    <div class="col-12 col-lg-8">
        <!--comment form start --->
        @if(Auth::check())
        <div class="post-a-comment-area pt-4 pb-4">
            <h5>Your comment</h5>
            <!-- Contact Form -->
            <form action="{{route('comment.store')}}" method="post">
                <div class="row">
                    {{csrf_field()}}
                    <div class="col-12">
                        <div class="group">
                            <input type="hidden" name="name" value="{{$article->slug}}">
                            <textarea name="body" id="message" required></textarea>
                            <span class="highlight"></span>
                            <span class="bar"></span>
                            <label>Enter your comment</label>
                        </div>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn world-btn">Post comment</button>
                    </div>
                </div>
            </form>
        </div>
        @else
        <h5>Please <a class="btn world-btn login-event" href="#login-form">login</a> or <a href="#register-form" class="btn world-btn register-event">register</a> to comment this article </h5>
        @endif
    </div>
    <!-- end comment form-->

    <div class="col-12 col-lg-8">
        <!-- Comment Area Start - comment then reply, if any -->
        <div class="comment_area clearfix mt-70">
            @if($article->comments->count() > 0)

            <ol>
                @foreach($article->comments as $comment)
                <!-- Single Comment Area -->
                <li class="single_comment_area">
                    <!-- Comment Content -->
                    <div class="comment-content">
                        <!-- Comment Meta -->
                        <div class="comment-meta d-flex align-items-center justify-content-between">
                            <p>
                                <span class="post-author">{{$comment->user->name}}</span> on <span class="post-date">{{$comment->showDate($comment->created_at, true)}}</span>
                            </p>
                            @if(Auth::check())
                            <a href="#" class="comment-reply btn world-btn">Reply</a>
                            @endif
                        </div>
                        <p>{{$comment->body}}</p>
                    </div>
                    <!--- replies start if any ----->
                    @if(Auth::check())
                    <div class="post-a-comment-area pt-4 pb-4 mt-3 hiddenReplyForm" id="reply{{$comment->id}}">
                        <h5>Reply</h5>
                        <!-- Contact Form -->
                        <form action="{{route('reply.store')}}" method="post">
                            <div class="row">
                                {{csrf_field()}}
                                <div class="col-12">
                                    <div class="group">
                                        <input type="hidden" name="name" value="{{$comment->id}}">
                                        <textarea name="body" id="message" required></textarea>
                                        <span class="highlight"></span>
                                        <span class="bar"></span>
                                        <label>Enter your reply for this comment</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn world-btn">Post reply</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    @endif

                    @if($comment->replies->count()>0)
                        @foreach($comment->replies as $reply)
                    <ol class="children">
                        <li class="single_comment_area">
                            <!-- Reply Content -->
                            <div class="comment-content">
                                <!-- Reply Meta -->
                                <div class="comment-meta d-flex align-items-center justify-content-between">
                                    <p>
                                        <span class="post-author">{{$reply->user->name}}</span> on <span class="post-date">{{$reply->showDate($reply->created_at, true)}}</span>
                                    </p>
                                </div>
                                <p>{{$reply->body}}</p>
                            </div>
                        </li>
                    </ol>
                        @endforeach
                    @endif


                    <!-- reply end all --->
                </li>
                @endforeach
            </ol>
            @else
            There are no comments for this article
            @endif
        </div>
    </div>
</div>

@endsection

@section('scripts')
    @toastr_js
    <script src="{{asset('js.toastr.js')}}"></script>
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