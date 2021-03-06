@extends('layouts.app')

@section('content')
<nav class="breadcrumb is-admin has-succeeds-separator" aria-label="breadcrumbs">
    <ul>
        <li>
            <a style="padding-left: 0.5rem;" href="{{ url('/dashboard') }}">{{ __('common.dashboard') }}</a>
        </li>
        <li>
            <a style="padding-left: 0.5rem;" href="{{ route('client.index') }}">{{ __('db.models.client') }}</a>
        </li>
        <li class="is-active">
            <a href="#" aria-current="page">{{ __('common.register') }}</a>
        </li>
    </ul>
</nav>
<section class="hero is-dark is-desktop-border-left is-small">
    <div class="hero-body">
        <div class="container-fulid">
            <h1 class="title">
                {{ __('db.models.client') }}
            </h1>
            <h2 class="subtitle">
            </h2>
        </div>
    </div>
</section>
<main class="section">
    <div class="container-fulid">
        @include('layouts.messages')
        <div class="columns">
            <div class="column is-offset-3 is-6">
                <div class="box">
                    <form method="POST" action="{{ route('client.store') }}">
                        @csrf
                        <div class="field">
                            <label class="label is-small">{{ __('db.attributes.client.name') }}</label>
                            <div class="control has-icons-left">
                                {!! Form::text('name', old('name'), ['class' => 'input' . ($errors->has('name') ? ' is-danger' : '' ), 'placeholder' => __('db.attributes.client.name')]) !!}
                                <span class="icon is-small is-left">
                                    <i class="fas fa-building"></i>
                                </span> 
                                @if ($errors->has('name'))
                                    <p class="help is-danger">{{ $errors->first('name') }}</p>
                                @endif
                            </div>
                        </div>

                        <div class="field">
                            <label class="label is-small">{{ __('db.attributes.client.contact_name') }}</label>
                            <div class="control has-icons-left">
                                {!! Form::text('contact_name', old('contact_name'), ['class' => 'input' . ($errors->has('contact_name') ? ' is-danger' : '' ), 'placeholder' => __('db.attributes.client.contact_name')]) !!}
                                <span class="icon is-small is-left">
                                    <i class="fas fa-user"></i>
                                </span> 
                                @if ($errors->has('contact_name'))
                                    <p class="help is-danger">{{ $errors->first('contact_name') }}</p>
                                @endif
                            </div>
                        </div>

                        <div class="field">
                            <label class="label is-small">{{ __('db.attributes.client.email') }}</label>
                            <div class="control  has-icons-left">
                                {!! Form::email('email', old('email'), ['class' => 'input' . ($errors->has('email') ? ' is-danger' : '' ), 'placeholder' => __('db.attributes.client.email')]) !!}
                                <span class="icon is-small is-left">
                                    <i class="fas fa-envelope"></i>
                                </span>
                                @if ($errors->has('email'))
                                    <p class="help is-danger">{{ $errors->first('email') }}</p>
                                @endif
                            </div>
                        </div>

                        <div class="field">
                            <div class="columns">
                                <div class="column is-6">
                                    <label class="label is-small">{{ __('db.attributes.client.postal_code') }}</label>
                                    <div class="control">
                                        {!! Form::text('postal_code', old('postal_code'), ['class' => 'input' . ($errors->has('postal_code') ? ' is-danger' : '' )]) !!}
                                        @if ($errors->has('postal_code'))
                                            <p class="help is-danger">{{ $errors->first('postal_code') }}</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="column is-6">
                                </div>
                            </div>
                        </div>

                        <div class="field">
                            <label class="label is-small">{{ __('db.attributes.client.address1') }}</label>
                            <div class="control">
                                {!! Form::text('address1', old('address1'), ['class' => 'input' . ($errors->has('address1') ? ' is-danger' : '' )]) !!}
                                @if ($errors->has('address1'))
                                    <p class="help is-danger">{{ $errors->first('address1') }}</p>
                                @endif

                                {!! Form::text('address2', old('address2'), ['class' => 'input m-t-5' . ($errors->has('address2') ? ' is-danger' : '' )]) !!}
                                @if ($errors->has('address2'))
                                    <p class="help is-danger">{{ $errors->first('address2') }}</p>
                                @endif

                                {!! Form::text('address3', old('address3'), ['class' => 'input m-t-5' . ($errors->has('address3') ? ' is-danger' : '' )]) !!}
                                @if ($errors->has('address3'))
                                    <p class="help is-danger">{{ $errors->first('address3') }}</p>
                                @endif
                            </div>
                        </div>

                        <div class="field">
                            <label class="label is-small">{{ __('db.attributes.client.remarks') }}</label>
                            <div class="control">
                                {!! Form::textarea('remarks', old('remarks'), ['class'=>'textarea', 'rows' => 4]) !!}
                                @if ($errors->has('remarks'))
                                    <p class="help is-danger">{{ $errors->first('remarks') }}</p>
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
