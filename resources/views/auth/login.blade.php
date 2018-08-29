@extends('layouts.app')

@section('content')
<main class="section">
    <div class="container">
        <div class="columns">
            <div class="column is-offset-4 is-4">

                <div class="box">
                    <h1 class="has-text-centered">
                        <a href="{{ url('/dashboard') }}" class="has-text-black">
                            <span class="logo">{{ __('common.login') }}</span>
                        </a>
                    </h1>

                    <form method="POST" action="{{ route('login') }}" class="m-t-50">
                        @csrf
                        <div class="field">
                            <label class="label is-small is-required">{{ __('db.attributes.user.email') }}</label>
                            <div class="control  has-icons-left">
                                <input id="input" type="email" class="input {{ $errors->has('email') ? ' is-danger' : '' }}" name="email" placeholder="{{ __('common.email') }}" value="{{ old('email') }}" required autofocus>
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
                            <div class="control">
                                <div class="checkbox">
                                    <label class="is-size-7">
                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> {{ __('common.remember_me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="field m-t-30">
                            <div class="control">
                                <button type="submit" class="button is-primary is-fullwidth">
                                    {{ __('common.login') }}
                                </button>
                            </div>
                        </div>


                        <a class="btn btn-link is-size-7" href="{{ route('password.request') }}">
                            {{ __('common.forgot_your_password?') }}
                        </a>

                    </form>

                    <div class="is-divider" data-content="OR"></div>

                    <a href="{{ route('register') }}" class="button is-outlined is-primary is-fullwidth">
                        {{ __('common.register') }}
                    </a>
                </div>                
            </div>
        </div>
    </div>
</main>
@endsection
