<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Admin - Dashboard</title>

    <!-- Bootstrap core CSS-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <!-- Custom fonts for this template-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

    <!-- Custom styles for this template-->
    <link href="{{asset('css/sb-admin.css')}}" rel="stylesheet">


    @toastr_css
    @yield('styles')

</head>

<body id="page-top" class="sidebar-toggled">

<nav class="navbar navbar-expand navbar-dark bg-dark static-top">
    <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Navbar Search -->
    <div class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
        <ul class="navbar-nav ml-auto ml-md-0">

            <li class="nav-item dropdown no-arrow mx-1">
                <a class="nav-link" href="{{route('email.inbox')}}"  role="button"  >
                    <i class="fas fa-envelope fa-fw"></i>
                    <?php
                    $emails=Auth::user()->showUnreadEmails();
                    ?>
                    @if( $emails > 0 )
                    <span class="badge badge-danger"> {{$emails}}</span>
                    @endif
                </a>

            </li>
            <li class="nav-item dropdown no-arrow">
                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    {{Auth::user()->name}}
                    <i class="fas fa-user-circle fa-fw"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                    <a class="dropdown-item" href="{{route('admin.profile.edit')}}">Profile</a>
                    <div class="dropdown-divider"></div>
                    <form method="post" action="{{route('logout')}}">
                        {{csrf_field()}}
                        <button class="dropdown-item">Logout</button>
                    </form>

                </div>
            </li>
        </ul>
    </div>
    <!-- Navbar -->
</nav>
<div id="wrapper">
    <!-- Sidebar -->
    <ul class="sidebar navbar-nav toggled">
        <li class="nav-item {{Route::current()->uri == 'admin/dashboard' ? 'active' : ''}}">
            <a class="nav-link" href="{{route('admin.dashboard')}}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <li class="nav-item dropdown {{Route::current()->uri === 'admin/approved-articles'
        || Route::current()->uri === 'admin/unapproved-articles'
        || Route::current()->uri === 'admin/trashed-articles'
        || Route::current()->uri === 'admin/create-articles'
        || Route::current()->uri === 'admin/my-articles' ? 'active' : ''}}">
            <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-fw fa-folder"></i>
                <span>Articles</span>
            </a>
            <div class="dropdown-menu" aria-labelledby="pagesDropdown">

                <a class="dropdown-item" href="{{route('articles.approved')}}">Approved</a>
                <a class="dropdown-item" href="{{route('articles.unapproved')}}">Unapproved</a>
                <a class="dropdown-item" href="{{route('articles.trashed')}}">Trashed</a>
                @if(Auth::user()->isJournalist())
                <div class="dropdown-divider"></div>
                <h6 class="dropdown-header">Other Pages:</h6>
                <a class="dropdown-item" href="{{route('articles.create')}}">New Article</a>
                <a class="dropdown-item" href="{{route('articles.my-articles')}}">My Articles</a>
                @endif
            </div>
        </li>
        <li class="nav-item {{Route::current()->uri === 'admin/users' || Route::current()->uri === 'admin/users/create'? 'active' : ''}}">
            <a class="nav-link" href="{{route('users.index')}}">
                <i class="fas fa-users"></i>
                <span>Users</span></a>
        </li>
        @if(Auth::user()->isAdministrator())
        <li class="nav-item {{Route::current()->uri === 'admin/categories' ? 'active' : ''}}">
            <a class="nav-link" href="{{route('categories.index')}}">
                <i class="fas fa-fw fa-table"></i>
                <span>Categories</span></a>
        </li>
        <li class="nav-item {{Route::current()->uri === 'admin/settings/edit' ? 'active' : ''}}">
            <a class="nav-link" href="{{route('settings.edit')}}">
                <i class="fas fa-cogs"></i>
                <span>Settings</span></a>
        </li>
        @endif
        @if(Auth::user()->isModerator())
            <li class="nav-item dropdown {{Route::current()->uri === 'admin/unapproved-comments'
        || Route::current()->uri === 'admin/approved-comments'
        || Route::current()->uri === 'unapproved-replies'
        || Route::current()->uri === 'admin/approved-replies'
        ? 'active' : ''}}">
                <a class="nav-link dropdown-toggle" href="" id="emailPagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="far fa-comments"></i>
                    <span>Comments<br>& Replies</span>
                </a>
                <div class="dropdown-menu" aria-labelledby="emailPagesDropdown">
                    <a class="dropdown-item" href="{{route('comments.unapproved')}}">Unapproved<br>Comments</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{route('comments.approved')}}">Approved<br>Comments</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{route('replies.unapproved')}}">Unapproved<br>Replies</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{route('replies.approved')}}">Approved<br>Replies</a>
                </div>
            </li>


        @endif
        <li class="nav-item dropdown {{Route::current()->uri === 'admin/email/inbox'
        || Route::current()->uri === 'admin/email/sent'
        || Route::current()->uri === 'admin/email/drafts'
        || Route::current()->uri === 'admin/email/trash'
        || Route::current()->uri === 'admin/email/create'
        || Route::current()->uri === 'admin/email/show*'? 'active' : ''}}">
            <a class="nav-link dropdown-toggle" href="" id="emailPagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-envelope"></i>
                <span>Emails</span>
            </a>
            <div class="dropdown-menu" aria-labelledby="emailPagesDropdown">
                <a class="dropdown-item" href="{{route('email.inbox')}}">Inbox</a>
                <a class="dropdown-item" href="{{route('email.sent')}}">Sent</a>
                <a class="dropdown-item" href="{{route('email.drafts')}}">Drafts</a>
                <a class="dropdown-item" href="{{route('email.trash')}}">Trash</a>
            </div>
        </li>
    </ul>

    <div id="content-wrapper">
        <div class="container-fluid">
            <!-- Breadcrumbs-->

@yield('content')

        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content-wrapper -->
</div>
<!-- /#wrapper -->
<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>


<!-- Bootstrap core JavaScript-->
<!--<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>


<!-- Custom scripts for all pages-->
<script src="{{asset('js/sb-admin.js')}}"></script>


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

@yield('scripts')
</body>

</html>
