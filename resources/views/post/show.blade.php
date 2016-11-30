@extends("layout")

@section('title', $post->title)

@section("content")
	
	<div class="col-md-8">
		{{$post->title}}

		<div>
			@foreach($post->images as $image)
				<img src="{{ asset('storage/' . $image->path) }}" width="100px" />
			@endforeach
		</div>

		{!! $post->description !!}
	</div>

	<div class="col-md-4">
		@can('update', App\Post::class)
			<div class="well">
				
				<dl class="dl-horizontal">
					<dt>Created At: </dt>
					<dd>{{ $post->created_at->format('M j, Y h:ia') }}</dd>
				</dl>

				<dl class="dl-horizontal">
					<dt>Last Updated: </dt>
					<dd>{{ $post->updated_at->format('M j, Y h:ia') }}</dd>
				</dl>

				<hr/>

				<div class="row">
					
					<div class="col-sm-6">
						{!! Html::linkRoute('posts.edit', 'Edit', ['post' => $post->id], ['class' => 'btn btn-success btn-block']) !!}
					</div>
					<div class="col-sm-6">
						{!! Form::model($post, ['route' => ['posts.destroy', $post->id], 'method' => 'delete']) !!}
							{!! Form::submit('Delete', ['class' => 'btn btn-danger btn-block']) !!}
						{!! Form::close() !!}
					</div>
					
				</div>
			</div>
		@endcan
	</div>

@endsection