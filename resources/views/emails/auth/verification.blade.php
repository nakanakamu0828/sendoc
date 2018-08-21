@component('mail::message')
#{{ __('common.verify_your_email_address') }}

@component('mail::button', ['url' => route('verify', [ 'token' => $user->email_token ])])
{{ __('common.verify_email_address') }}
@endcomponent
@endcomponent
