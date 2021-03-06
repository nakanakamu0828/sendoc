@extends('layouts.app')

@section('content')
<main class="section">
    <div class="container">
        <div class="columns">
            <div class="column is-offset-4 is-4">

                <div class="box">
                    <h1 class="has-text-centered">
                        <a href="{{ url('/dashboard') }}" class="has-text-black">
                            <span class="logo">{{ __('common.register') }}</span>
                        </a>
                    </h1>

                    <form method="POST" action="{{ route('register') }}" class="m-t-50">
                        @csrf
                        <div class="field">
                            <label class="label is-small is-required">{{ __('db.attributes.organization.name') }}</label>
                            <div class="control has-icons-left">
                                <input type="text" class="input {{ $errors->has('organization_name') ? ' is-danger' : '' }}" name="organization_name" placeholder="" value="{{ old('organization_name') }}" autofocus>
                                <span class="icon is-small is-left">
                                    <i class="fas fa-building"></i>
                                </span> 
                                @if ($errors->has('organization_name'))
                                    <p class="help is-danger">{{ $errors->first('organization_name') }}</p>
                                @endif
                            </div>
                        </div>

                        <div class="field">
                            <label class="label is-small is-required">{{ __('db.attributes.organization.type') }}</label>
                            <div class="control">
                                <div class="select">
                                    <select name="organization_type">
                                        @foreach($organization_types as $k => $v)
                                            <option
                                                value="{{ $v }}"
                                                @if(old('organization_type') === $v) selected @endif
                                            >
                                                {{ __('enum.organization.type.' . strtolower($k)) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @if ($errors->has('organization_type'))
                                    <p class="help is-danger">{{ $errors->first('organization_type') }}</p>
                                @endif
                            </div>
                        </div>

                        <div class="field">
                            <label class="label is-small is-required">{{ __('db.attributes.user.name') }}</label>
                            <div class="control has-icons-left">
                                <input type="text" class="input {{ $errors->has('name') ? ' is-danger' : '' }}" name="name" placeholder="" value="{{ old('name') }}">
                                <span class="icon is-small is-left">
                                    <i class="fas fa-user"></i>
                                </span> 
                                @if ($errors->has('name'))
                                    <p class="help is-danger">{{ $errors->first('name') }}</p>
                                @endif
                            </div>
                        </div>

                        <div class="field">
                            <label class="label is-small is-required">{{ __('db.attributes.user.email') }}</label>
                            <div class="control  has-icons-left">
                                <input id="input" type="email" class="input {{ $errors->has('email') ? ' is-danger' : '' }}" name="email" placeholder="{{ __('common.email') }}" value="{{ old('email') }}">
                                <span class="icon is-small is-left">
                                    <i class="fas fa-envelope"></i>
                                </span>
                                @if ($errors->has('email'))
                                    <p class="help is-danger">{{ $errors->first('email') }}</p>
                                @endif
                            </div>
                        </div>

                        <div class="field">
                            <label class="label is-small is-required">{{ __('db.attributes.user.password') }}</label>
                            <div class="control has-icons-left">
                                <input type="password" class="input {{ $errors->has('password') ? ' is-danger' : '' }}" placeholder="{{ __('common.password') }}" name="password">
                                <span class="icon is-small is-left">
                                    <i class="fas fa-lock"></i>
                                </span>
                                @if ($errors->has('password'))
                                    <p class="help is-danger">{{ $errors->first('password') }}</p>
                                @endif
                            </div>
                        </div>

                        <div class="field">
                            <label class="label is-small is-required">{{ __('db.attributes.user.password_confirmation') }}</label>
                            <div class="control has-icons-left">
                                <input type="password" class="input {{ $errors->has('password_confirmation') ? ' is-danger' : '' }}" placeholder="{{ __('common.password_confirmation') }}" name="password_confirmation">
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

                    <div class="is-divider" data-content="OR"></div>

                    <a href="{{ route('login') }}" class="button is-outlined is-primary is-fullwidth">
                        {{ __('common.login') }}
                    </a>

                </div>
            </div>
        </div>
    </div>
</main>
@endsection
