@extends("layout")

@section('title', ' Create Post')

@section('stylesheet')
	
	{!! Html::style('css/file-input/fileinput.css') !!}
	
	{!! Html::script('js/tinymce/tinymce.min.js') !!}
	{!! Html::script('js/tinymce/textArea.js') !!}

@endsection

@section("content")

<div class="row">
	<div class="col-md-10 col-md-offset-1">
		<h1>Create New Post</h1>
		<hr>

		@if( session('posted') )
			<div class="alert alert-success">{{session('posted')}}</div>
		@endif

		{!! Form::open([ 'route' => 'posts.store', 'files' => true]) !!}
			
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

			<div class="form-group {{ count($errors->get('images.*')) > 0 ? 'has-error' : '' }}">
				<noscript>Javascript required to upload images.<br/></noscript>
				<label class="control-label" for="images[]">Images:</label>
				<input id="images" name="images[]" type="file" multiple class="file-loading" accept="image/*" />
				<span id="images" class="help-block">
					@foreach($errors->get('images.*') as $message)
						{{ $message[0] }} <br/>
					@endforeach
				</span>
			</div>

			{!! Form::submit('Post', ['class' => 'btn btn-success btn-lg btn-block form-spacing-top']) !!}

		{!! Form::close() !!}

	</div>
</div>

@endsection

@section('javascript')
	
	{!! Html::script('js/file-input/plugins/canvas-to-blob.js') !!}
	{!! Html::script('js/file-input/plugins/sortable.js') !!}
	{!! Html::script('js/file-input/plugins/purify.js') !!}
	{!! Html::script('js/file-input/fileinput.js') !!}
	{!! Html::script('js/file-input/fileinputCreatePost.js') !!}

@endsection