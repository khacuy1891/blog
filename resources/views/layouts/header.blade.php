<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">WebSiteName</a>
    </div>
    <ul class="nav navbar-nav">
      <li class="active"><a href="{!! route('categories.index') !!}">Home</a></li>
      <li><a href="{{ route('categories.create') }}">Add Category</a></li>
      <li><a href="#">Page 2</a></li>
    </ul>
    <form class="navbar-form navbar-left" action="route('categories.search')">
      <div class="form-group">
        <input type="text" class="form-control" placeholder="Search" name="key_search" value="{{isset($key_search)? $key_search : ''}}" >
      </div>
      <button type="submit" class="btn btn-default">Submit</button>
    </form>
  </div>
</nav>

<script>
/*
 $('ul.nav > li').click(function (e) {
    e.preventDefault();
    $('ul.nav > li').removeClass('active');
    $(this).addClass('active');
});*/ 
</script>