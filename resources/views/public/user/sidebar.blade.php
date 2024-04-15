<div class="list-group">
    <a href="{{ route('public.dashboard') }}" class="list-group-item list-group-item-action d-flex justify-content-between">
        <div>Profile</div><i class="icon-user"></i>
    </a>
    <a href="{{ route('public.order_list') }}" class="list-group-item list-group-item-action d-flex justify-content-between">
        <div>My Orders</div><i class="icon-laptop2"></i>
    </a>
    <a href="{{ url('') }}/search?sub_categories%5B%5D=pharma" class="list-group-item list-group-item-action d-flex justify-content-between">
        <div>Buy A Medicine</div><i class="icon-cart"></i>
    </a>
    <a href="{{ route('site.contact_us') }}" class="list-group-item list-group-item-action d-flex justify-content-between">
        <div>Contact Us</div><i class="icon-envelope"></i>
    </a>
    <a href="#" onclick="event.preventDefault();document.getElementById('logout-form').submit();" class="list-group-item list-group-item-action d-flex justify-content-between">
        <div>Logout</div><i class="icon-line2-logout"></i>
    </a>
</div>
