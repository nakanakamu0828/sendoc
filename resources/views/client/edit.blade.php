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
            <a href="#" aria-current="page">{{ __('common.edit') }}</a>
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
                    <form method="POST" action="{{ route('client.update', [$client->id]) }}">
                        @csrf
                        {{ method_field('PUT') }}
                        <div class="field">
                            <label class="label is-small">{{ __('db.attributes.client.name') }}</label>
                            <div class="control has-icons-left">
                                {!! Form::text('name', old('name', $client->name), ['class' => 'input' . ($errors->has('name') ? ' is-danger' : '' ), 'placeholder' => __('db.attributes.client.name')]) !!}
                                <span class="icon is-small is-left">
                                    <i class="fas fa-building"></i>
                                </span> 
                                @if ($errors->has('name'))
                                    <p class="help is-danger">{{ $errors->first('name') }}</p>
                                @endif
                            </div>
                        </div>

                        <div class="field">
                            <div class="control">
                                <label class="label is-small">{{ __('db.attributes.client.country') }}</label>
                                <div class="select">
                                    {!!
                                        Form::select('country',
                                            [
                                                '' => '▼ 選択してください',
                                                'japan' => __('db.enums.client.country.japan'),
                                                'china' => __('db.enums.client.country.china'),
                                                'koria' => __('db.enums.client.country.koria'),
                                            ],
                                            old('country', $client->country),
                                            []
                                        )
                                    !!}
                                </div>
                                @if ($errors->has('country'))
                                    <p class="help is-danger">{{ $errors->first('country') }}</p>
                                @endif
                            </div>
                        </div>

                        <div class="field">
                            <label class="label is-small">{{ __('db.attributes.client.contact_name') }}</label>
                            <div class="control has-icons-left">
                                {!! Form::text('contact_name', old('contact_name', $client->contact_name), ['class' => 'input' . ($errors->has('contact_name') ? ' is-danger' : '' ), 'placeholder' => __('db.attributes.client.contact_name')]) !!}
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
                                {!! Form::email('email', old('email', $client->email), ['class' => 'input' . ($errors->has('email') ? ' is-danger' : '' ), 'placeholder' => __('db.attributes.client.email')]) !!}
                                <span class="icon is-small is-left">
                                    <i class="fas fa-envelope"></i>
                                </span>
                                @if ($errors->has('email'))
                                    <p class="help is-danger">{{ $errors->first('email') }}</p>
                                @endif
                            </div>
                        </div>

                        <div class="field">
                            <label class="label is-small">{{ __('db.attributes.client.user_id') }}</label>
                            <div class="control">
                                <div class="select">
                                    {!!
                                        Form::select('user_id',
                                            ['' => '▼ 選択してください'] + $memberOptions->toArray(),
                                            old('user_id', $client->user_id),
                                            []
                                        )
                                    !!}
                                </div>
                                @if ($errors->has('user_id'))
                                    <p class="help is-danger">{{ $errors->first('user_id') }}</p>
                                @endif
                            </div>
                        </div>

                        <div class="field">
                            <label class="label is-small">{{ __('db.attributes.client.client_type') }}</label>
                            <div class="control">
                                <div class="select">
                                    {!! 
                                        Form::select('client_type',
                                            [ 'all' => __('db.enums.client.client_type.all'), 'proposal_only' => __('db.enums.client.client_type.proposal_only'), 'personnel_only' => __('db.enums.client.client_type.personnel_only') ],
                                            old('client_type', $client->client_type),
                                            ['class' => '']
                                        )
                                    !!}
                                </div>
                                @if ($errors->has('client_type'))
                                    <p class="help is-danger">{{ $errors->first('client_type') }}</p>
                                @endif
                            </div>
                        </div>

                        <div class="field">
                            <label class="label is-small">{{ __('db.attributes.client.remarks') }}</label>
                            <div class="control">
                                {!! Form::textarea('remarks', old('remarks', $client->remarks), ['class'=>'textarea', 'rows' => 4]) !!}
                                @if ($errors->has('remarks'))
                                    <p class="help is-danger">{{ $errors->first('remarks') }}</p>
                                @endif
                            </div>
                        </div>

                        <div class="field">
                            <div class="control">
                                <button type="submit" class="button is-primary">
                                    {{ __('common.edit') }}
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
