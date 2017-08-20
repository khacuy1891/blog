@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Edit Category</div>
                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ route('categories.store') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Name *</label>

                            <div class="col-md-6">
                                <input id="name" type="name" class="form-control" name="name"  value="{{$category->name}}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('icon') ? ' has-error' : '' }}">
                            <label for="icon" class="col-md-4 control-label">Icon *</label>
                            <div class="col-md-6">
                                <input id="file_select" name="icon" type="file" style="">
                                <img src="{{asset(config('path.icon').'/'.$category->icon)}}" id="image" name='icon' alt="HTML5 Icon" width="128" height="128">
                                <a id="delete_icon" href='#'>Delete</a>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="indexing" class="col-md-4 control-label">Indexing</label>
                            <div class="col-md-6">
                                <input id="indexing" type="number" class="form-control" name="indexing"  value="{{$category->indexing}}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="description" class="col-md-4 control-label">Description</label>
                            <div class="col-md-6">
                                <input id="description" type="text" class="form-control" name="description"  value="{{$category->description}}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="parent_id" class="col-md-4 control-label">Select list:</label>
                            <div class="col-md-6">
                                <select class="form-control" id="parent_id" name="parent_id">
                                @foreach($category_parents as $key => $value)
                                    <option value="{{ $key }}">{{ $value}}</option>
                                @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">Save</button>
                                <button type="reset" class="btn btn-default">Cancel</button>
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
        $('#delete_icon').hide();
        $('#file_select').show();
    }

    function showIcon()
    {
        $('#image').show();
        $('#delete_icon').show();
        $('#file_select').hide();
    }

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#image').attr('src', e.target.result);
                showIcon();
                console.log('showIcon');
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    @if($category && !$category->icon)
		hiddenIcon();
    @else
        showIcon();
	@endif

    $("#file_select").change(function(){
        readURL(this);
    });

    $('#delete_icon').click( function() {
        hiddenIcon();
        $("#file_select").val("");
    });
</script>
@endsection