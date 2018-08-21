@extends('layouts.app')

@section('content')
<main class="section">
    <div class="container">
        <div class="columns">
            <div class="column is-offset-4 is-4">
                <div class="box">
                    <h1 class="has-text-centered m-b-30">
                        <a href="{{ url('/dashboard') }}" class="has-text-black">
                            <span class="logo is-size-6">
                                {{ __('common.invited_from_:name', [ 'name' => $member_invitation_link->organization->name ]) }}
                            </span>
                        </a>
                    </h1>
                    <form method="POST" action="{{ route('invitation.member.register', [ $member_invitation_link->token ]) }}">
                        @csrf

                        <div class="field">
                            <label class="label is-small">{{ __('db.attributes.user.name') }}</label>
                            <div class="control has-icons-left">
                                <input id="input" type="text" class="input {{ $errors->has('name') ? ' is-danger' : '' }}" name="name" placeholder="" value="{{ old('name') }}" required>
                                <span class="icon is-small is-left">
                                    <i class="fas fa-user"></i>
                                </span> 
                                @if ($errors->has('name'))
                                    <p class="help is-danger">{{ $errors->first('name') }}</p>
                                @endif
                            </div>
                        </div>

                        <div class="field">
                            <label class="label is-small">{{ __('db.attributes.user.email') }}</label>
                            <div class="control  has-icons-left">
                                <input id="input" type="email" class="input {{ $errors->has('email') ? ' is-danger' : '' }}" name="email" placeholder="{{ __('common.email') }}" value="{{ old('email', $member_invitation_link->email) }}" required @if($member_invitation_link->email) readonly @endif>
                                <span class="icon is-small is-left">
                                    <i class="fas fa-envelope"></i>
                                </span>
                                @if ($errors->has('email'))
                                    <p class="help is-danger">{{ $errors->first('email') }}</p>
                                @endif
                            </div>
                        </div>

                        <div class="field">
                            <label class="label is-small">{{ __('db.attributes.user.password') }}</label>
                            <div class="control has-icons-left">
                                <input id="password" type="password" class="input {{ $errors->has('password') ? ' is-danger' : '' }}" placeholder="{{ __('common.password') }}" name="password" required>
                                <span class="icon is-small is-left">
                                    <i class="fas fa-lock"></i>
                                </span>
                                @if ($errors->has('password'))
                                    <p class="help is-danger">{{ $errors->first('password') }}</p>
                                @endif
                            </div>
                        </div>

                        <div class="field">
                            <label class="label is-small">{{ __('db.attributes.user.password_confirmation') }}</label>
                            <div class="control has-icons-left">
                                <input id="password" type="password" class="input {{ $errors->has('password_confirmation') ? ' is-danger' : '' }}" placeholder="{{ __('common.password_confirmation') }}" name="password_confirmation" required>
                                <span class="icon is-small is-left">
                                    <i class="fas fa-lock"></i>
                                </span>
                                @if ($errors->has('password_confirmation'))
                                    <p class="help is-danger">{{ $errors->first('password_confirmation') }}</p>
                                @endif
                            </div>
                        </div>

                        <div class="field m-t-30">
                            <div class="control">
                                <button type="submit" class="button is-primary is-fullwidth">
                                    {{ __('common.register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
