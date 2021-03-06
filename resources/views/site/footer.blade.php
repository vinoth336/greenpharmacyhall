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
                                @method('POST');
                                @if(session()->has('login_failed'))
                                    <p class="text-danger">
                                        {{ session()->get('login_failed') }}
                                    </p>
                                @endif
                                @if(session()->has('login_success'))
                                    <p class="text-success">
                                        {{ session()->get('login_success') }}
                                    </p>
                                @endif
                                <input type="hidden" name="redirectTo" value="{{ $redirectTo ?? 'dashboard' }}" />
								<div class="form-group">
									<label for="exampleInputEmail1">Phone No</label>
									<input type="number" class="form-control" name="phone_no" min="10" placeholder="Phone No">
                                    @if($errors->has('phone_no'))
                                        <span class="text-danger"> {{ $errors->first('phone_no') }} </span>
                                    @endif
								</div>
								<div class="form-group">
									<label for="exampleInputPassword1">Password</label>
									<input type="password" class="form-control" name="password" placeholder="Password"> <br>
                                    <a style="margin-left: 10px;" href="Javascript:void(0);" onclick="showForgotPasswordForm()">
                                        Forgot Password ?
                                    </a>
                                    @if($errors->has('password'))
                                        <span class="text-danger"> {{ $errors->first('password') }} </span>
                                    @endif
								</div>
								<div class="form-check">
									<input type="checkbox" class="form-check-input" id="remember" name="remember" value="1" checked>
									<label class="form-check-label" for="exampleCheck1">Remember Me</label>
                                </div>

                                <div class="m-auto text-center">
								<button type="submit" class="btn btn-warning text-white" style="background-color: #fb641b; padding-left: 10%; padding-right:10%">
                                    Login
                                </button>
                                </div>
                            </form>
                            <form method="post" action="{{ route('public.forgot_password') }}" id="show_forgot_password" class="d-none">
                                @csrf
                                <h2 style="margin-top: 55px">Forgot Password</h2>
                                <p style="line-height: 25px;color: #333">
                                    Don't Worry We Will Help You To Restore Password, Kindly Submit Your
                                    Password, Our Support Team will contact you to resolve it.
                                </p>
                                <div class="form-group">
									<label for="exampleInputEmail1">Phone No</label>
									<input type="number" class="form-control" name="forgot_password_phone_no" min="10" placeholder="Phone No">
                                    @if($errors->has('forgot_password_phone_no'))
                                        <span class="text-danger"> {{ $errors->first('forgot_password_phone_no') }} </span>
                                    @endif
								</div>
                                <div class="m-auto text-right">
                                    <a style="margin-left: 10px;" href="Javascript:void(0);" onclick="showLoginForm()">
                                       Cancel
                                    </a>
                                    <button type="submit" class="btn btn-warning text-white" style="background-color: #fb641b; padding-left: 10%; padding-right:10%">
                                        Submit
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
<input type="hidden" id="MIN_ORDER_AMOUNT" value="{{ MIN_ORDER_AMOUNT }}" />
<script src="{{ asset('web/js/plugins.min.js') }}?v={{ $version }}"></script>
<script src="{{ asset('web/js/functions.js') }}?v={{ $version }}"></script>
<script src="{{ asset('web/js/lozad.min.js') }}?v={{ $version }}"></script>
<script type="text/javascript" src="{{ asset('web/js/cart.js') }}?v={{ $version }}"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
    // cookie policy
    $(document).ready(function() {

      if (document.cookie.indexOf("accepted_cookies=") < 0) {
        $('.cookie-overlay').removeClass('d-none').addClass('d-block');
      }

      $('.accept-cookies').on('click', function() {
        document.cookie = "accepted_cookies=yes;"
        if(document.cookie.indexOf("accepted_cookies=") < 0) {
            alert("We can't Process your request, please change the cookies setting Browser Level");
        } else {
            $('.cookie-overlay').removeClass('d-block').addClass('d-none');
        }
      })

      // expand depending on your needs
      $('.close-cookies').on('click', function() {
        $('.cookie-overlay').removeClass('d-block').addClass('d-none');
      })
    })

    </script>

@stack('js')

<script>
$(document).ready(function() {
    var showLoginFormPopup = false;
    @if(session()->has('login_failed') || session()->has('login_success'))
    showLoginFormPopup = true;
    @endif
    @if($errors->has('phone_no') || $errors->has('password') )
    showLoginFormPopup = true;
    @endif
    @if($errors->has('forgot_password_phone_no'))
    showLoginFormPopup = true;
                showForgotPasswordForm();
    @endif
    @guest
            var nw = new Date();
            if((localStorage.showLoginForm == null || localStorage.showLoginForm <= nw.getTime())) {
                var dt = new Date();
                dt.setMinutes( dt.getMinutes() + 1 ); //Show login form for every 3 mins
                localStorage.showLoginForm = dt.getTime();
                if(!showLoginFormPopup) {
                    setTimeout(function() {
                            triggerLoginForm()
                    }, 2000);
                }
            }
    @endguest
    if(showLoginFormPopup) {
        triggerLoginForm()
    }
});

function triggerLoginForm()
{
    $(".user_login:first").trigger('click');
}

$(function() {
    $( "#product_search_box" ).autocomplete({
      source: function( request, response ) {
        $.ajax({
          url: "/search_product",
          dataType: "json",
          data: {
            q: request.term
          },
          success: function( data ) {
            response( data );
          }
        });
      },
      minLength: 3,
      select: function( event, ui ) {
        if(typeof ui.item.value != 'undefined') {
            window.location.href="/product/" + ui.item.value;
        } else {
          window.location.href="/search?q=" + ui.item.value;
        }
      },
      open: function() {
        $( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
      },
      close: function() {
        $( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
      }
    });
  });

  function showForgotPasswordForm()
  {
      $("#login_form").addClass('d-none');
      $("#show_forgot_password").removeClass('d-none');
  }

  function showLoginForm()
  {
      $("#login_form").removeClass('d-none');
      $("#show_forgot_password").addClass('d-none');
  }

</script>

<a href="https://wa.me/91{{ $siteInformation->phone_no }}?text=Hi {{ $siteInformation->site_name }}," class="ws_float"
    target="_blank">
    <i class="fa icon-whatsapp my-float"></i>
</a>

<div class="cookie-overlay p-4 d-none">
    <div class="d-flex">
      <div class="mr-3">
        Allow permission to Read and Write Cookies,<br>
        <i style="font-size: 10px; color: red">Please Note we d't read other site information</i>
      </div>
    </div>
    <button class="btn btn-primary mt-3 accept-cookies">Allow</button>
  </div>


</body>

</html>
