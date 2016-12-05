@extends("layout")

@section('title', ' All Post')

@section("content")

<table class="table table-striped">
	<caption><h1>Show All Posts</h1></caption>
	<tr>
		<th>Image</th>
		<th>Title</th>
		<th>Description</th>
		<th>Category</th>
		<th>Location</th>
		@can('create', App\Post::class)
			<th>Actions</th>
		@endcan
	</tr>
	@foreach($posts as $post)
		<tr>
			<td>
				<a href="{{ route('posts.show', $post->id) }}"> 
					{!! $post->images()->count() > 0 ? "<img width='30px' height='30px' src='". asset('storage/' . $post->images()->first()->path) ."' />" : "" !!} </td>
				</a>
			<td>
				<a href="{{ route('posts.show', $post->id) }}">{{ $post->title }}</a>
			</td>
			<td> {{ substr(strip_tags($post->description), 0, 50) }}{{ strlen(strip_tags($post->description)) > 50 ? '...' : '' }}</td>
			<td>{{ $post->category->name }}</td>
			<td>{{ $post->location->city }}</td>
			@can('update', $post)
				<td>
					<div class="row">
						<div class="col-md-3">
							<a class="btn btn-primary" href="{{ route('posts.edit', ['post' => $post->id]) }}">edit</a>
						</div>
						<div class="col-md-3 col-md-offset-1">
							{!! Form::open(['route' => ['posts.destroy', $post->id], 'method' => 'delete' ]) !!}
								{!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
							{!! Form::close() !!}
						</div>
					</div>
				</td>
			@endcan
		</tr>
	@endforeach
</table>

@endsection