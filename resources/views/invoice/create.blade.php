@extends('layouts.app')

@section('content')
<nav class="breadcrumb is-admin has-succeeds-separator" aria-label="breadcrumbs">
    <ul>
        <li>
            <a style="padding-left: 0.5rem;" href="{{ url('/dashboard') }}">{{ __('common.dashboard') }}</a>
        </li>
        <li>
            <a style="padding-left: 0.5rem;" href="{{ route('invoice.index') }}">{{ __('db.models.invoice') }}</a>
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
                {{ __('db.models.invoice') }}
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
                    <form method="POST" action="{{ route('invoice.store') }}">
                        @csrf

                        <h3 class="m-t-20 item-title is-border-line">{{ __('common.invoice_information') }}</h3>
                        <div class="field">
                            <label class="label is-small">{{ __('db.attributes.invoice.title') }}</label>
                            <div class="control">
                                {!! Form::text('title', old('title', $invoice->title), ['class' => 'input' . ($errors->has('title') ? ' is-danger' : '' ), 'placeholder' => __('db.attributes.invoice.title')]) !!}
                                @if ($errors->has('title'))
                                    <p class="help is-danger">{{ $errors->first('title') }}</p>
                                @endif
                            </div>
                        </div>

                        <div class="field">
                            <div class="columns">
                                <div class="column is-6 p-b-0">
                                    <label class="label is-small">{{ __('db.attributes.invoice.client_id') }}</label>
                                    <div class="control">
                                        <div class="select">
                                            {!!
                                                Form::select('client_id',
                                                    ['' => __('common.choose_a_select_tag')] + $clientOptions->toArray(),
                                                    old('client_id', $invoice->client_id),
                                                    []
                                                )
                                            !!}
                                        </div>
                                        @if ($errors->has('client_id'))
                                            <p class="help is-danger">{{ $errors->first('client_id') }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="field">
                            <div class="columns">
                                <div class="column is-6 p-b-0">
                                    <label class="label is-small">{{ __('db.attributes.invoice.date') }}</label>
                                    <div class="control">
                                        {!! Form::date('date', old('date', $invoice->date), ['class' => 'input' . ($errors->has('date') ? ' is-danger' : '' )]) !!}
                                        @if ($errors->has('date'))
                                            <p class="help is-danger">{{ $errors->first('date') }}</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="column is-6 p-b-0">
                                    <label class="label is-small">{{ __('db.attributes.invoice.due') }}</label>
                                    <div class="control">
                                        {!! Form::date('due', old('due', $invoice->due), ['class' => 'input' . ($errors->has('due') ? ' is-danger' : '' )]) !!}
                                        @if ($errors->has('due'))
                                            <p class="help is-danger">{{ $errors->first('due') }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <h3 class="m-t-30 item-title is-border-line">{{ __('common.tax_information') }}</h3>
                        <div class="field">
                            <div class="columns">
                                <div class="column is-6">
                                    <label class="label is-small">{{ __('db.attributes.invoice.in_tax') }}</label>
                                    <div class="control">
                                        <label class="checkbox">
                                            <input name="in_tax" type="checkbox"@if($invoice->in_tax) checked @endif>
                                            {{ __('db.attributes.invoice.in_tax') }}
                                        </label>
                                        @if ($errors->has('in_tax'))
                                            <p class="help is-danger">{{ $errors->first('in_tax') }}</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="column is-6">
                                    <label class="label is-small">{{ __('db.attributes.invoice.tax_rate') }}</label>
                                    <div class="control">
                                        <div class="select">
                                            {!!
                                                Form::select('tax_rate',
                                                    [5 => '5%', 8 => '8%'],
                                                    old('tax_rate', $invoice->tax_rate),
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

                        @if(count($invoice->items) > 0)
                            <h3 class="m-t-30 item-title is-border-line">{{ __('common.item_information') }}</h3>
                            <?php
                                $subtotal = 0;
                                $tax = 0;
                            ?>
                            <table id="invoice-table" class="table has-mobile-cards is-bordered is-hoverable is-dark-header">
                                <thead>
                                    <tr>
                                        <th class="has-text-centered">{{ __('db.attributes.invoice_item.name') }}</th>
                                        <th class="has-text-centered">{{ __('db.attributes.invoice_item.price') }}</th>
                                        <th class="has-text-centered">{{ __('db.attributes.invoice_item.quantity') }}</th>
                                        <th class="has-text-centered">{{ __('db.attributes.invoice_item.total') }}</th>
                                    </tr>
                                </thead>
                                <tbody class="js-drag-container">
                                    @if(!is_null(old('_token')))
                                        @foreach (old('items') as $i => $form)
                                            <?php
                                                $item = $form['id'] ? $invoice->items()->find($form['id'])->fill($form) : new \App\Models\Invoice\Item($form);
                                            ?>
                                            @if (!$form['_delete'])
                                                @include('invoice._invoice_item_table', [ 'item' => $item, 'index' => $i ])
                                                <?php
                                                    $subtotal += intval($item->price);
                                                    $tax += (floatval($item->price) * old('tax_rate', $invoice->tax_rate) / 100);
                                                ?>
                                            @endif
                                        @endforeach
                                    @else
                                        @foreach ($invoice->items as $i => $item)
                                            @include('invoice._invoice_item_table', [ 'item' => $item, 'index' => $i ])
                                            <?php
                                                $subtotal += intval($item->price);
                                                $tax += (floatval($item->price) * old('tax_rate', $invoice->tax_rate) / 100);
                                            ?>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>

                            <div class="columns prices-box">
                                <div class="column is-9">
                                    {{ link_to_add_tables(__('common.add'), 'Invoice\Item', 'invoice', [ 'class' => 'button is-outlined is-info', 'data-target' => '#invoice-table' ]) }}
                                </div>
                                <div class="column is-3">
                                    <dl>
                                    <dt>小計</dt>
                                        <dd class="js-subtotal">{{ $subtotal }}</dd>
                                        <dt>消費税</dt>
                                        <dd class="js-tax">{{ $tax }}</dd>
                                        <dt>合計</dt>
                                        <dd class="js-total">{{ $subtotal + $tax }}</dd>
                                　　</dl>
                                </div>
                            </div>
                        @endif

                        <div class="field">
                            <label class="label is-small">{{ __('db.attributes.invoice.remarks') }}</label>
                            <div class="control">
                                {!! Form::textarea('remarks', old('remarks', $invoice->remarks), ['class'=>'textarea', 'rows' => 4]) !!}
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
