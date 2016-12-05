<!-- Fixed navbar -->
<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ url('/') }}">Sideth</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li class="{{Request::is('about') ? 'active' : ''}}"><a href="{{ url('about') }}">About</a></li>
                <li class="{{Request::is('contact') ? 'active' : ''}}"><a href="{{ url('contact') }}">Contact</a></li>
        
            </ul>
            
            {!! Form::open(['route' => 'posts.search', 'method' => 'get', 'class' => 'navbar-form navbar-left', 'role' => 'search', 'id' => 'searchForm']) !!}
                <div class="form-group">
                    {!! Form::text('keyword', Request::get('keyword'), ['class' => 'form-control', 'placeholder' => 'What are you looking for...']) !!}
                </div>
                <div class="form-group">
                    {!! Form::select('category_id', $categories, Request::get('category_id'), ['placeholder' => 'All Category', 'class' => 'form-control', 'id' =>  'category']) !!}
                </div>
                <div class="form-group">
                    {!! Form::select('location_id', $locations, Request::get('location_id'), ['placeholder' => 'All Location', 'class' => 'form-control', 'id' =>   'location']) !!}
                </div>
                {!! Form::submit('Search', ['class' => 'btn btn-default']) !!}
            {!! Form::close() !!}

            <ul class="nav navbar-nav navbar-right">
                @if (!Auth::check())
                    <li class="{{Request::is('login') ? 'active' : ''}}"><a href="{{ url('login') }}">Login</a></li>
                    <li class="{{Request::is('register') ? 'active' : ''}}"><a href="{{ url('register') }}">Register</a></li>
                @else
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> {{ Auth::user()->name }} <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            @can('create', App\Post::class)
                                <li><a href="{{ route('posts.create') }}">Post</a></li>
                            @endcan
                            <li><a href="{{ route('logout') }}">Logout</a></li>
                            
                        </ul>
                    </li>

                @endif
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>