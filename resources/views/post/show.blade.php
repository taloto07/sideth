@extends("layout")

@section('title', $post->title);

@section("content")

	{{$post->title}}

	<div>
		@foreach($post->images as $image)
			<img src="{{ asset('storage/' . $image->path) }}" width="100px" />
		@endforeach
	</div>

	{!! $post->description !!}

@endsection