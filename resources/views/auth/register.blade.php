@extends('layouts.app')

@section('content')
<main class="section">
    <div class="container">
        <div class="columns">
            <div class="column is-offset-3 is-6">

                <div class="box">
                    <h1 class="title has-text-centered">
                        <a href="{{ url('/dashboard') }}" class="has-text-black">
                            <span class="logo">{{ config('app.name', 'Laravel') }}</span>
                        </a>
                    </h1>

                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="field">
                            <label class="label is-small">{{ __('db.attributes.user.name') }}</label>
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
                            <label class="label is-small">{{ __('db.attributes.user.name') }}</label>
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
                            <label class="label is-small">{{ __('db.attributes.user.email') }}</label>
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
                            <label class="label is-small">{{ __('db.attributes.user.password') }}</label>
                            <div class="control has-icons-left">
                                <input ype="password" class="input {{ $errors->has('password') ? ' is-danger' : '' }}" placeholder="{{ __('common.password') }}" name="password">
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
                                <input type="password" class="input {{ $errors->has('password_confirmation') ? ' is-danger' : '' }}" placeholder="{{ __('common.password_confirmation') }}" name="password_confirmation">
                                <span class="icon is-small is-left">
                                    <i class="fas fa-lock"></i>
                                </span>
                                @if ($errors->has('password_confirmation'))
                                    <p class="help is-danger">{{ $errors->first('password_confirmation') }}</p>
                                @endif
                            </div>
                        </div>

                        <div class="field">
                            <div class="control">
                                <button type="submit" class="button is-primary">
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
