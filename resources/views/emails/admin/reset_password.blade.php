@component('mail::message')
# 用户您好，

重置密码时发送的验证码如下，30 分钟内有效。

@component('mail::panel')
    {{ $code }}
@endcomponent

-----
如非本人操作，可能您的账号存在安全风险，请立即修改密码。<br>
{{--{{ config('app.name') }}--}}
@endcomponent
