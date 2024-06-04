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
                                        {{ trans('email.common.hello') }} {{ $order->user->full_name }}
                                    </h1>
                                    <p
                                        style="box-sizing:border-box;font-size:16px;line-height:1.5em;margin-top:0;text-align:left">
                                        {{ trans('email.order_status.content',['order_id' => $order->id, 'order_status' => $order_status]) }}
                                    </p>

                                    <p style="font-family: 'Roboto', sans-serif; font-weight: 700;">
                                        {{ trans('email.common.order_id') }}: #{{ $order->id }}
                                    </p>
                                    <table align="left" width="100%" cellpadding="0" cellspacing="0" role="presentation"
                                           style="box-sizing:border-box;margin-bottom:0px;padding:0;text-align:left;width:100%">
                                        <tbody>
                                        <tr>
                                            <td>
                                                <table align="left" width="80%" cellpadding="0" cellspacing="0"
                                                       role="presentation"
                                                       style="box-sizing:border-box;margin-bottom:0px;padding:0;text-align:left; table-layout: fixed;">
                                                    <tbody>
                                                    @foreach($order->dishDetails as $key => $dish)
                                                        <tr>
                                                            <td style="box-sizing:border-box; width: 80%;">
                                                                {{ $dish->dish->name }} ({{ $dish->qty }} x
                                                                €{{ $dish->price }})
                                                            </td>
                                                            <td style="box-sizing:border-box; padding:3px 10px;">
                                                                    <?php $itemPrice = ($dish->price * $dish->qty) + $dish->paid_ingredient_total; ?>
                                                                €{{ $itemPrice }}
                                                            </td>
                                                        </tr>
                                                    @endforeach

                                                    <tr>
                                                        <td style="box-sizing:border-box; width: 80%;">
                                                            {{ trans('email.common.sub_total') }}
                                                        </td>
                                                        <td style="box-sizing:border-box; padding:3px 10px;">
                                                            €{{ getOrderGrossAmount($order) }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="box-sizing:border-box; width: 80%;">
                                                            {{ trans('email.common.platform_charges') }}
                                                        </td>
                                                        <td style="box-sizing:border-box; padding:3px 10px;">
                                                            €{{ $order->platform_charge }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="box-sizing:border-box; width: 80%;">
                                                            {{ trans('email.common.delivery_charges') }}
                                                        </td>
                                                        <td style="box-sizing:border-box; padding:3px 10px;">
                                                            €{{ $order->delivery_charge }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="box-sizing:border-box; width: 80%;">
                                                            {{ trans('email.common.coupon_discount') }}
                                                        </td>
                                                        <td style="box-sizing:border-box; padding:3px 10px;">
                                                            - €{{ $order->coupon_discount }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="box-sizing:border-box;font-weight: bold; width: 80%;">
                                                            {{ trans('email.common.paid') }}
                                                        </td>
                                                        <td style="box-sizing:border-box;font-weight: bold; padding:3px 10px;">
                                                            €{{ $order->total_amount }}
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

                            <tr>
                                <td style="padding:0px 32px;">
                                    <p style="box-sizing:border-box; font-size:16px; line-height:1.5em; margin-top:0; text-align:left; display:inline-block; width:100%;">
                                        {{ trans('email.common.regards') }},<br> {{ env('APP_NAME') }}
                                    </p>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>

                <tr>
                    <td style="box-sizing:border-box;">
                        <table align="center" cellpadding="0" cellspacing="0" role="presentation"
                               style="box-sizing:border-box; margin:0 auto;padding:0; text-align:center; max-width:570px;width: 100%;">
                            <tbody>
                            <tr>
                                <td align="center" style="box-sizing:border-box; max-width:100vw; padding:32px">
                                    <p style="box-sizing:border-box; line-height:1.5em; margin-top:0; color:#b0adc5; font-size:12px; text-align:center;">
                                        {{ trans('email.email.all_rights_reserved',['app_name' => env('APP_NAME')]) }}
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
