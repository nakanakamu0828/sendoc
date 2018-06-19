@extends('layouts.app')

@section('content')
<nav class="breadcrumb is-admin has-succeeds-separator" aria-label="breadcrumbs">
    <ul>
        <li>
            <a style="padding-left: 0.5rem;" href="{{ url('/dashboard') }}">{{ __('common.dashboard') }}</a>
        </li>
        <li class="is-active">
            <a href="#" aria-current="page">{{ __('db.models.invoice') }}</a>
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
        <form action="{{ route('invoice.search') }}" method="post" class="m-b-20">
            @csrf
            <div class="message">
                <div class="message-header">
                    <p>{{ __('common.search') }}</p>
                    <p class="control">
                        <button type="reset" class="button is-danger is-small is-rounded">
                            <i class="fas fa-sync-alt"></i> {{ __('common.reset') }}
                        </button>
                    </p>
                </div>
                <div class="message-body">
                    <div class="columns is-multiline">
                        <div class="column is-4">
                            <div class="field">
                                <label class="label is-small">{{ __('db.attributes.invoice.title') }}</label>
                                <div class="control">
                                    <input name="title" class="input" type="text" placeholder="" value="{{ old('name', (isset($condition['title']) ? $condition['title'] : null)) }}">
                                    @if ($errors->has('title'))
                                        <p class="help is-danger">{{ $errors->first('title') }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="field is-grouped is-grouped-centered">
                        <p class="control">
                            <button type="submit" class="button is-primary" style="width: 8rem;">
                                {{ __('common.search') }}
                            </button>
                        </p>
                    </div>

                </div>
            </div>
        </form>
        @include('layouts.messages')
        @if ($errors->any())
            <div class="message is-danger">
                <div class="message-body">
                    <ul>
                        @foreach($errors->getMessages() as $message)
                            <li>{{ $message[0] }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif
        <div class="is-clearfix">
            <a href="{{ route('invoice.create') }}" class="button is-info is-outlined is-rounded m-b-10 is-pulled-left">
                <span class="is-hidden-mobile">{{ __('common.register') }}</span>
                <span class="is-hidden-desktop"><i class="fas fa-plus"></i></span>
            </a>
        </div>

        @if(count($invoices))
            <table class="table has-mobile-cards is-bordered is-striped is-narrow is-hoverable is-fullwidth is-dark-header">
                <thead>
                    <tr>
                        <th>
                            <input type="checkbox" value="" data-checkboxall="selection[]" data-target="selection-form">
                        </th>
                        <th class="has-text-centered">{{ __('db.attributes.invoice.id') }}</th>
                        <th class="has-text-centered">{{ __('db.attributes.invoice.title') }}</th>
                        <th class="has-text-centered">{{ __('db.attributes.invoice.total') }}</th>
                        <th class="has-text-centered">{{ __('db.attributes.invoice.date') }}</th>
                        <th class="has-text-centered">{{ __('db.attributes.invoice.due') }}</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($invoices as $invoice)
                        <tr>
                            <td data-label="{{ __('common.selection') }}">
                                <input type="checkbox" value="{{ $invoice->id }}" name="selection[]"{{ in_array($invoice->id, $selections) ? ' checked' : '' }}>
                            </td>
                            <td data-label="{{ __('db.attributes.invoice.id') }}">{{ $invoice->id }}</td>
                            <td data-label="{{ __('db.attributes.invoice.title') }}">
                                {{ $invoice->title }}
                            </td>
                            <td data-label="{{ __('db.attributes.invoice.total') }}">
                                {{ $invoice->total }}
                            </td>
                            <td data-label="{{ __('db.attributes.invoice.date') }}" class="has-text-centered">
                                {{ $invoice->date->format('Y/m/d') }}
                            </td>
                            <td data-label="{{ __('db.attributes.invoice.due') }}" class="has-text-centered">
                                {{ $invoice->due ? $invoice->due->format('Y/m/d') : '' }}
                            </td>
                            <td class="has-text-centered">
                                <a href="{{ route('invoice.edit', [$invoice->id]) }}">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="{{ route('invoice.destroy', [$invoice->id]) }}"
                                    class="has-text-danger"
                                    data-method="delete"
                                    data-confirm="{{ __('common.delete_are_you_sure_you_want_to') }}"
                                >
                                    <i class="fas fa-times-circle"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $invoices->links('vendor.pagination.bulma') }}
        @endif
    </div>
</main>
@endsection
