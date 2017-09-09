@extends('layouts.app')
@section('page-title', 'Product')

@section('content')
<div class="container">
	<h2>Product</h2>
	<a href="{{ route('admin.products.create')}}">Add Product</a> 
	<table class="table">
		<thead>
		  <tr>
			<th>No</th>
			<th>Id</th>
			<th>Name</th>
			<th>Image</th>
			<th>Category</th>
			<th>Indexing</th>
			<th>Actions</th>
		  </tr>
		</thead>
		<tbody>
		@if( $products != null )
			@foreach($products as $key=>$product)
			<tr>
				<td>{{ $key + 1 }}</td>
				<td>{{ $product->id }}</td>
				<td>{{ $product->name }}</td>
				<td>{{ $product->image }}</td>
				<td>{{ $product->category_id }}</td>
				<td>{{ $product->indexing }}</td>
				<td>
					{!! Form::open(['route' => ['admin.products.destroy', $product->id], 'method' => 'delete']) !!}
					<div class='btn-group'>
						<a href="{{ route('admin.products.show', [$product->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
						<a href="{{ route('admin.products.edit', [$product->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
						{!! Form::button('<i class="glyphicon glyphicon-trash"></i>', 
						[	'type' => 'submit',
							'class' => 'btn btn-danger btn-xs',
							'data-tr' => "tr_{{$product->id}}",
							'data-toggle' => "confirmation",
							'data-btn-ok-label' => "Delete",
							'data-btn-ok-icon' => "fa fa-remove",
							'data-btn-ok-class' => "btn btn-sm btn-danger",
							'data-btn-cancel-label' => "Cancel",
							'data-btn-cancel-icon' => "fa fa-chevron-circle-left",
							'data-btn-cancel-class' => "btn btn-sm btn-default",
							'data-title' => "Are you sure you want to delete ?",
							'data-placement' => "left",
							'data-singleton' => "true"]) !!}
					</div>
					{!! Form::close() !!}
				</td>
			</tr>
			@endforeach
		@endif
		</tbody>
	</table>
	<div class="form-group" align="center">
		{{ $products->appends(['key_search' => $key_search])->links() }}
    </div>
	<div class="fb-like"
		data-share="true"
		data-width="450"
		data-show-faces="true">
	</div>
	<div id="fb-root"></div>
</div>
@endsection

@section('script')
<script>
	$('[data-toggle=confirmation]').confirmation({
		rootSelector: '[data-toggle=confirmation]',
		onConfirm: function (event, element) {
			element.trigger('confirm');
		}
	});
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
		js.src = "//connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.10";
		fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));*/
</script>
@endsection