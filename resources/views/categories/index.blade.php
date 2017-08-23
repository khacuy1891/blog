@extends('layouts.app')

@section('content')
<div class="container">
	<h2>Category</h2>
	<a href="{{ url('/categories/create')}}">Add Category</a> 
	<table class="table">
		<thead>
		  <tr>
			<th>No</th>
			<th>Id</th>
			<th>Name</th>
			<th>Icon</th>
			<th>Category Parent</th>
			<th>Actions</th>
		  </tr>
		</thead>
		<tbody>
		@if( $categories != null )
			@foreach($categories as $key=>$category)
			<tr>
				<td>{{ $key + 1 }}</td>
				<td>{{ $category->id }}</td>
				<td>{{ $category->name }}</td>
				<td>{{ $category->icon }}</td>
				<td>{{ $category->parent_id }}</td>
				<td>
					{!! Form::open(['route' => ['categories.destroy', $category->id], 'method' => 'delete']) !!}
					<div class='btn-group'>
						<a href="{{ route('categories.show', [$category->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
						<a href="{{ route('categories.edit', [$category->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
						{!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
					</div>
					{!! Form::close() !!}
				</td>
			</tr>
			@endforeach
		@endif
		</tbody>
	</table>
	<div class="form-group" align="center">
		{{ $categories->links() }}
    </div>
	<div class="form-group">
		<div class="fb-like"
			data-share="true"
			data-width="450"
			data-show-faces="true">
		</div>
		<div id="fb-root"></div>
    </div>
</div>
@endsection

@section('script')
<script>
  window.fbAsyncInit = function() {
    FB.init({
      appId      : '1481291711930030',
      xfbml      : true,
      version    : 'v2.10'
    });
    FB.AppEvents.logPageView();
  };

  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "//connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));
   
   /*
   (function(d, s, id) {
		var js, fjs = d.getElementsByTagName(s)[0];
		if (d.getElementById(id)) return;
		js = d.createElement(s); js.id = id;
		js.src = "//connect.facebook.net/vi_VN/sdk.js";
		fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));*/
</script>
@endsection