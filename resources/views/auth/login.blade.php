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

                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="field">
                            <label class="label is-small">{{ __('db.attributes.user.email') }}</label>
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
                                <div class="columns">
                                    <div class="column is-offset-3 is-6">
                                        <button type="submit" class="button is-primary" style="width: 100%;">
                                            {{ __('common.login') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <a class="btn btn-link is-size-7" href="{{ route('password.request') }}">
                            {{ __('common.forgot_your_password?') }}
                        </a>

                    </form>
                </div>                
            </div>
        </div>
    </div>
</main>
@endsection
