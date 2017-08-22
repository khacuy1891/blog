@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Category</div>
                <div class="panel-body">
                    <div class="form-horizontal">
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Name *</label>

                            <div class="col-md-6">
                                <input id="name" type="name" class="form-control" name="name" disabled="disabled" value="{{$category->name}}" required autofocus>

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
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="indexing" class="col-md-4 control-label">Indexing</label>
                            <div class="col-md-6">
                                <input id="indexing" type="number" class="form-control" name="indexing" disabled="disabled" value="{{$category->indexing}}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="description" class="col-md-4 control-label">Description</label>
                            <div class="col-md-6">
                                <input id="description" type="text" class="form-control" name="description" disabled="disabled" value="{{$category->description}}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="parent_id" class="col-md-4 control-label">Select list:</label>
                            <div class="col-md-6">
                                <select class="form-control" id="parent_id" name="parent_id" disabled="disabled">
                                @foreach($category_parents as $key => $value)
                                    <option value="{{ $key }}" {{ ($key == $category->parent_id) ? "selected" : ""}}>{{ $value}}</option>
                                @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <a href="{{ route('categories.index') }}" class="btn btn-primary">Back</a>
                                <a href="{{ route('categories.edit', [$category->id]) }}" class="btn btn-default">Edit</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
	
	<div class="fb-comments" data-href="{{Request::url()}}" data-numposts="10"></div>
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

    @if($category && !$category->icon)
		hiddenIcon();
    @else
        showIcon();
	@endif

    $('#delete_icon').click( function() {
        hiddenIcon();
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
</script>
@endsection