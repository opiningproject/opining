<body class="body"
      style="padding:0 !important; margin:0 !important; display:block !important; min-width:100% !important; width:100% !important; background:#edf2f7; -webkit-text-size-adjust:none;">
<table width="100%" cellpadding="0" cellspacing="0" role="presentation"
       style="box-sizing:border-box; font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol'; background-color:#edf2f7; margin:0;padding:0;width:100%">
    <tbody>
    <tr>
        <td align="center" style="box-sizing:border-box;">
            <table width="100%" cellpadding="0" cellspacing="0" role="presentation"
                   style="box-sizing:border-box; margin:0; padding:0; width:100%">
                <tbody>
                <tr>
                    <td style="box-sizing:border-box;text-align:center">
                        <table align="center" width="570" cellpadding="0" cellspacing="0" role="presentation"
                               style="box-sizing:border-box; margin:0 auto; padding:0; text-align:center; width:570px">
                            <tbody>
                            <tr>
                                <td align="center" style="box-sizing:border-box; max-width:100vw; padding:25px 0;">
                                    <a href="#"
                                       style="box-sizing:border-box;color:#3d4852;font-size:19px;font-weight:bold;text-decoration:none;display:inline-block"
                                       target="_blank">
                                        {{ env('APP_NAME') }}
                                    </a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>

                <tr>
                    <td width="100%" cellpadding="0" cellspacing="0"
                        style="box-sizing:border-box;background-color:#edf2f7;border-bottom:1px solid #edf2f7;border-top:1px solid #edf2f7;margin:0;padding:0;width:100%">
                        <table align="center" cellpadding="0" cellspacing="0"
                               role="presentation"
                               style="box-sizing:border-box;background-color:#ffffff;border-color:#e8e5ef;border-radius:2px;border-width:1px;margin:0 auto;padding:0;max-width:570px;width:100%;">

                            <tbody>
                            <tr>
                                <td
                                    style="box-sizing:border-box;max-width:100vw;padding:32px">

                                    <h1
                                        style="box-sizing:border-box;color:#3d4852;font-size:18px;font-weight:bold;margin-top:0;text-align:left">
                                        {{ trans('email.common.hello') }}
                                    </h1>
                                    <p
                                        style="box-sizing:border-box;font-size:16px;line-height:1.5em;margin-top:0;text-align:left">
                                        {{ trans('email.user.refund.content1', ['order_no' => $order->id, 'rest_name' => env('APP_NAME')]) }}
                                    </p>

                                    <p style="font-family: 'Roboto', sans-serif; font-weight: 700;">
                                        {{ trans('user.refund_req.refund_desc') }}: {{ $order->refund_description }}
                                    </p>
                                    <p
                                        style="box-sizing:border-box;font-size:16px;line-height:1.5em;margin-top:0;text-align:left">
                                        {{ trans('email.user.refund.content2') }}
                                    </p>
                                </td>
                            </tr>

                            <tr>
                                <td style="padding:0px 32px;">
                                    <p style="box-sizing:border-box; font-size:16px; line-height:1.5em; margin-top:0; text-align:left; display:inline-block; with:100%;">
                                        {{ trans('email.common.regards') }},<br> {{ $order->user->full_name }}
                                    </p>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    </tbody>
</table>
</body>
