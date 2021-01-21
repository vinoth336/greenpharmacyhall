<div class="modal fade show-login-modal" tabindex="-1" role="dialog" aria-labelledby="LoginFormModal"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-body" style="padding: 0 0.9rem">
            <div class="modal-content">
                <div class="modal-body" style="padding: 0 0.9rem">
                    <div class="row" style="background: #2874f0">
                        <div class="col-sm-5 d-none d-md-block text-white "  style="vertical-align: middle;padding: 4rem">
                            <p class="text-white mt-5" style="font-size: 28px; font-weight: 500">Login</p>
                            <p style="color:#dbdbdb; line-height: 32px">
                                Get access your Orders,<Br>
                                wishlist and recommendations
                            </p>
                        </div>
                        <div class="col-sm-7 text-white "  style="background-color:#fff">
                            <button type="button" class="close mt-2" data-dismiss="modal"
                        aria-hidden="true">&times;</button>
                            <form id="login_form" class="mt-5 floating-group" method="post" action="{{ route('public.login') }}">
                                @csrf
                                <input type="hidden" name="redirectTo" value="{{ $redirectTo ?? 'dashboard' }}" />
								<div class="form-group">
									<label for="exampleInputEmail1">Phone No</label>
									<input type="number" class="form-control" name="phone_no" min="10" placeholder="Phone No">
								</div>
								<div class="form-group">
									<label for="exampleInputPassword1">Password</label>
									<input type="password" class="form-control" name="password" placeholder="Password">
								</div>
								<div class="form-check">
									<input type="checkbox" class="form-check-input" id="exampleCheck1">
									<label class="form-check-label" for="exampleCheck1">Check me out</label>
                                </div>

                                <div class="m-auto text-center">
								<button type="submit" class="btn btn-warning text-white" style="background-color: #fb641b; padding-left: 10%; padding-right:10%">
                                    Login
                                </button>
                                </div>
                            </form>

                            <div class="mt-5 text-center mb-5">
                                <a href="{{ route('public.registration') }}">
                                    New User ? Create an account
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<footer id="footer" class="dark">
    <div id="copyrights">
        <div class="container">
            <div class="row col-mb-30">
                <div class="col-md-6 text-center text-md-left">
                    Copyrights &copy; {{ date('Y') }} All Rights Reserved by {{ $siteInformation->site_name }}.<br>
                </div>
                <div class="col-md-6 text-center text-md-right">
                    <div class="d-flex justify-content-center justify-content-md-end">
                        <a href="https://www.facebook.com/{{ $siteInformation->facebook_id }}"
                            class="social-icon si-small si-borderless si-facebook" target="_blank">
                            <i class="icon-facebook"></i>
                            <i class="icon-facebook"></i>
                        </a>
                        <a href="https://www.instagram.com/{{ $siteInformation->instagram_id }}/"
                            class="social-icon si-small si-borderless si-instagram" target="_blank">
                            <i class="icon-instagram"></i>
                            <i class="icon-instagram"></i>
                        </a>
                        <a href="tel:{{ $siteInformation->phone_no }}"
                            class="social-icon si-small si-borderless si-whatsapp">
                            <i class="icon-phone3"></i>
                            <i class="icon-phone3"></i>
                        </a>

                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
</div>

<div id="gotoTop" class="icon-angle-up"></div>

<script src="{{ asset('web/js/plugins.min.js') }}"></script>
<script src="{{ asset('web/js/functions.js') }}"></script>
<script type="text/javascript" src="{{ asset('web/js/cart.js') }}?v=1"></script>
@stack('js')

<a href="https://wa.me/91{{ $siteInformation->phone_no }}?text=Hi {{ $siteInformation->site_name }}," class="float"
    target="_blank">
    <i class="fa icon-whatsapp my-float"></i>
</a>

</body>

</html>
