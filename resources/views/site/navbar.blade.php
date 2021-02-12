<nav class="primary-menu sub-title">
	<ul class="menu-container">
		<li class="menu-item mega-menu sub-menu">
			<a class="menu-link" href="{{ route('home') }}">
				<div>Categories</div>
            </a>
            <div class="mega-menu-content mega-menu-style-2" style="width: 1291px;">
                <div class="container" style="">
                    <div class="row">
                            @foreach($categories as $category)
                            @if($category->products->count() ?? null)
                                <ul class="sub-menu-container mega-menu-column col-lg-3" style="">
                                        <li class="menu-item mega-menu-title sub-menu" style="">
                                            <a class="menu-link" href="{{ route('public.product_list') }}?categories[]={{ $category->slug }}">
                                                <div>{{ ucfirst($category->name) }}</div>
                                            </a>
                                            <ul class="sub-menu-container" style="">
                                                @php
                                                    $products = $category->products;
                                                    $subCategories = $products->whereNotNull('sub_category.name')->pluck('sub_category.name', 'sub_category.slug_name') ?? null;
                                                @endphp
                                                @foreach($subCategories as $subCategorySlugName => $subCategoryName)
                                                <li class="menu-item" style="">
                                                    <a class="menu-link" href="{{ route('public.product_list') }}?category={{ $category->slug }}&sub_categories[]={{ $subCategorySlugName }}">
                                                        <div>{{ $subCategoryName }}</div>
                                                    </a>
                                                </li>
                                                @endforeach
                                            </ul>
                                        </li>
                                </ul>
                            @endif
                            @endforeach
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
				<div>
                    <i class="icon-user-alt"></i>
                    @if(strlen(auth()->user()->name) <= 15 )
                        {{  auth()->user()->name }}
                    @else
                        {{  substr(auth()->user()->name, 0, 15) }}..
                    @endif
                </div>
            </a>
            <form id="logout-form" action="{{ route('public.logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
            <ul class="sub-menu-container">
                <li class="menu-item">
                    <a  class="menu-link" href="{{ route('public.dashboard') }}">Dashboard</a>
                </li>
                <li class="menu-item">
                    <a  class="menu-link" href="{{ route('public.change_password') }}">Change Password</a>
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
                        <a class="menu-link user_login" data-toggle="modal" data-target=".show-login-modal">
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
