@extends("layout")

@section('title', ' Search')

@section("content")
<div class="row">

	<div class="col-md-12">
		@if($posts->count() == 0)
			<h2>Sorry, no result...</h2>
		@endif
		@if ($posts->count())
			<div class="form-inline pull-right">
				{!! Form::label('sort', 'Sort: ') !!}
				{!! Form::select('sort', $sorts, Request::get('sort'), ['placeholder' => '----', 'class' => 'form-control', 'id' => 'sort']) !!}
			</div>
			
			<table class="table table-striped">
				@foreach($posts as $post)
					<tr>
						<td>
							<a href="{{ route('posts.show', $post->id) }}"> 
								{!! $post->images()->count() > 0 ? "<img width='30px' height='30px' src='". asset('storage/' . $post->images()->first()->path) ."' />" : "" !!}
							</a>
						</td>
						<td>
							<a href="{{ route('posts.show', $post->id) }}">{{ $post->title }}</a>
						</td>
						<td> 
							{{ substr(strip_tags($post->description), 0, 50) }}{{ strlen(strip_tags($post->description)) > 50 ? '...' : '' }}
						</td>
						<td>{{ $post->category->name }}</td>
						<td>{{ $post->location->city }}</td>
						@can('update', App\Post::class)
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
		@endif
	</div>
</div>

@endsection

@section('javascript')

	<script type="text/javascript">
		
		$(document).ready(function(){

			var sortChange = function(){
				var sort = $('#sort').val();
				$('#searchForm').append("<input name='sort' type='hidden' value='" + sort + "' />");
			}
			
			$('#sort').change(function(){
				sortChange();
				$('#searchForm').submit();
			});

			$('#searchForm').submit(function(){
				sortChange();
				return true;
			});
		});
		
	</script>

@endsection