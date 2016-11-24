@extends("layout")

@section('title', $post->title);

@section("content")

{{$post->title}}

<br>

{!! $post->description !!}

@endsection