@extends("layout")

@section('title', ' Create Post')

@section('stylesheet')
	{!! Html::script('js/tinymce/tinymce.min.js') !!}

	<script>
		tinymce.init({ 
			selector:'textarea',
			plugins: 'autosave lists textcolor link',
			toolbar1: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link | forecolor backcolor fontsizeselect',
		});
	</script>
@endsection

@section("content")

<div class="row">
	<div class="col-md-8 col-md-offset-2">
		<h1>Create New Post</h1>
		<hr>

		@if( session('posted') )
			<div class="alert alert-success">{{session('posted')}}</div>
		@endif

		{!! Form::open([ 'route' => 'posts.store' ]) !!}

			<div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
				{!! Form::label('title', 'Title:', ['class' => 'control-label']) !!}
				{!! Form::text('title', null, ['class' => 'form-control', 'aria-describedby' => "titleErrorMessage"]) !!}
				<span id="titleErrorMessage" class="help-block">{{ $errors->first('title') }}</span>
			</div>

			<div class="form-group {{ $errors->has('category_id') ? 'has-error' : '' }}">
				{!! Form::label('category_id', 'Category:', ['class' => 'control-label']) !!}
				{!! Form::select('category_id', $categories, null, ['placeholder' => 'Select Category', 'class' => 'form-control', 'aria-describedby' => "categoryErrorMessage"]) !!}
				<span id="categoryErrorMessage" class="help-block">{{ $errors->first('category_id') }}</span>
			</div>

			<div class="form-group {{ $errors->has('location_id') ? 'has-error' : '' }}">
				{!! Form::label('location_id', 'Location:', ['class' => 'control-label']) !!}
				{!! Form::select('location_id', $locations, null, ['placeholder' => 'Select Location', 'class' => 'form-control', 'aria-describedby' => "locationErrorMessage"]) !!}
				<span id="locationErrorMessage" class="help-block">{{ $errors->first('location_id') }}</span>
			</div>

			<div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
				{!! Form::label('description', 'Description', ['class' => 'control-label']) !!}
				{!! Form::textarea('description', null, ['class' => 'form-control', 'aria-describedby' => "descriptionErrorMessage"]) !!}
				<span id="descriptionErrorMessage" class="help-block">{{ $errors->first('description') }}</span>
			</div>

			{!! Form::submit('Post', ['class' => 'btn btn-success btn-lg btn-block form-spacing-top']) !!}

		{!! Form::close() !!}

	</div>
</div>

@endsection