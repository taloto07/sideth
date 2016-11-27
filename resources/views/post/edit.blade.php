@extends("layout")

@section('title', "Edit $post->title");

@section("content")

{{$post->title}}

<br>

{!! $post->description !!}

@endsection