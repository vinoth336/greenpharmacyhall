<div >
    <h6 style="font-weight: bolder">Address Information</h6>
    <div style="line-height:35px">
    @php
        $user = auth()->user();
    @endphp
    @php
        $addressInfo = explode(",", $user->address);
        echo implode("<br>", $addressInfo);
    @endphp<br>
    Karur, Tamil Nadu<br>
    PinCode - {{ $user->zipcode }}<br>
    <b>Phone No : </b> {{ $user->phone_no }}
    </div>
</div>
