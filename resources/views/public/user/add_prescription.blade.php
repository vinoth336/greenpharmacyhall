@extends('site.app')

@section('content')

<section id="page-title">
<div class="container clearfix">
<h1>Easy To Purchase</h1>
<span>Less Than 2 mins will purchase your order</span>
</div>
</section>

<section id="content">
<div class="content-wrap">
<div class="container clearfix">
    <div class="row gutter-40 col-mb-80">
        <div class="postcontent col-lg-9">
            <div class="faqs">
                <form method="post" action="{{ route('public.pharma_purchase_order') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-md-8">
                            <label for="inputAddress2">Upload Prescription</label>
                            <input type="file" class="form-control" placeholder="Prescription" name="prescription"  accept="image/x-png,image/jpg,image/jpeg">
                            <span id="first_nameMsg" class="error">
                                @error('prescription')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-8">
                            <label for="inputAddress2">Comment</label>
                            <textarea class="form-control" name="comment_text" maxlength="500" >{{ old('comment_text') }}</textarea>
                            <span id="first_nameMsg" class="error">
                                @error('comment_text')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary float-right">Upload</button>
                </form>
            </div>
        </div>
        <div class="col-lg-3">
            @include('public.user.sidebar')
        </div>
    </div>
</div>
</div>
</section>


@endsection
