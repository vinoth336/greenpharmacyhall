<div class="sidebar col-lg-3 d-none d-sm-block">
    <div class="row">

        <div class="col-lg-12">
            <h6>Select Category</h6>
            <select class="selectpicker input_filter" name="categories[]"  id="categories" multiple>
                <option value="">All</option>
                    @foreach ($categories as $category )
                        <option value="{{ $category->slug }}"
                            @if(in_array($category->slug, ($input['categories'] ?? [])))
                                selected
                            @endif
                        > {{ $category->name }}</option>
                    @endforeach
            </select>
        </div>
        <div class="col-lg-12">
            <h6>Sub Category</h6>
            <select class="selectpicker input_filter" name="sub_categories[]" id="sub_categories" multiple>
                <option value="">All</option>
                    @foreach ($subCategories as $subCategory )
                        <option value="{{ $subCategory->slug_name }}"
                            @if(in_array($subCategory->slug_name, ($input['sub_categories'] ?? [])))
                                selected
                            @endif
                        > {{ $subCategory->name }}</option>
                    @endforeach
            </select>
        </div>
        <div class="col-lg-12">
            <h6>Select Brand</h6>
            <select class="selectpicker input_filter" name="brands[]" id="brands" multiple>
                <option value="">All</option>
                    @foreach ($brands as $brand )
                        <option value="{{ $brand->slug }}"
                            @if(in_array($brand->slug, ($input['brands'] ?? [])))
                                selected
                            @endif
                        > {{ $brand->name }}</option>
                    @endforeach
            </select>
        </div>
        <div class="col-lg-12 mb-3">
            <h6>Sort By</h6>
            <select class="selectpicker input_filter" name="sort_by" id="sort_by">
                <option value="low_to_high" @if(request()->input('sort_by') == 'low_to_high') selected @endif>Low To High</option>
                <option value="high_to_low" @if(request()->input('sort_by') == 'high_to_low') selected @endif>High To Low</option>
            </select>

            <div class="col-lg-12 " style="text-align: right; margin-bottom:10px">
                <a href="Javascript:void(0)" class="text-danger "  id="reset" onclick="Filter.resetFilter()">Reset Filter</a>
                <a href="Javascript:void(0)" class="btn btn-success"  id="reset" onclick="Filter.listionFilter()">Search</a>
            </div>
        </div>
    </div>
</div>

@push('css')
<link rel="stylesheet" href="{{ asset('web/css/components/bs-select.css') }}" type="text/css" />
@endpush

@push('js')
<script src="{{ asset('web/js/components/bs-select.js') }}"></script>
<script src="{{ asset('web/js/components/selectsplitter.js') }}"></script>
<script type="text/javascript" src="{{ asset('web/js/filter.js') }}?v={{ $version }}"></script>
@endpush
