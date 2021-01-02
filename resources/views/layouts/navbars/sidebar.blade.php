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

  <div class="sidebar-wrapper">
    <ul class="nav">
      <li class="nav-item{{ $activePage == 'dashboard' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('admin.dashboard') }}">
          <i class="material-icons">dashboard</i>
            <p>{{ __('Dashboard') }}</p>
        </a>
      </li>
      <li class="nav-item{{ $activePage == 'site_information' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('site_information.index') }}">
          <i class="material-icons">content_paste</i>
            <p>{{ __('Site Information') }}</p>
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
      <li class="nav-item{{ $activePage == 'category_types' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('category_types.index') }}">
          <i class="material-icons">content_paste</i>
            <p>{{ __('Category Types') }}</p>
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
      <li class="nav-item{{ $activePage == 'portfolio' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('portfolio.index') }}">
          <i class="material-icons">content_paste</i>
            <p>{{ __('Product') }}</p>
        </a>
      </li>
      <li class="nav-item{{ $activePage == 'testimonials' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('testimonials.index') }}">
          <i class="material-icons">content_paste</i>
            <p>{{ __('Testimonial') }}</p>
        </a>
      </li>
      <li class="nav-item{{ $activePage == 'pharma_orders' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('pharma_orders.index') }}">
          <i class="material-icons">content_paste</i>
            <p>{{ __('Pharma - View Orders') }}</p>
        </a>
      </li>
      <li class="nav-item{{ $activePage == 'enquiries' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('enquiries.index') }}">
          <i class="material-icons">content_paste</i>
            <p>{{ __('Enquiries') }}</p>
        </a>
      </li>
      <li class="nav-item{{ $activePage == 'faqs' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('faqs.index') }}">
          <i class="material-icons">content_paste</i>
            <p>{{ __('Faq\'s') }}</p>
        </a>
      </li>
    </ul>
  </div>
</div>
