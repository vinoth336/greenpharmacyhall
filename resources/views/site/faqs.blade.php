@extends('site.app')

@section('content')

<section id="page-title">
<div class="container clearfix">
<h1>FAQs</h1>
<span>All your Questions answered in one place</span>
</div>
</section>

<section id="content">
<div class="content-wrap">
<div class="container clearfix">
    <div class="row gutter-40 col-mb-80">

        <div class="postcontent col-lg-8">
            <div class="clear"></div>
            <div id="faqs" class="faqs">

                @foreach($faqs as $faq)
                <div class="toggle faq faq-marketplace faq-authors">
                    <div class="toggle-header">
                        <div class="toggle-icon">
                            <i class="toggle-closed icon-question-sign"></i>
                            <i class="toggle-open icon-question-sign"></i>
                        </div>
                        <div class="toggle-title">
                           {{ $faq->question }}
                        </div>
                    </div>
                    <div class="toggle-content">{{ $faq->answer }}</div>
                </div>
                @endforeach
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
