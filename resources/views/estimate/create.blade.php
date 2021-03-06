@extends('layouts.app')

@section('content')
<nav class="breadcrumb is-admin has-succeeds-separator" aria-label="breadcrumbs">
    <ul>
        <li>
            <a style="padding-left: 0.5rem;" href="{{ url('/dashboard') }}">{{ __('common.dashboard') }}</a>
        </li>
        <li>
            <a style="padding-left: 0.5rem;" href="{{ route('estimate.index') }}">{{ __('db.models.estimate') }}</a>
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
                {{ __('db.models.estimate') }}
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
            <div class="column is-offset-1 is-10">
                <div class="box">
                    <form method="POST" action="{{ route('estimate.store') }}">
                        @csrf

                        <div class="columns">
                            <div class="column is-6">
                                <h3 class="m-t-20 item-title is-border-line">{{ __('common.estimate_information') }}</h3>
                                <div class="field">
                                    <label class="label is-small">{{ __('db.attributes.estimate.estimate_no') }}</label>
                                    <div class="control">
                                        {!! Form::text('estimate_no', old('estimate_no', $estimate->estimate_no), ['class' => 'input' . ($errors->has('estimate_no') ? ' is-danger' : '' ), 'placeholder' => __('db.attributes.estimate.estimate_no')]) !!}
                                        @if ($errors->has('estimate_no'))
                                            <p class="help is-danger">{{ $errors->first('estimate_no') }}</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="field">
                                    <label class="label is-small">{{ __('db.attributes.estimate.title') }}</label>
                                    <div class="control">
                                        {!! Form::text('title', old('title', $estimate->title), ['class' => 'input' . ($errors->has('title') ? ' is-danger' : '' ), 'placeholder' => __('db.attributes.estimate.title')]) !!}
                                        @if ($errors->has('title'))
                                            <p class="help is-danger">{{ $errors->first('title') }}</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="field">
                                    <div class="columns">
                                        <div class="column is-6">
                                            <label class="label is-small">{{ __('db.attributes.estimate.date') }}</label>
                                            <div class="control">
                                                {!! Form::date('date', old('date', $estimate->date), ['class' => 'input' . ($errors->has('date') ? ' is-danger' : '' )]) !!}
                                                @if ($errors->has('date'))
                                                    <p class="help is-danger">{{ $errors->first('date') }}</p>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="column is-6">
                                            <label class="label is-small">{{ __('db.attributes.estimate.due') }}</label>
                                            <div class="control">
                                                {!! Form::date('due', old('due', $estimate->due), ['class' => 'input' . ($errors->has('due') ? ' is-danger' : '' )]) !!}
                                                @if ($errors->has('due'))
                                                    <p class="help is-danger">{{ $errors->first('due') }}</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="field">
                                    <label class="label is-small">{{ __('db.attributes.estimate.recipient') }}</label>
                                    <div class="control has-icons-right">
                                        {!! Form::text('recipient', old('recipient', $estimate->recipient), [ 'data-list' => 'recipient_list', 'class' => 'input' . ($errors->has('recipient') ? ' is-danger' : '' ), 'placeholder' => '', 'autocomplete' => 'off' ]) !!}
                                        <div id="recipient_list" class="dropdown is-block is-fullwidth">
                                            @if(count($clientOptions))
                                                <div class="dropdown-menu">
                                                    <div class="dropdown-content">
                                                        @foreach($clientOptions as $id => $name)
                                                            <a href="#" class="dropdown-item">
                                                                {{ $name }}
                                                            </a>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                        <span class="icon is-small is-right">
                                            <i class="fas fa-angle-down"></i>
                                        </span>
                                        @if ($errors->has('recipient'))
                                            <p class="help is-danger">{{ $errors->first('recipient') }}</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="field">
                                    <label class="label is-small">{{ __('db.attributes.estimate.recipient_contact') }}</label>
                                    <div class="control">
                                        {!! Form::text('recipient_contact', old('recipient_contact', $estimate->recipient_contact), ['class' => 'input' . ($errors->has('recipient_contact') ? ' is-danger' : '' ), 'placeholder' => '']) !!}
                                        @if ($errors->has('recipient_contact'))
                                            <p class="help is-danger">{{ $errors->first('recipient_contact') }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="column is-6">
                                <h3 class="m-t-20 item-title is-border-line">{{ __('common.estimate_sender_information') }}</h3>
                                <div class="field">
                                    <label class="label is-small">{{ __('db.attributes.estimate.sender') }}</label>
                                    <div class="control has-icons-right">
                                        {!! Form::text('sender', old('sender', $estimate->sender), [ 'data-list' => 'sender_list','class' => 'input' . ($errors->has('sender') ? ' is-danger' : '' ), 'placeholder' => '', 'autocomplete' => 'off' ]) !!}
                                        <div id="sender_list" class="dropdown is-block is-fullwidth">
                                            @if(count($sourceOptions))
                                                <div class="dropdown-menu">
                                                    <div class="dropdown-content">
                                                        @foreach($sourceOptions as $id => $name)
                                                            <a href="#" class="dropdown-item">
                                                                {{ $name }}
                                                            </a>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                        <span class="icon is-small is-right">
                                            <i class="fas fa-angle-down"></i>
                                        </span>
                                        @if ($errors->has('sender'))
                                            <p class="help is-danger">{{ $errors->first('sender') }}</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="field">
                                    <label class="label is-small">{{ __('db.attributes.estimate.sender_contact') }}</label>
                                    <div class="control">
                                        {!! Form::text('sender_contact', old('sender_contact', $estimate->sender_contact), ['class' => 'input' . ($errors->has('sender_contact') ? ' is-danger' : '' ), 'placeholder' => '']) !!}
                                        @if ($errors->has('sender_contact'))
                                            <p class="help is-danger">{{ $errors->first('sender_contact') }}</p>
                                        @endif
                                    </div>
                                </div>

                                <div class="field">
                                    <label class="label is-small">{{ __('db.attributes.estimate.sender_email') }}</label>
                                    <div class="control  has-icons-left">
                                        {!! Form::email('sender_email', old('sender_email', $estimate->sender_email), ['class' => 'input' . ($errors->has('sender_email') ? ' is-danger' : '' ), 'placeholder' => '']) !!}
                                        <span class="icon is-small is-left">
                                            <i class="fas fa-envelope"></i>
                                        </span>
                                        @if ($errors->has('sender_email'))
                                            <p class="help is-danger">{{ $errors->first('sender_email') }}</p>
                                        @endif
                                    </div>
                                </div>

                                <div class="field">
                                    <label class="label is-small">{{ __('db.attributes.estimate.sender_tel') }}</label>
                                    <div class="control">
                                        {!! Form::email('sender_tel', old('sender_tel', $estimate->sender_tel), ['class' => 'input' . ($errors->has('sender_tel') ? ' is-danger' : '' ), 'placeholder' => '']) !!}
                                        @if ($errors->has('sender_tel'))
                                            <p class="help is-danger">{{ $errors->first('sender_tel') }}</p>
                                        @endif
                                    </div>
                                </div>

                                <div class="field">
                                    <div class="columns">
                                        <div class="column is-6">
                                            <label class="label is-small">{{ __('db.attributes.estimate.sender_postal_code') }}</label>
                                            <div class="control">
                                                {!! Form::text('sender_postal_code', old('sender_postal_code', $estimate->sender_postal_code), ['class' => 'input' . ($errors->has('sender_postal_code') ? ' is-danger' : '' )]) !!}
                                                @if ($errors->has('sender_postal_code'))
                                                    <p class="help is-danger">{{ $errors->first('sender_postal_code') }}</p>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="column is-6">
                                        </div>
                                    </div>
                                </div>

                                <div class="field">
                                    <label class="label is-small">{{ __('db.attributes.estimate.sender_address1') }}</label>
                                    <div class="control">
                                        {!! Form::text('sender_address1', old('sender_address1', $estimate->sender_address1), ['class' => 'input' . ($errors->has('sender_address1') ? ' is-danger' : '' )]) !!}
                                        @if ($errors->has('sender_address1'))
                                            <p class="help is-danger">{{ $errors->first('sender_address1') }}</p>
                                        @endif

                                        {!! Form::text('sender_address2', old('sender_address2', $estimate->sender_address2), ['class' => 'input m-t-5' . ($errors->has('sender_address2') ? ' is-danger' : '' )]) !!}
                                        @if ($errors->has('sender_address2'))
                                            <p class="help is-danger">{{ $errors->first('sender_address2') }}</p>
                                        @endif

                                        {!! Form::text('sender_address3', old('sender_address3', $estimate->sender_address3), ['class' => 'input m-t-5' . ($errors->has('sender_address3') ? ' is-danger' : '' )]) !!}
                                        @if ($errors->has('sender_address3'))
                                            <p class="help is-danger">{{ $errors->first('sender_address3') }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <h3 class="m-t-30 item-title is-border-line">{{ __('common.tax_information') }}</h3>
                        <div class="field">
                            <div class="columns">
                                <div class="column is-6">
                                    <label class="label is-small">{{ __('db.attributes.estimate.in_tax') }}</label>
                                    <div class="control">
                                        <label class="checkbox">
                                            <input name="in_tax" type="checkbox" value="1"@if($estimate->in_tax) checked @endif>
                                            {{ __('db.attributes.estimate.in_tax') }}
                                        </label>
                                        @if ($errors->has('in_tax'))
                                            <p class="help is-danger">{{ $errors->first('in_tax') }}</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="column is-6">
                                    <label class="label is-small">{{ __('db.attributes.estimate.tax_rate') }}</label>
                                    <div class="control">
                                        <div class="select">
                                            {!!
                                                Form::select('tax_rate',
                                                    [5 => '5%', 8 => '8%'],
                                                    old('tax_rate', $estimate->tax_rate),
                                                    []
                                                )
                                            !!}
                                        </div>

                                        @if ($errors->has('tax_rate'))
                                            <p class="help is-danger">{{ $errors->first('due') }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if(count($estimate->items) > 0)
                            <h3 class="m-t-30 item-title is-border-line">{{ __('common.item_information') }}</h3>
                            <?php
                                $subtotal = 0;
                                $tax = 0;
                            ?>
                            <table id="invoice-table" class="table has-mobile-cards is-bordered is-hoverable is-dark-header">
                                <thead>
                                    <tr>
                                        <th class="has-text-centered">{{ __('db.attributes.estimate_item.name') }}</th>
                                        <th class="has-text-centered">{{ __('db.attributes.estimate_item.price') }}</th>
                                        <th class="has-text-centered">{{ __('db.attributes.estimate_item.quantity') }}</th>
                                        <th class="has-text-centered">{{ __('db.attributes.estimate_item.total') }}</th>
                                    </tr>
                                </thead>
                                <tbody class="js-drag-container">
                                    @if(!is_null(old('_token')))
                                        @foreach (old('items') as $i => $form)
                                            <?php
                                                $item = $form['id'] ? $estimate->items()->find($form['id'])->fill($form) : new \App\Models\Estimate\Item($form);
                                            ?>
                                            @if (!$form['_delete'])
                                                @include('estimate._estimate_item_table', [ 'item' => $item, 'index' => $i ])
                                                <?php
                                                    $subtotal += intval($item->price);
                                                    $tax += (floatval($item->price) * old('tax_rate', $estimate->tax_rate) / 100);
                                                ?>
                                            @endif
                                        @endforeach
                                    @else
                                        @foreach ($estimate->items as $i => $item)
                                            @include('estimate._estimate_item_table', [ 'item' => $item, 'index' => $i ])
                                            <?php
                                                $subtotal += intval($item->price);
                                                $tax += (floatval($item->price) * old('tax_rate', $estimate->tax_rate) / 100);
                                            ?>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>

                            <div class="columns prices-box">
                                <div class="column is-9">
                                    {{ link_to_add_tables(__('common.add'), 'Estimate\Item', 'estimate', [ 'class' => 'button is-outlined is-info', 'data-target' => '#estimate-table' ]) }}
                                </div>
                                <div class="column is-3">
                                    <dl>
                                        <dt>{{ __('db.attributes.estimate.subtotal') }}</dt>
                                        <dd class="js-subtotal">{{ $subtotal }}</dd>
                                        <dt>{{ __('db.attributes.estimate.tax') }}</dt>
                                        <dd class="js-tax">{{ $tax }}</dd>
                                        <dt>{{ __('db.attributes.estimate.total') }}</dt>
                                        <dd class="js-total">{{ $subtotal + $tax }}</dd>
                                　　</dl>
                                </div>
                            </div>
                        @endif

                        <div class="field">
                            <label class="label is-small">{{ __('db.attributes.estimate.remarks') }}</label>
                            <div class="control">
                                {!! Form::textarea('remarks', old('remarks', $estimate->remarks), ['class'=>'textarea', 'rows' => 4]) !!}
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
