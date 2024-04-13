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
								<div class="form-group" id= "otp-block" style="display:none">
									<label for="exampleInputPassword1">One Time Password (OTP)</label>
									<input type="text" class="form-control" name="otp" placeholder="OTP" /> <br>

                                    @if($errors->has('password'))
                                        <span class="text-danger"> {{ $errors->first('password') }} </span>
                                    @endif
								</div>
                                <!-- Regenerate OTP -->

                                <a  id="regenerate_otp" class="btn-link " style="color: #fb641b;cursor:pointer">
                                    Regenerate OTP
</a>

                                <div class="m-auto text-center">
								<button type="button" id="request_otp" class="btn btn-warning text-white" style="color: #fb641b; padding-left: 10%; padding-right:10%">
                                    Request OTP
                                </button>
                                <button type="button" id="verify_otp" class="btn btn-warning text-white" style="display:none;background-color: #fb641b; padding-left: 10%; padding-right:10%">
                                    Verify OTP
                                </button>
                                </div>
                                <div class="m-auto text-center" id="error_block_div" style="display:none">
                                    <span id="error_msg" style="color:black"></span>
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
<footer id="footer" class="dark text-white" >
    <div id="copyrights" style="background: url('{{ asset('site_images/footer-bg.jpg') }}') repeat; background-size: cover;">
        <div class="container">
            <div class="row col-mb-30">
                <div class="col-md-4 text-center text-md-left">
                    Copyrights &copy; {{ date('Y') }} {{ $siteInformation->site_name }}.<br>
                    All rights reserved. In compliance with Drugs and Cosmetics Act, 1940 and Drugs and Cosmetics Rules, 1945, we don't process requests for Schedule X and other habit forming drugs.
                </div>
                <div class="col-md-4 text-md-right">
                    <div class="justify-content-center">

                        <ul class="list-unstyled">
                            <li class="">
                                <a href="{{ route("site.terms_and_conditions") }}"
                                   class="text-white" target="_blank">
                                    Terms & Conditions
                                </a>
                            </li>
                            <li>
                                <a href="{{ route("site.privacy_policy") }}"
                                   class="text-white" target="_blank">
                                    Privacy Policy
                                </a>
                            </li>
                            <li>
                                <a href="{{ route("site.shipping_policy") }}"
                                   class="text-white" target="_blank">
                                    Shipping Policy
                                </a>
                            </li>
                            <li>
                                <a href="{{ route("site.return_policy") }}"
                                   class="text-white">
                                    Return Policy
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-4 text-center text-md-right">
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
    $(document).ready(function() {
        $('#request_otp').click(function() {
            // Gather form data
            var formData = $('#login_form').serialize();
            // Send AJAX request
            $.ajax({
                url: "{{ route('public.login') }}",
                method: "POST",
                data: formData,
                success: function(response) {
                    // Handle success response
                    $('#login_form').find('#verify_otp,#otp-block').css({'display':'block'});
                    $('#login_form').find('#request_otp').css({'display':'none'});
                    $('#error_block_div').css({'display':'none'});
                },
                error: function(xhr, status, error) {
                    // Handle error response
                    $('#error_block_div').css({'display':'block'});
                    $('#error_msg').html(xhr.responseText['error']);
                }
            });
        });
        $('#verify_otp').click(function(){
            var formData = $('#login_form').serialize();
            // Send AJAX request
            $.ajax({
                url: "/verify_otp",
                method: "POST",
                data: formData,
                success: function(response) {
                    console.log(response);
                    // Handle success response

                        window.location.href=response.route;

                    //$('#verify_otp','.otp-block').css({'display':'block'});
                },
                error: function(xhr, status, error) {
                    // Handle error response
                    console.error(xhr);
                    $('#error_block_div').css({'display':'block'});
                    $('#error_msg').html(xhr.responseJSON['error']);
                }
            });
        });
        $('#regenerate_otp').click(function(){
            try {
                  // Gather form data
            var formData = $('#login_form').serialize();
            // Send AJAX request
            $.ajax({
                url: "/regenerate_otp",
                method: "POST",
                data: formData,
                success: function(response) {
                    // Handle success response
                    $('#login_form').find('#verify_otp,#otp-block').css({'display':'block'});
                    $('#login_form').find('#request_otp').css({'display':'none'});
                    $('#error_block_div').css({'display':'none'});
                },
                error: function(xhr, status, error) {
                    // Handle error response
                    $('#error_block_div').css({'display':'block'});
                    $('#error_msg').html(xhr.responseText['error']);
                }
            });
            } catch (error) {
                console.log(error);
            }
        });
    });
    // cookie policy
    $(document).ready(function() {

      if (document.cookie.indexOf("accepted_cookies=") < 0) {
        //$('.cookie-overlay').removeClass('d-none').addClass('d-block');
      }

      $('.accept-cookies').on('click', function() {
        document.cookie = "accepted_cookies=yes;"
        if(document.cookie.indexOf("accepted_cookies=") < 0) {
            alert("We can't Process your request, please change the cookies setting Browser Level");
        } else {
            //$('.cookie-overlay').removeClass('d-block').addClass('d-none');
        }
      })

      // expand depending on your needs
      $('.close-cookies').on('click', function() {
        //$('.cookie-overlay').removeClass('d-block').addClass('d-none');
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
