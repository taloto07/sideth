@extends("layout")

@section('title', ' All Post');

@section("content")

<table class="table table-striped">
	<tr>
		<th>Title</th>
		<th>Description</th>
		<th>Category</th>
		<th>Location</th>
		@can('update', App\Post::class)
			<th>Actions</th>
		@endcan
	</tr>
	@foreach($posts as $post)
		<tr>
			<td><a href="{{ route('posts.show', $post->id) }}">{{ $post->title }}</a></td>
			<td> {{ substr(strip_tags($post->description), 0, 50) }}{{ strlen(strip_tags($post->description)) > 50 ? '...' : '' }}</td>
			<td>{{ $post->category->name }}</td>
			<td>{{ $post->location->city }}</td>
			@can('update', App\Post::class)
				<td>
					<div class="row">
						<div class="col-md-3">
							<button class="btn btn-primary">edit</button>
						</div>
						<div class="col-md-3">
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