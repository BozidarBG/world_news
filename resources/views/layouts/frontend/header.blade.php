<header class="header-area">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <nav class="navbar navbar-expand-lg">
                    <!-- Logo -->
                    <a class="navbar-brand" href="{{route('start')}}"><img src="{{URL('img/core-img/logo.png')}}" alt="Logo"></a>
                    <!-- Navbar Toggler -->
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#worldNav" aria-controls="worldNav" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                    <!-- Navbar -->
                    <div class="collapse navbar-collapse" id="worldNav">
                        <ul class="navbar-nav ml-auto">
                            @foreach($categories as $category)
                            <li class="nav-item {{Route::current()->slug==$category->slug ? 'active' : ''}}">
                                <a class="nav-link" href="{{route('category', ['slug'=>$category->slug])}}">{{$category->title}}</a>
                            </li>
                           @endforeach
                            @guest
                            <li class="nav-item {{Route::current()->slug==$category->slug ? 'active' : ''}}">
                                <a class="nav-link login-event" href="#login-form">Login</a>

                            </li>
                            <li class="nav-item {{Route::current()->slug==$category->slug ? 'active' : ''}}">
                                @if (Route::has('register'))
                                    <a class="nav-link register-event" href="#register-form">Register</a>
                                @endif
                            </li>
                            @else
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        {{ Auth::user()->name }} <span class="caret"></span>
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="{{route('profile.edit')}}">Profile</a>
                                        @if(Auth::user()->isAdministrator() || Auth::user()->isModerator() || Auth::user()->isJournalist())
                                        <a class="dropdown-item" href="{{route('admin.dashboard')}}">Dashboard</a>
                                        @endif
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                           onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            {{ __('Logout') }}
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            @csrf
                                        </form>

                                    </div>
                                </li>
                                @endguest
                        </ul>
                        <!-- Search Form  -->
                        <div id="search-wrapper">
                            <form action="{{route('search')}}" method="GET">

                                <input type="text" id="search" name="query" placeholder="Search something...">
                                <div id="close-icon"></div>
                                <input class="d-none" type="submit" value="">
                            </form>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </div>

</header>

