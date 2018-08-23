@extends('layouts.pdf')

@section('content')
<div class="section">
    <div class="has-text-right m-b-20">
        <p class="m-b-0">
            {{ $estimate->date->format('Y/m/d') }}
        </p>
        <p class="m-b-0">
            No. {{ $estimate->estimate_no }}
        </p>
    </div>
    <h1 class="title is-size-2 has-text-centered">{{ __('db.models.estimate') }}</h1>

    <div class="recipient-items">
        <div class="m-b-20 recipient-item is-half">
            <div>
                <p class="title is-underline m-b-30">
                    {{ $estimate->client->name }}&nbsp;御中
                </p>
                <p class="subtitle m-b-10">
                    {{ __('views.estimate.pdf.subject') }}: {{ $estimate->title }}
                </p>
            </div>

            <p class="">
                {{ __('views.estimate.pdf.please_be_advised_that_your_payment_is_listed_below') }}
            </p>
            <dl class="total-price is-clearfix m-t-10 m-b-20">
                <dt>{{ __('views.estimate.pdf.grand_total') }}</dt>
                <dd>¥ {{ number_format($estimate->total) }} - </dd>
            </dl>
            @if($estimate->due)
                <div>{{ __('views.estimate.pdf.due_date') }}: {{ $estimate->due->format('Y/m/d') }}</div>
            @endif
        </div>

        <div class="m-b-20 recipient-item is-half">
            <div class="gamma">
            </div>
            <div class="beta">
                <p class="senderName">
                    {{ $estimate->source->name }}{!! $estimate->source->contact_name ? '&nbsp;' . $estimate->source->contact_name : '' !!}
                </p>
                <p>
                    <?php
                        $address = $estimate->source->printFullAddress('<br>');
                    ?>
                    {!! $address ? sprintf('<br>%s', $address) : '' !!}
                    {!! $estimate->source->tel ? sprintf('<br>TEL: %s', $estimate->source->tel) : '' !!}
                    {!! $estimate->source->email ? sprintf('<br>Email: %s', $estimate->source->email) : '' !!}
                </p>
            </div>
        </div>
    </div>

    <table width="100%" class="table is-dark-header is-bordered is-striped is-fullwidth m-t-20">
        <thead>
            <tr>
                <th class="has-text-centered">{{ __('db.attributes.estimate_item.name') }}</th>
                <th class="has-text-centered" width="13%">{{ __('db.attributes.estimate_item.quantity') }}</th>
                <th class="has-text-centered" width="12%">{{ __('db.attributes.estimate_item.price') }}</th>
                <th class="has-text-centered" width="15%">{{ __('views.estimate_item.pdf.price') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($estimate->items as $i => $item)
                <tr>
                    <td>
                        {{ $item->name }}
                    </td>
                    <td class="has-text-right">
                        {{ number_format($item->quantity) }}
                    </td>
                    <td class="has-text-right">
                        {{ number_format($item->price) }}
                    </td>
                    <td class="has-text-right">
                        &nbsp;
                        {{ number_format($item->price * $item->quantity) }}
                    </td>
                </tr>
            @endforeach

            @if (count($estimate->items) < 10)
                @for($i = 0; $i < (10 - count($estimate->items)); $i++)
                    <tr>
                        <td>
                            &nbsp;
                        </td>
                        <td class="has-text-right">
                        </td>
                        <td class="has-text-right">
                        </td>
                        <td class="has-text-right">
                        </td>
                    </tr>
                @endfor
            @endif
            <tr>
                <td class="blank"></td>
                <td colspan="2">{{ __('db.attributes.estimate.subtotal') }}</td>
                <td class="has-text-right">
                    {{ number_format($estimate->subtotal) }}
                </td>
            </tr>
            <tr>
                <td class="blank"></td>
                <td colspan="2">{{ __('db.attributes.estimate.total') }}{{ $estimate->in_tax ? '(' . $estimate->tax_rate . '%)' : '' }}</td>
                <td class="has-text-right">
                    {{ number_format($estimate->tax) }}
                </td>
            </tr>
            <tr>
                <td class="blank"></td>
                <td colspan="2">{{ __('db.attributes.estimate.total') }}</td>
                <td class="has-text-right">
                    {{ number_format($estimate->total) }}
                </td>
            </tr>
        </tbody>
    </table>

    <p class="notes">
        {{ nl2br($estimate->remarks) }}
    </p>

    @if(count($estimate->source->payees))
        <div style="margin:1em 0;page-break-inside: avoid;">
            <strong>{{ __('db.models.payee') }}</strong><br>
            @foreach ($estimate->source->payees as $payee)
                <div>
                    {{ $payee->detail }}
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection