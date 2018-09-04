@component('mail::message')
#{{ __('common.reset_password') }}

@component('mail::button', ['url' => route('password.reset', ['token'=>$token])])
{{ __('common.reset_password') }}
@endcomponent

@endcomponent
