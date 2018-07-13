@extends('layouts.app')

@section('content')
<main class="section">
    <div class="container">
        <div class="columns">
            <div class="column is-offset-4 is-4">

                <div class="box">
                    <h1 class="has-text-centered">
                        <a href="{{ url('/dashboard') }}" class="has-text-black">
                            <span class="logo">{{ __('common.reset_password') }}</span>
                        </a>
                    </h1>

                    <form method="POST" action="{{ route('password.email') }}" class="m-t-50">
                        @if (session('status'))
                            <div class="message is-success">
                                <div class="message-body">
                                    <ul>
                                        <li>{{ session('status') }}</li>
                                    </ul>
                                </div>
                            </div>
                        @endif

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

                        <div class="field m-t-30">
                            <div class="control">
                                <button type="submit" class="button is-primary is-fullwidth">
                                    {{ __('common.submit') }}
                                </button>
                            </div>
                        </div>
                    </form>

                    <div class="is-divider" data-content="OR"></div>


                    <a href="{{ route('login') }}" class="button is-outlined is-primary is-fullwidth m-b-5">
                        {{ __('common.login') }}
                    </a>
                    <a href="{{ route('register') }}" class="button is-outlined is-primary is-fullwidth">
                        {{ __('common.register') }}
                    </a>
                </div>                
            </div>
        </div>
    </div>
</main>
@endsection
