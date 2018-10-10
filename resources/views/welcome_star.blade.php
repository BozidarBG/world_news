<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>
                        <a href="{{ route('register') }}">Register</a>
                    @endauth
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md">
                    Laravel
                </div>

                <div class="links">
                    <a href="https://laravel.com/docs">Documentation</a>
                    <a href="https://laracasts.com">Laracasts</a>
                    <a href="https://laravel-news.com">News</a>
                    <a href="https://nova.laravel.com">Nova</a>
                    <a href="https://forge.laravel.com">Forge</a>
                    <a href="https://github.com/laravel/laravel">GitHub</a>
                </div>
            </div>
        </div>
    </body>
</html>


<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-primary" href="login.html">Logout</a>
            </div>
        </div>
    </div>
</div>


<a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">Modal</a>


<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fas fa-fw fa-folder"></i>
        <span>Pages</span>
    </a>
    <div class="dropdown-menu" aria-labelledby="pagesDropdown">
        <h6 class="dropdown-header">Login Screens:</h6>
        <a class="dropdown-item" href="login.html">Login</a>
        <a class="dropdown-item" href="register.html">Register</a>
        <a class="dropdown-item" href="forgot-password.html">Forgot Password</a>
        <div class="dropdown-divider"></div>
        <h6 class="dropdown-header">Other Pages:</h6>
        <a class="dropdown-item" href="404.html">404 Page</a>
        <a class="dropdown-item" href="blank.html">Blank Page</a>
    </div>
</li>

<!------------------------------------------------------------------------------------>
<div class="col-12 col-lg-12">
    <div class="post-a-comment-area mt-10 mb-5 pb-4 pt-4">
        @if(Auth::check())
            <h5>Get in Touch</h5>
            <!-- Comment Form -->
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
        @else
            <h5>Please <a class="btn world-btn" href="{{route('login')}}">login</a> to comment this article </h5>
        @endif
    </div>
</div>

<div class="col-12 col-lg-12">
    <!-- Comment Area Start -->
    <div class="comment_area clearfix mt-3">
        <ol>
            <!-- Single Comment Area -->
            @if($article->comments->count() > 0)
                @foreach($article->comments as $comment)
                    <li class="single_comment_area">
                        <!-- Comment Content -->
                        <div class="comment-content">
                            <!-- Comment Meta -->
                            <div class="comment-meta d-flex align-items-center justify-content-between">
                                <p><span class="post-author">{{$comment->user->name}}</span> on <span class="post-date">{{$comment->showDate($comment->created_at, true)}}</span></p>
                                @if(Auth::check())
                                    <a href="#" class="comment-reply btn world-btn">Reply</a>
                                @endif
                            </div>
                            <p>{{$comment->body}}</p>
                        </div>
                        <!-- show reply form-->
                        <div class="col-12 col-lg-12 mt-3 mb-3">
                            <div class="post-a-comment-area mt-10 mb-5 pb-4 pt-4">
                                @if(Auth::check())
                                    <h5>Post a reply for this comment</h5>
                                    <!-- Comment Form -->
                                    <form action="{{route('reply.store')}}" method="post">
                                        <div class="row">
                                            {{csrf_field()}}
                                            <div class="col-12">
                                                <div class="group">
                                                    <input type="hidden" name="name" value="{{$comment->id}}">
                                                    <textarea name="body" id="message" required></textarea>
                                                    <span class="highlight"></span>
                                                    <span class="bar"></span>
                                                    <label>Enter your reply</label>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <button type="submit" class="btn world-btn">Post reply</button>
                                            </div>
                                        </div>
                                    </form>
                                @else
                                    <h5>Please <a class="btn world-btn" href="{{route('login')}}">login</a> to comment this article </h5>
                                @endif
                            </div>
                        </div>
                        <!-- end reply form-->
                        @if($comment->replies->count()>0)
                            @foreach($comment->replies as $reply)
                                <ol class="children">
                                    <li class="single_comment_area">
                                        <!-- Comment Content -->
                                        <div class="comment-content">
                                            <!-- Comment Meta -->
                                            <div class="comment-meta d-flex align-items-center justify-content-between">
                                                <p><span class="post-author">{{$reply->user->name}}</span> on <span class="post-date">{{$reply->showDate($reply->crated_at, true)}}</span></p>

                                            </div>
                                            <p>{{$reply->body}}</p>
                                        </div>
                                    </li>
                                </ol>
                            @endforeach
                        @endif
                    </li>
                @endforeach
            @endif
        </ol>
    </div>
</div>


public function store(Request $request)
{
dd($request->all());
//ako dolazimo sa edit, onda smo stavili id emaila u sesiju. ako ne, onda je id emaila null
$email_id = Session::has('email_id') ? Session::pull('email_id') : null;
if ($request->has('send')) {
$this->sendEmail($request, $email_id);
return redirect()->route('email.inbox');
} elseif ($request->has('save')) {
$this->saveToDrafts($request, $email_id);
return redirect()->route('email.inbox');
} else {
//nešto je petljao oko html-a
return redirect()->back();
}
}


protected function sendEmail($request, $email_id)
{
$this->validate($request, [
'receiver' => 'required|integer',
'title' => 'required|string',
'body' => 'required|string',
]);

$receiver = User::where('id', $request->receiver)->first();
if ($receiver) {
if ($email_id) {
//znači dolazimo sa edit. ne pravimo novu instancu nego koristimo postojeći red
$email = Email::findOrFail($email_id);
$email->is_draft = 0;
Session::forget('email_id');
} else {
//znači ne dolazimo sa edit stranice. pravimo novu instancu tj novi red
$email = new Email();
$email->sender = Auth::id();
$email->receiver = $request->receiver;
$email->title = $request->title;
$email->body = $request->body;
$lastId=Email::count() ? Email::latest()->first()->id : 0;
$hashids = new Hashids('email', 10);
$hash_id=$hashids->encode($lastId+1);
$email->hashid=$hash_id;
}
if ($email->save()) {
toastr()->success('Email sent successfully!');
} else {
toastr()->error('Email was not sent!');
}
//primalac ne postoji
} else {
toastr()->error('Such user does not exists!');
return redirect()->back();
}
}

protected function saveToDrafts($request, $email_id){

if($email_id){
//znači dolazimo sa edit. ne pravimo novu instancu nego koristimo postojeći red
$email=Email::findOrFail($email_id);
$email->sender=Auth::id();
$email->receiver=$request->receiver;
$email->title=$request->title;
$email->body=$request->body;
$request->session()->forget('email_id');
$email->save();
}else{
//znači ne dolazimo sa edit stranice. pravimo novu instancu tj novi red i dajemo is_draft=true
$email=new Email();
$email->sender=Auth::id();
$email->receiver=$request->receiver;
$email->title=$request->title;
$email->body=$request->body;
$email->is_draft=true;
$lastId=Email::count() ? Email::latest()->first()->id : 0;
$hashids = new Hashids('email', 10);
$hash_id=$hashids->encode($lastId+1);
$email->hashid=$hash_id;
//
$email->save();
}
toastr()->success('Email saved to drafts successfully!');
}