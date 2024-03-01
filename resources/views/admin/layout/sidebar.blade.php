<aside class="main-sidebar">
    <section class="sidebar">
		<div class="user-panel">
			<div class="pull-left image">
				<img src="{{asset('template/dist/img/user2-160x160.jpg')}}" class="img-circle" alt="User Image">
			</div>
			<div class="pull-left info">
				<p>Hi {{ auth()->guard('admin')->user()->name }}!</p>
				<a href="#"><i class="fa fa-circle text-success"></i> {{ __('messages.online') }}</a>
			</div>
		</div>
		<form action="#" method="get" class="sidebar-form">
			<div class="input-group">
				<input type="text" name="q" class="form-control" placeholder="Search...">
				<span class="input-group-btn">
					<button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
					</button>
				</span>
			</div>
		</form>
		<ul class="sidebar-menu" data-widget="tree">
			<li class="header">{{ __('messages.main_navigation') }}</li>
			<li class="">
				<a href="{{ route('admin.home') }}">
					<i class="fa fa-dashboard"></i> <span>{{ __('messages.dashboard') }}</span>
					<span class="pull-right-container">
						<i class="fa pull-right"></i>
					</span>
				</a>
			</li>
			<li class="">
				<a href="{{ route('category.index') }}">
					<i class="fa fa-files-o"></i>
					<span>{{ __('messages.category') }}</span>
					<span class="pull-right-container">
					</span>
				</a>
			</li>
			<li>
				<a href="{{ route('subcategory.index') }}">
					<i class="fa fa-th"></i> <span>{{ __('messages.sub_category') }}</span>
					<span class="pull-right-container">
					</span>
				</a>
			</li>
			<li class="">
				<a href="{{ route('product.index') }}">
					<i class="fa fa-pie-chart"></i>
					<span>{{ __('messages.product') }}</span>
				</a>
			</li>
			<li><a href="{{ url('/admin/logout') }}"><i class="fa text-aqua"></i> <span>{{ __('messages.logout') }}</span></a></li>
		</ul>
	</section>
</aside>