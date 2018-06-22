@extends('layouts.pdf')

@section('content')
<div class="section">
    <div class="has-text-right m-b-20">
        <p class="m-b-0">
            {{ $invoice->date->format('Y/m/d') }}
        </p>
        <p class="m-b-0">
            No. 20180601-001
        </p>
    </div>
    <h1 class="title is-size-2 has-text-centered">{{ __('db.models.invoice') }}</h1>

    <div class="recipient-items">
        <div class="m-b-20 recipient-item is-half">
            <div>
                <p class="title is-underline m-b-30">
                    {{ $invoice->client->name }}&nbsp;御中
                </p>
                <p class="subtitle m-b-10">
                    {{ __('views.invoice.pdf.subject') }}: {{ $invoice->title }}
                </p>
            </div>

            <p class="">
                {{ __('views.invoice.pdf.please_be_advised_that_your_payment_is_listed_below') }}
            </p>
            <dl class="total-price is-clearfix m-t-10 m-b-20">
                <dt>{{ __('views.invoice.pdf.grand_total') }}</dt>
                <dd>¥ {{ number_format($invoice->total) }} - </dd>
            </dl>
            @if($invoice->due)
                <div>{{ __('views.invoice.pdf.due_date') }}: {{ $invoice->due->format('Y/m/d') }}</div>
            @endif
        </div>

        <div class="m-b-20 recipient-item is-half">
            <div class="gamma">
            </div>
            <div class="beta">
                <p class="senderName">
                    SHIEN株式会社
                </p>
                <p>
                    〒100-0005<br>
                    東京都千代田区<br>
                    丸の内2-3-2<br>
                    郵船ビルディング1階<br>

                    <br>TEL:03-5533-8670<br>
                    
                    nakamura.yuuki.0606@gmail.com
                </p>
            </div>
        </div>
    </div>

    <table width="100%" class="table is-dark-header is-bordered is-striped is-fullwidth m-t-20">
        <thead>
            <tr>
                <th class="has-text-centered">{{ __('db.attributes.invoice_item.name') }}</th>
                <th class="has-text-centered" width="13%">{{ __('db.attributes.invoice_item.quantity') }}</th>
                <th class="has-text-centered" width="12%">{{ __('db.attributes.invoice_item.price') }}</th>
                <th class="has-text-centered" width="15%">{{ __('views.invoice.pdf.price') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($invoice->items as $i => $item)
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

            @if (count($invoice->items) < 10)
                @for($i = 0; $i < (10 - count($invoice->items)); $i++)
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
                <td colspan="2">{{ __('db.attributes.invoice.subtotal') }}</td>
                <td class="has-text-right">
                    {{ number_format($invoice->subtotal) }}
                </td>
            </tr>
            <tr>
                <td class="blank"></td>
                <td colspan="2">{{ __('db.attributes.invoice.total') }}{{ $invoice->in_tax ? '(' . $invoice->tax_rate . '%)' : '' }}</td>
                <td class="has-text-right">
                    {{ number_format($invoice->tax) }}
                </td>
            </tr>
            <tr>
                <td class="blank"></td>
                <td colspan="2">{{ __('db.attributes.invoice.total') }}</td>
                <td class="has-text-right">
                    {{ number_format($invoice->total) }}
                </td>
            </tr>
        </tbody>
    </table>

    <p class="notes">
        {{ nl2br($invoice->remarks) }}
    </p>
    <div style="margin:1em 0;page-break-inside: avoid;">
        <strong>お振込先：</strong><br>
        <div>
            三井住友銀行 丸ノ内支店 (普) 7041390 シエン カブシキカイシャ
        </div>
    </div>
</div>
@endsection