@extends('layouts.app')

@section('content')
<nav class="breadcrumb is-admin has-succeeds-separator" aria-label="breadcrumbs">
    <ul>
        <li>
            <a style="padding-left: 0.5rem;" href="{{ url('/dashboard') }}">{{ __('common.dashboard') }}</a>
        </li>
        <li>
            <a style="padding-left: 0.5rem;" href="{{ route('source.index') }}">{{ __('db.models.source') }}</a>
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
                {{ __('db.models.source') }}
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
                    <form method="POST" action="{{ route('source.store') }}">
                        @csrf
                        <h3 class="m-t-20 item-title is-border-line">{{ __('common.basic_information') }}</h3>
                        <div class="field">
                            <label class="label is-small">{{ __('db.attributes.source.name') }}</label>
                            <div class="control has-icons-left">
                                {!! Form::text('name', old('name', $source->name), ['class' => 'input' . ($errors->has('name') ? ' is-danger' : '' ), 'placeholder' => __('db.attributes.source.name')]) !!}
                                <span class="icon is-small is-left">
                                    <i class="fas fa-building"></i>
                                </span> 
                                @if ($errors->has('name'))
                                    <p class="help is-danger">{{ $errors->first('name') }}</p>
                                @endif
                            </div>
                        </div>

                        <div class="field">
                            <label class="label is-small">{{ __('db.attributes.source.contact_name') }}</label>
                            <div class="control has-icons-left">
                                {!! Form::text('contact_name', old('contact_name', $source->contact_name), [ 'list' => 'contact_name_list', 'class' => 'input' . ($errors->has('contact_name') ? ' is-danger' : '' ), 'placeholder' => __('db.attributes.client.contact_name')]) !!}
                                @if(count($memberOptions))
                                    <datalist id="contact_name_list">
                                        @foreach($memberOptions as $name)
                                            <option value="{{ $name }}"></option>
                                        @endforeach
                                    </datalist>
                                @endif
                                <span class="icon is-small is-left">
                                    <i class="fas fa-user"></i>
                                </span> 
                                @if ($errors->has('contact_name'))
                                    <p class="help is-danger">{{ $errors->first('contact_name') }}</p>
                                @endif
                            </div>
                        </div>

                        <div class="field">
                            <label class="label is-small">{{ __('db.attributes.source.email') }}</label>
                            <div class="control  has-icons-left">
                                {!! Form::email('email', old('email', $source->email), ['class' => 'input' . ($errors->has('email') ? ' is-danger' : '' ), 'placeholder' => __('db.attributes.client.email')]) !!}
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
                                    <label class="label is-small">{{ __('db.attributes.source.postal_code') }}</label>
                                    <div class="control">
                                        {!! Form::text('postal_code', old('postal_code', $source->postal_code), ['class' => 'input' . ($errors->has('postal_code') ? ' is-danger' : '' )]) !!}
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
                            <label class="label is-small">{{ __('db.attributes.source.address1') }}</label>
                            <div class="control">
                                {!! Form::text('address1', old('address1', $source->address1), ['class' => 'input' . ($errors->has('address1') ? ' is-danger' : '' )]) !!}
                                @if ($errors->has('address1'))
                                    <p class="help is-danger">{{ $errors->first('address1') }}</p>
                                @endif

                                {!! Form::text('address2', old('address2', $source->address2), ['class' => 'input m-t-5' . ($errors->has('address2') ? ' is-danger' : '' )]) !!}
                                @if ($errors->has('address2'))
                                    <p class="help is-danger">{{ $errors->first('address2') }}</p>
                                @endif

                                {!! Form::text('address3', old('address3', $source->address3), ['class' => 'input m-t-5' . ($errors->has('address3') ? ' is-danger' : '' )]) !!}
                                @if ($errors->has('address3'))
                                    <p class="help is-danger">{{ $errors->first('address3') }}</p>
                                @endif
                            </div>
                        </div>

                        <h3 class="m-t-20 item-title is-border-line">{{ __('common.bank_account_information') }}</h3>
                        <div class="field">
                            <label class="label is-small">{{ __('db.models.payee') }}</label>
                            <div id="payee-block" class="control">
                                @if(!is_null(old('_token')))
                                    @foreach (old('payees') as $i => $form)
                                        <?php
                                            $payee = $form['id'] ? $source->payees()->find($form['id'])->fill($form) : new \App\Models\Source\Payee($form);
                                        ?>
                                        @if (!$form['_delete'])
                                            @include('source._source_payee_field', [ 'payee' => $payee, 'index' => $i ])
                                        @endif
                                    @endforeach
                                @else
                                    @foreach ($source->payees as $i => $payee)
                                        @include('source._source_payee_field', [ 'payee' => $payee, 'index' => $i ])
                                    @endforeach
                                @endif
                            </div>
                            {{ link_to_add_fields(__('common.add'), 'Source\Payee', 'source', [ 'class' => 'button is-outlined is-info', 'data-target' => '#payee-block' ]) }}
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
