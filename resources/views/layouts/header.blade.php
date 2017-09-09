<nav class="navbar navbar-inverse navbar-static-top">
	<div class="container">
		<div class="navbar-header">
			<!-- Collapsed Hamburger -->
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
				<span class="sr-only">Toggle Navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>

			<!-- Branding Image -->
			<a class="navbar-brand" href="{{ route('home') }}">Home</a>
		</div>

		<div class="collapse navbar-collapse" id="app-navbar-collapse">
			<!-- Left Side Of Navbar -->
			<ul class="nav navbar-nav">
				<li class="{{ Request::is('*admin/categories*')? 'active' : ''}}"><a href="{{ route('admin.categories.index') }}">Category</a></li>
				<li class="{{ Request::is('*admin/products*')? 'active' : ''}}"><a href="{{ route('admin.products.index') }}">Product</a></li>
				<li class="{{ Request::is('*product_marketings*')? 'active' : ''}}"><a href="{{ route('admin.categories.index') }}">Product Marketing</a></li>
			</ul>
			<form class="navbar-form navbar-left" action="">
				<div class="input-group">
					<input type="text" class="form-control" placeholder="Search" name="key_search" value="{{isset($key_search)? $key_search : ''}}" >
					<div class="input-group-btn">
						<button class="btn btn-default" type="submit">
						<i class="glyphicon glyphicon-search"></i>
					  </button>
					</div>
				 </div>
			</form>
			<!-- Right Side Of Navbar -->
			@if(Session::get('admin'))
				<form class="navbar navbar-form navbar-right" method="POST" action="{{ route('admin.logout') }}" id="logout-form"
					style="margin-top:0px; margin-bottom:0px; padding-top:0px; padding-bottom:0px">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<ul class="nav navbar-nav navbar-right" style="margin-top: 0; margin-bottom: 0;">
						<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Welcome, {{Auth::user()}} <b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li><a href="#"><i class="icon-cog"></i> Preferences</a></li>
								<li><a href="#"><i class="icon-envelope"></i> Contact Support</a></li>
								<li class="divider"></li>
								<li><a href="#" onclick="$('#logout-form').submit()"><i class="icon-off"></i>Logout</a></li>
							</ul>
						</li>
					</ul>
				</form>
			@else
				<ul class="nav navbar-nav navbar-right">
					<!-- Authentication Links -->
					f<li><a href="{{ route('admin.login') }}">Login</a></li>
					<li><a href="{{ route('admin.register') }}">Register</a></li>
				</ul>
			@endif
		</div>
	</div>
</nav>