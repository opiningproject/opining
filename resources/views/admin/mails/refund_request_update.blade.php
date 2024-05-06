<body class="body"
      style="padding:0 !important; margin:0 !important; display:block !important; min-width:100% !important; width:100% !important; background:#edf2f7; -webkit-text-size-adjust:none;">
<table align="center" cellpadding="0" cellspacing="0"
       role="presentation"
       style="box-sizing:border-box;background-color:#ffffff;border-color:#e8e5ef;border-radius:2px;border-width:1px;margin:0 auto;padding:0;max-width:570px;width:100%;">

    <tbody>
    <tr>
        <td
            style="box-sizing:border-box;max-width:100vw;padding:32px">
            <h1
                style="box-sizing:border-box;color:#3d4852;font-size:18px;font-weight:bold;margin-top:0;text-align:left">
                {{ trans('email.common.dear') }} {{ $order->user->full_name }},
            </h1>
            <p
                style="box-sizing:border-box;font-size:16px;line-height:1.5em;margin-top:0;text-align:left">
                {{ trans('email.admin.refund.content1') }}<br>
            </p>
            <p
                style="box-sizing:border-box;font-size:16px;line-height:1.5em;margin-top:0;text-align:left">
                {{ trans('email.admin.refund.content2', ['order_no' => $order->id]) }}<br>
            </p>
            <p
                style="box-sizing:border-box;font-size:16px;line-height:1.5em;margin-top:0;text-align:left">
                {{ trans('email.common.refund_details') }}<br>
            </p>
            <table align="left" width="100%" cellpadding="0" cellspacing="0"
                   role="presentation"
                   style="box-sizing:border-box;margin-bottom:0px;padding:0;text-align:left;width:100%">
                <tbody>
                <tr>
                    <td>
                        <table align="left" width="80%" cellpadding="0" cellspacing="0"
                               role="presentation"
                               style="box-sizing:border-box;margin-bottom:0px;padding:0;text-align:left; table-layout: fixed;">
                            <tbody>
                            <tr>
                                <td style="box-sizing:border-box; width: 80%;">
                                    {{ trans('email.common.order_no') }}
                                </td>
                                <td style="box-sizing:border-box; padding:3px 10px;">
                                    #{{ $order->id }}
                                </td>
                            </tr>
                            <tr>
                                <td style="box-sizing:border-box; width: 80%;">
                                    {{ trans('email.common.refund_amount') }}
                                </td>
                                <td style="box-sizing:border-box; padding:3px 10px;">
                                    € {{ date('d-m-Y H:i:s',$order->total_amount) }}
                                </td>
                            </tr>
                            <tr>
                                <td style="box-sizing:border-box; width: 80%;">
                                    {{ trans('email.common.refund_method') }}
                                </td>
                                <td style="box-sizing:border-box; padding:3px 10px;">
                                    € {{ $order->payment_method }}
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                </tbody>
            </table>
            <p
                style="box-sizing:border-box;font-size:16px;line-height:1.5em;margin-top:0;text-align:left">
                {{ trans('email.admin.refund.content3') }}<br>
            </p>
            <p
                style="box-sizing:border-box;font-size:16px;line-height:1.5em;margin-top:0;text-align:left">
                {{ trans('email.admin.refund.content4') }}<br>
            </p>
        </td>
    </tr>

    <tr>
        <td style="padding:0px 32px;">
            <p style="box-sizing:border-box; font-size:16px; line-height:1.5em; margin-top:0; text-align:left; display:inline-block; with:100%;">
                {{ trans('email.common.best_regards') }},<br> {{ env('APP_NAME') }}
            </p>
        </td>
    </tr>
    </tbody>
</table>
</body>
