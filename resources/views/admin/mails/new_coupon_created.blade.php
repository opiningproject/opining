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
                {{ trans('email.common.dear') }} {{ $user->full_name }},<br><br>
            </h1>
            <p
                style="box-sizing:border-box;font-size:16px;line-height:1.5em;margin-top:0;text-align:left">
                {{ trans('email.admin.coupon.content1') }}<br>
            </p>
            <p
                style="box-sizing:border-box;font-size:16px;line-height:1.5em;margin-top:0;text-align:left">
                {{ trans('email.admin.coupon.content2') }}<br>
            </p>
            <p
                style="box-sizing:border-box;font-size:16px;line-height:1.5em;margin-top:0;text-align:left">
                {{ trans('email.common.best_wishes', ['rest_name' => config('app.name')]) }}<br>
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
