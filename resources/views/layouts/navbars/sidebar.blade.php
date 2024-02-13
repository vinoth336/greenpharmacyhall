<div class="sidebar" data-color="orange" data-background-color="black" data-image="{{ asset('material') }}/img/banner13.jpg">
  <!--
      Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

      Tip 2: you can also add an image using data-image tag
  -->
  <div class="logo">
    <a target="_blank" href="{{ config('app.url') }}" class="simple-text logo-normal">
      {{ config('app.name') }}<br>
    </a>
  </div>

  @php
    $siteControllerPages = array('site_information', 'slider', 'banner', 'faqs', 'testimonials');
    $masterPages = array('category_types', 'sub_categories', 'services', 'brands', 'product','pincode');
    $orderPages = array('pharma_orders', 'user_orders');

  @endphp

  <div class="sidebar-wrapper">
    <ul class="nav">
      <li class="nav-item{{ $activePage == 'dashboard' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('admin.dashboard') }}">
          <i class="material-icons">dashboard</i>
            <p>{{ __('Dashboard') }}</p>
        </a>
      </li>
      <li class="nav-item @if(in_array($activePage, $siteControllerPages)) active @endif"  >
        <a class="nav-link" href="#siteController" data-toggle="collapse" aria-expanded="@if(in_array($activePage, $siteControllerPages)) true @endif">
          <i class="material-icons">content_paste</i>
            <p>{{ __('Site Controller') }}</p>
        </a>
        <div class="collapse @if(in_array($activePage, $siteControllerPages)) show @endif" id="siteController">
            <ul class="nav">
                <li class="nav-item{{ $activePage == 'site_information' ? ' active' : '' }}">
                    <a class="nav-link" href="{{ route('site_information.index') }}">
                      <i class="material-icons">content_paste</i>
                        <p>{{ __('Site Information') }}</p>
                    </a>
                </li>
                <li class="nav-item{{ $activePage == 'cart_settings' ? ' active' : '' }}">
                    <a class="nav-link" href="{{ route('cart_settings.index') }}">
                      <i class="material-icons">content_paste</i>
                        <p>{{ __('Cart Settings') }}</p>
                    </a>
                </li>
                <li class="nav-item{{ $activePage == 'notification_manager' ? ' active' : '' }}">
                    <a class="nav-link" href="{{ route('notification_manager.index') }}">
                      <i class="material-icons">content_paste</i>
                        <p>{{ __('Notification Manager') }}</p>
                    </a>
                </li>
                <li class="nav-item{{ $activePage == 'slider' ? ' active' : '' }}">
                    <a class="nav-link" href="{{ route('slider.index') }}">
                    <i class="material-icons">content_paste</i>
                        <p>{{ __('Slider') }}</p>
                    </a>
                </li>
                <li class="nav-item{{ $activePage == 'banner' ? ' active' : '' }}">
                    <a class="nav-link" href="{{ route('banner.index') }}">
                    <i class="material-icons">content_paste</i>
                        <p>{{ __('Banners') }}</p>
                    </a>
                </li>
                <li class="nav-item{{ $activePage == 'faqs' ? ' active' : '' }}">
                    <a class="nav-link" href="{{ route('faqs.index') }}">
                      <i class="material-icons">content_paste</i>
                        <p>{{ __('Faq\'s') }}</p>
                    </a>
                </li>
                <li class="nav-item{{ $activePage == 'testimonials' ? ' active' : '' }}">
                    <a class="nav-link" href="{{ route('testimonials.index') }}">
                      <i class="material-icons">content_paste</i>
                        <p>{{ __('Testimonial') }}</p>
                    </a>
                  </li>
            </ul>
        </div>
      </li>
      <li class="nav-item{{ $activePage == 'users' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('users.index') }}">
          <i class="material-icons">dashboard</i>
            <p>{{ __('Users') }}</p>
        </a>
      </li>

      <li class="nav-item @if(in_array($activePage, $masterPages)) active @endif"  >
        <a class="nav-link" href="#siteMaster" data-toggle="collapse" aria-expanded="@if(in_array($activePage, $masterPages)) true @endif">
          <i class="material-icons">content_paste</i>
            <p>{{ __('Masters') }}</p>
        </a>
        <div class="collapse @if(in_array($activePage, $masterPages)) show @endif" id="siteMaster">
            <ul class="nav">
                <li class="nav-item{{ $activePage == 'category_types' ? ' active' : '' }}">
                    <a class="nav-link" href="{{ route('category_types.index') }}">
                    <i class="material-icons">content_paste</i>
                        <p>{{ __('Category Types') }}</p>
                    </a>
                </li>
                <li class="nav-item{{ $activePage == 'sub_categories' ? ' active' : '' }}">
                    <a class="nav-link" href="{{ route('sub_categories.index') }}">
                    <i class="material-icons">content_paste</i>
                        <p>{{ __('Sub Categories Types') }}</p>
                    </a>
                    
                </li>
                <li class="nav-item{{ $activePage == 'services' ? ' active' : '' }}">
                    <a class="nav-link" href="{{ route('services.index') }}">
                    <i class="material-icons">content_paste</i>
                        <p>{{ __('Category') }}</p>
                    </a>
                </li>
                <li class="nav-item{{ $activePage == 'brands' ? ' active' : '' }}">
                    <a class="nav-link" href="{{ route('brands.index') }}">
                    <i class="material-icons">content_paste</i>
                        <p>{{ __('Brands') }}</p>
                    </a>
                </li>
                <li class="nav-item{{ $activePage == 'product' ? ' active' : '' }}">
                    <a class="nav-link" href="{{ route('product.index') }}">
                    <i class="material-icons">content_paste</i>
                        <p>{{ __('Product') }}</p>
                    </a>
                </li>
                <li class="nav-item{{ $activePage == 'pincode' ? ' active' : '' }}">
                    <a class="nav-link" href="{{ route('pincode.index') }}">
                    <i class="material-icons">content_paste</i>
                        <p>{{ __('PinCode') }}</p>
                    </a>
                </li>
            </ul>
        </div>
      </li>
      <li class="nav-item @if(in_array($activePage, $orderPages)) active @endif"  >
        <a class="nav-link" href="#siteOrders" data-toggle="collapse" aria-expanded="@if(in_array($activePage, $orderPages)) true @endif">
          <i class="material-icons">content_paste</i>
            <p>{{ __('Orders') }}</p>
        </a>
        <div class="collapse @if(in_array($activePage, $orderPages)) show @endif" id="siteOrders">
            <ul class="nav">
                <li class="nav-item{{ $activePage == 'pharma_orders' ? ' active' : '' }}">
                    <a class="nav-link" href="{{ route('pharma_orders.index') }}">
                    <i class="material-icons">content_paste</i>
                        <p>{{ __('Pharma') }}</p>
                    </a>
                </li>
                <li class="nav-item{{ $activePage == 'user_orders' ? ' active' : '' }}">
                    <a class="nav-link" href="{{ route('user_orders.index') }}">
                    <i class="material-icons">content_paste</i>
                        <p>{{ __('Non Pharma') }}</p>
                    </a>
                </li>
            </ul>
        </div>
      </li>
      <li class="nav-item{{ $activePage == 'forgot_password' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('change_password_request.index') }}">
          <i class="material-icons">content_paste</i>
            <p>{{ __('Change Password Request') }}</p>
        </a>
      </li>
      <li class="nav-item{{ $activePage == 'enquiries' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('enquiries.index') }}">
          <i class="material-icons">content_paste</i>
            <p>{{ __('Enquiries') }}</p>
        </a>
      </li>
    </ul>
  </div>
</div>
