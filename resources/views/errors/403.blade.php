@extends('layout')

@section('title', '403 Forbidden')

@section('content')

<div style="background:url({{ url('css/img/403-bg.jpg') }} ) no-repeat scroll center center / cover; padding-bottom: 230px;">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div style="text-align:center;padding: 60px 0px;">
				<h1 style="text-transform: uppercase; font-size: 36px; font-weight: 300; line-height: 1.2; color: #000; margin-bottom: 30px;">Access Denied</h1>
				<span style="color: #666; display: block; font-size: 16px; font-weight: 300; padding-bottom: 50px;">Unfortunately, the page you are trying to view is forbidden and access is not allowed.</span>
				<h1 style="color: #fff; font-size: 280px; line-height: 1; font-weight: 300; text-shadow: 2.828px 2.828px 4px rgba(0, 0, 0, 0.04)">403</h1>
			</div>
		</div>
	</div>
</div>

@endsection