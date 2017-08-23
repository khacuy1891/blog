<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">WebSiteName</a>
    </div>
    <ul class="nav navbar-nav">
      <li class="{{ Request::is('products*')? 'active' : ''}}"><a href="{{ route('products.index') }}">Product</a></li>
	  <li class="{{ Request::is('product_marketings*')? 'active' : ''}}"><a href="{{ route('categories.index') }}">Product Marketing</a></li>
      <li class="{{ Request::is('categories*')? 'active' : ''}}"><a href="{{ route('categories.index') }}">Category</a></li>
      <li><a href="#">Page 2</a></li>
    </ul>
	<form class="navbar-form navbar-left" action="{{ route('categories.search') }}">
      <div class="input-group">
        <input type="text" class="form-control" placeholder="Search" name="key_search" value="{{isset($key_search)? $key_search : ''}}" >
        <div class="input-group-btn">
          <button class="btn btn-default" type="submit">
			<i class="glyphicon glyphicon-search"></i>
          </button>
        </div>
      </div>
    </form>
  </div>
</nav>