@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Edit Product</div>
                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ route('admin.products.update', ['id' => $product->id]) }}" enctype="multipart/form-data">
					<input name="_method" type="hidden" value="PATCH">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Name *</label>

                            <div class="col-md-6">
                                <input id="name" type="name" class="form-control" name="name"  value="{{$product->name}}">

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
								<select class="form-control" id="category_id" name="category_id">
								@foreach($categories as $key => $value)
									<option value="{{ $key }}" {{ ($key == $product->category_id) ? "selected" : ""}}>{{ $value}}</option>
								@endforeach
								</select>
							</div>
						</div>
						
                        <div class="form-group{{ $errors->has('icon') ? ' has-error' : '' }}">
                            <label for="icon" class="col-md-4 control-label">Icon *</label>
                            <div class="col-md-6">
                                <input id="icon_input" name="icon" type="file" accept=".gif,.jpg,.png,.bmp,.GIF,.JPG,.PNG,.BMP">
                                <img src="{{asset(config('path.image').'/'.$product->image)}}" id="image" name='icon' width="128" height="128">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="indexing" class="col-md-4 control-label">Indexing</label>
                            <div class="col-md-6">
                                <input id="indexing" type="number" class="form-control" name="indexing"  value="{{$product->indexing}}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="description" class="col-md-4 control-label">Description</label>
                            <div class="col-md-6">
                                <input id="description" type="text" class="form-control" name="description"  value="{{$product->description}}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="parent_id" class="col-md-4 control-label">Select list:</label>
                            <div class="col-md-6">
                                <select class="form-control" id="parent_id" name="parent_id">
                                @foreach($product_parents as $key => $value)
                                    <option value="{{ $key }}" {{ ($key == $product->parent_id) ? "selected" : ""}}>{{ $value}}</option>
                                @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">Save</button>
                                <a type="reset" class="btn btn-default" id='btn_cancel'>Cancel</a>
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
        //$('#delete_icon').hide();
        //$('#icon_input').show();
    }

    function showIcon()
    {
        $('#image').show();
        //$('#delete_icon').show();
        //$('#icon_input').hide();
    }

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#image').attr('src', e.target.result);
                showIcon();
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    @if($product && !$product->image)
		hiddenIcon();
    @else
        showIcon();
	@endif

    $("#icon_input").change(function(){
        readURL(this);
    });

    $('#delete_icon').click( function() {
        hiddenIcon();
        $("#icon_input").val("");
    });
	
	$("#btn_cancel").click(function(){
        window.history.back();
    });
	
</script>
@endsection