<!DOCTYPE html>
<html>

<head>
    <title></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <style type="text/css">
        @media screen {
            @font-face {
                font-family: 'Lato';
                font-style: normal;
                font-weight: 400;
                src: local('Lato Regular'), local('Lato-Regular'), url(https://fonts.gstatic.com/s/lato/v11/qIIYRU-oROkIk8vfvxw6QvesZW2xOQ-xsNqO47m55DA.woff) format('woff');
            }

            @font-face {
                font-family: 'Lato';
                font-style: normal;
                font-weight: 700;
                src: local('Lato Bold'), local('Lato-Bold'), url(https://fonts.gstatic.com/s/lato/v11/qdgUG4U09HnJwhYI-uK18wLUuEpTyoUstqEm5AMlJo4.woff) format('woff');
            }

            @font-face {
                font-family: 'Lato';
                font-style: italic;
                font-weight: 400;
                src: local('Lato Italic'), local('Lato-Italic'), url(https://fonts.gstatic.com/s/lato/v11/RYyZNoeFgb0l7W3Vu1aSWOvvDin1pK8aKteLpeZ5c0A.woff) format('woff');
            }

            @font-face {
                font-family: 'Lato';
                font-style: italic;
                font-weight: 700;
                src: local('Lato Bold Italic'), local('Lato-BoldItalic'), url(https://fonts.gstatic.com/s/lato/v11/HkF_qI1x_noxlxhrhMQYELO3LdcAZYWl9Si6vvxL-qU.woff) format('woff');
            }
        }

        /* CLIENT-SPECIFIC STYLES */
        body,
        table,
        td,
        a {
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
        }

        table,
        td {
            mso-table-lspace: 0pt;
            mso-table-rspace: 0pt;
        }

        img {
            -ms-interpolation-mode: bicubic;
        }

        /* RESET STYLES */
        img {
            border: 0;
            height: auto;
            line-height: 100%;
            outline: none;
            text-decoration: none;
        }

        table {
            border-collapse: collapse !important;
        }

        body {
            height: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
            width: 100% !important;
        }

        /* iOS BLUE LINKS */
        a[x-apple-data-detectors] {
            color: inherit !important;
            text-decoration: none !important;
            font-size: inherit !important;
            font-family: inherit !important;
            font-weight: inherit !important;
            line-height: inherit !important;
        }

        /* MOBILE STYLES */
        @media screen and (max-width:600px) {
            h1 {
                font-size: 32px !important;
                line-height: 32px !important;
            }
        }

        /* ANDROID CENTER FIX */
        div[style*="margin: 16px 0;"] {
            margin: 0 !important;
        }
    </style>
</head>

<body style="background-color: #fff; margin: 0 !important; padding: 0 !important;">
    <!-- HIDDEN PREHEADER TEXT -->
    <div style="text-align: left; line-height: 20p">
        New Order was placed by <br>
        Customer Name : <b>{{ ucfirst($user->name) }}</b> <br>
        Phone No : <a href="tel:{{ $user->phone_no }}">{{ $user->phone_no }}</a><br>
        Email Id : <a href="mail:{{ $user->email }}">{{ $user->email }}</a><br>
        <p style="text-align: justify; line-height: 20px" style="width: 200px;">
            <b>Address Details</b><br>
            {{ $user->address }}
        </p>
        <br>
        <b>Order Status</b> :<br>
        <span
                @if(in_array(optional($userOrder->order_status)->slug, ['cancel']))
                    style="color:red"
                @endif
            >
            {{ strtoupper(optional($userOrder->order_status)->name) }}
        </span>
        <br>
        <b>Order Date</b> :<br>{{ $userOrder->created_at }}
    </div>
    <h4><ul>Order Details</ul></h4>
    <table border="1" cellpadding="0" cellspacing="0" style="margin: auto; width:80%">
        <tbody>
            <tr>
                <th style="background-color: #eee; text-align: center">Created On</th>
                <td id="order_created_on">{{ $userOrder->created_at }}</td>
            </tr>
            <tr>
                <th style="background-color: #eee; text-align: center">Name</th>
                <td id="order_user_name">{{ $user->name }}</td>
            </tr>
            <tr>
                <th style="background-color: #eee; text-align: center">Prescription</th>
                <td id="order_prescription" style="text-align: justify; line-height:12px">
                        @php $i=1; @endphp
                        @foreach ($userOrder->prescription_details as $prescription )
                            <a href="{{ asset('web/images/prescriptions/' . $prescription->image) }}" id="order_prescription_url" target="_blank">
                                View Prescription{{ $i == 1 ? '' : " - " . $i }}
                            </a>
                            @php
                                $i++;
                            @endphp
                        @endforeach
                </td>
            </tr>
            <tr>
                <th style="background-color: #eee; text-align: center">Phone No</th>
                <td id="order_user_phone_no">
                    <a href="tel:{{ $user->phone_no }}">{{ $user->phone_no }}</a>
                </td>
            </tr>
            <tr>
                <th style="background-color: #eee; text-align: center">Email Id</th>
                <td id="order_user_email_id">
                    <a href="mail:{{ $user->email }}">{{ $user->email }}</a>
                </td>
            </tr>
            <tr>
                <th style="background-color: #eee; text-align: center">Comment</th>
                <td id="order_user_comment_text" style="text-align: justify; line-height:18px">
                   {{ $userOrder->comment_text }}
                </td>
            </tr>
        </tbody>
    </table>
</body>
</html>
