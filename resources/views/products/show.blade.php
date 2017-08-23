@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Product</div>
                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Name *</label>
                            <div class="col-md-6">
                                <input id="name" type="name" class="form-control" name="name" value="{{$product->name}}" disabled="disabled" >
                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
						
						<div class="form-group">
                            <label for="parent_id" class="col-md-4 control-label">Category:</label>
                            <div class="col-md-6">
                                <select class="form-control" id="category_id" name="category_id" disabled="disabled">
                                @foreach($categories as $key => $value)
                                    <option value="{{ $key }}" {{ ($key == $product->category_id) ? "selected" : ""}}>{{ $value}}</option>
                                @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('image') ? ' has-error' : '' }}">
                            <label for="image" class="col-md-4 control-label">Image *</label>
                            <div class="col-md-6">
                                <!--input id="image_input" name="image" type="file" accept=".gif,.jpg,.png,.bmp,.GIF,.JPG,.PNG,.BMP" -->
                                <img src="{{asset(config('path.icon').'/'.$product->image)}}" id="image" name='image' width="128" height="128">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="indexing" class="col-md-4 control-label">Indexing</label>
                            <div class="col-md-6">
                                <input id="indexing" type="number" class="form-control" name="indexing" value="{{$product->indexing}}" disabled="disabled">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="description" class="col-md-4 control-label">Description</label>
                            <div class="col-md-6">
                                <input id="description" type="text" class="form-control" name="description" value="{{$product->description}}"  disabled="disabled" >
                            </div>
                        </div>

                        <!--div class="form-group">
                            <label for="parent_id" class="col-md-4 control-label">Select list:</label>
                            <div class="col-md-6">
                                <select class="form-control" id="parent_id" name="parent_id">
                                @foreach($product_parents as $key => $value)
                                    <option value="{{ $key }}">{{ $value}}</option>
                                @endforeach
                                </select>
                            </div>
                        </div-->

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
								<a href="{{ route('products.index') }}" class="btn btn-primary">Back</a>
                                <a href="{{ route('products.edit', [$product->id]) }}" class="btn btn-default">Edit</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@section('script')
<script>
    function hiddenIcon()
    {
        $('#image').hide();
        //$('#delete_image').hide();
        //$('#image_input').show();
    }

    function showIcon()
    {
        $('#image').show();
        //$('#delete_image').show();
        //$('#image_input').hide();
    }

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#image').attr('src', e.target.result);
				var filename = $("#image_input").val();
				filename = filename.toLowerCase();
				console.log(filename);
				if (filename.match(/(?:gif|jpg|png|bmp)$/)) {
					showIcon();
				}
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    @if($product && !$product->image)
		hiddenIcon();
    @else
        showIcon();
	@endif

    $("#image_input").change(function(){
        readURL(this);
    });

    $('#delete_image').click( function() {
        hiddenIcon();
        $("#image_input").val("");
    });
		
</script>
@endsection