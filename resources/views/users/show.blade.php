<div class="content" >
    <div class="row">
        <table class="table table-border table-stripped">
            <tbody>
                <tr>
                    <th>Name</th>
                    <td>
                        {{ ucfirst($siteUser->name) }}
                    </td>
                </tr>
                <tr>
                    <th>Phone No</th>
                    <td>
                        {{ $siteUser->phone_no }}
                    </td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>
                        {{ $siteUser->email }}
                    </td>
                </tr>
                <tr>
                    <th>Sex</th>
                    <td>
                        {{ ucfirst($siteUser->sex) }}
                    </td>
                </tr>
                <tr>
                    <th>Address</th>
                    <td>
                        {{ ucfirst($siteUser->address) }}<br>
                        City : {{ $siteUser->city }} <br>
                        State : {{ $siteUser->state }} <br>
                        PinCode : {{  $siteUser->zipcode }}
                    </td>
                </tr>
                <tr>
                    <th>Is Active</th>
                    <td>
                        <input type="checkbox" id="site_user_status" onchange="updateStatus('{{ $siteUser->phone_no }}')" value="active"  {{ $siteUser->isActiveUser() ? 'checked' : '' }} />
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
