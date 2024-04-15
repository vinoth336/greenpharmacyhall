@extends('site.app')

@section('content')

<section id="page-title">
<div class="container clearfix">
<h1>Contact Us</h1>
</div>
</section>

<section id="content">
<div class="content-wrap">
<div class="container clearfix">
    <div class="row gutter-40 col-mb-80">

        <div class="postcontent col-lg-8">
            <div class="clear"></div>
            <div id="faqs" class="faqs">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3916.812591921441!2d78.07481307432813!3d10.977513989183745!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3baa2f7275c7b6e9%3A0xdd158d7873244cb!2sGreen%20Pharmacy%20Hall!5e0!3m2!1sen!2sin!4v1713196667757!5m2!1sen!2sin" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>

            </div>
        </div>

        <div class="sidebar col-lg-4">
            <div class="sidebar-widgets-wrap">
                <div class="container clearfix">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="fancy-title title-border">
                                <h4>Send us an Email</h4>
                            </div>
                            <!-- Enquiry Form Start Here -->

                            <?php $enquiry_form_class = 'col-md-12'; ?>
                            @include('site.enquiry_form', ['enquiry_form_class' => $enquiry_form_class] )

                            <!-- Enquiry Form Ended Here -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</section>


@endsection
