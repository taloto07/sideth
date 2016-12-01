@extends("layout")

@section('title', ' Home')

@section("content")

@if (session('register_status'))
    <div class="alert alert-success">
        {{ session('register_status') }}
    </div>
@endif

@if (session('activate_success'))
    <div class="alert alert-success">
        {{ session('activate_success') }}
    </div>
@endif

@if ($errors->has('activation'))
	<div class="alert alert-danger">
        {{ $errors->first('activation') }}
    </div>
@endif

<!-- Main component for a primary marketing message or call to action -->
<div class="jumbotron">
	<h1>Navbar example</h1>
	<p>This example is a quick exercise to illustrate how the default, static and fixed to top navbar work. It includes the responsive CSS and HTML, so it also adapts to your viewport and device.</p>
	<p>To see the difference between static and fixed top navbars, just scroll.</p>
	<p>
  		<a class="btn btn-lg btn-primary" href="{{ route('posts.index') }}" role="button">View All Posts &raquo;</a>
	</p>
</div>

@endsection