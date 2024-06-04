<x-mail::message>
    <strong>{{ trans('email.common.hello') }} {{ $user->full_name }},</strong><br>
    {{ trans('email.account.welcome') }}, {{ trans('email.account.content', ['rest_name' => env('APP_NAME')]) }}<br><br>
    {{ trans('email.common.regards') }},<br>
    {{ config('app.name') }}
</x-mail::message>
