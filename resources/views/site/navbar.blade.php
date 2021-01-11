<nav class="primary-menu sub-title">
	<ul class="menu-container">
		<li class="menu-item mega-menu sub-menu">
			<a class="menu-link" href="{{ route('home') }}">
				<div>Categories</div>
            </a>
            <div class="mega-menu-content mega-menu-style-2" style="width: 1291px;">
                <div class="container" style="">
                    <div class="row">
                        <ul class="sub-menu-container mega-menu-column col-lg-3" style="">

                            @foreach($categories as $category)
                            <li class="menu-item mega-menu-title sub-menu" style="">
                                <a class="menu-link" href="#"><div>{{ ucfirst($category->name) }}</div></a>
                                <ul class="sub-menu-container" style="">
                                    @php
                                        $products = $category->products;
                                        $brands = $products->whereNotNull('brand.name')->pluck('brand.name', 'brand.slug') ?? null;
                                    @endphp
                                    @foreach($brands as $brand_slug => $brand_name)
                                    <li class="menu-item" style="">
                                        <a class="menu-link" href="{{ route('public.product_list') }}?category={{ $category->slug }}&brand={{ $brand_slug }}">
                                            <div>{{ $brand_name }}</div>
                                        </a>
                                    </li>
                                    @endforeach
                                </ul>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <button class="sub-menu-trigger icon-chevron-right"></button>
		</li>
		<li class="menu-item">
			<a class="menu-link" href="{{ route('service') }}">
				<div>Pharma</div>
            </a>
            <ul class="sub-menu-container">
                <li class="menu-item" >
                    <a href="{{ route('public.pharma_purchase_order') }}" class="menu-link">
                        Create Order
                    </a>
                </li>

            </ul>
        </li>
        @if(auth()->guard('web')->check())
        <li class="menu-item sub-menu">
			<a class="menu-link" >
				<div>Portal</div>
            </a>
            <form id="logout-form" action="{{ route('public.logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
            <ul class="sub-menu-container">
                <li class="menu-item">
                    <a  class="menu-link" href="{{ route('public.dashboard') }}">Dashboard</a>
                </li>
                <li class="menu-item">
                    <a  class="menu-link" href="" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Logout</a>
                </li>
            </ul>
		</li>
        @endif
        @guest
            <li class="menu-item">
                <a class="menu-link" href="#">
                    <div>Login</div>
                </a>
                <ul class="sub-menu-container">
                    <li class="menu-item" >
                        <a  class="menu-link" data-toggle="modal" data-target=".show-login-modal">
                            Login
                        </a>
                    </li>
                    <li class="menu-item">
                        <a  class="menu-link" href="{{ route('public.registration') }}">Register</a>
                    </li>
                </ul>
            </li>
        @endguest
	</ul>
</nav>
