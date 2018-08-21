@component('mail::message')
#{{ __('common.invited_from_:name', [ 'name' => $link->organization->name ]) }}

@component('mail::button', ['url' => route('invitation.member.register', [ 'token' => $link->token ])])
{{ __('common.verify_email_address') }}
@endcomponent
@endcomponent
