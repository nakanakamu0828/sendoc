@extends('layouts.app')

@section('content')
<nav class="breadcrumb is-admin has-succeeds-separator" aria-label="breadcrumbs">
    <ul>
        <li>
            <a style="padding-left: 0.5rem;" href="{{ url('/dashboard') }}">{{ __('common.dashboard') }}</a>
        </li>
        <li class="is-active">
            <a href="#" aria-current="page">{{ __('db.models.client') }}</a>
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
        <form action="{{ route('client.search') }}" method="post" class="m-b-20">
            @csrf
            <div class="message">
                <div class="message-header">
                    <p>{{ __('common.search') }}</p>
                </div>
                <div class="message-body">
                    <div class="columns is-multiline">
                        <div class="column is-4">
                            <div class="field">
                                <label class="label is-small">{{ __('db.attributes.client.name') }}</label>
                                <div class="control">
                                    <input name="name" class="input" type="text" placeholder="" value="{{ old('name', (isset($condition['name']) ? $condition['name'] : null)) }}">
                                    @if ($errors->has('name'))
                                        <p class="help is-danger">{{ $errors->first('name') }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="column is-4">
                            <div class="field">
                                <label class="label is-small">{{ __('db.attributes.client.email') }}</label>
                                <div class="control">
                                    <input name="email" class="input" type="text" placeholder="" value="{{ old('email', (isset($condition['email']) ? $condition['email'] : null)) }}">
                                    @if ($errors->has('email'))
                                        <p class="help is-danger">{{ $errors->first('email') }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="column is-4">
                            <div class="field">
                                <label class="label is-small">{{ __('db.attributes.client.contact_name') }}</label>
                                <div class="control">
                                    <input name="contact_name" class="input" type="text" placeholder="" value="{{ old('contact_name', (isset($condition['contact_name']) ? $condition['contact_name'] : null)) }}">
                                    @if ($errors->has('contact_name'))
                                        <p class="help is-danger">{{ $errors->first('contact_name') }}</p>
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
                        <p class="control">
                            <button type="reset" class="button" style="width: 8rem;">
                                {{ __('common.reset') }}
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
            <a href="{{ route('client.create') }}" class="button is-info is-outlined is-rounded m-b-10 is-pulled-left">
                <span class="is-hidden-mobile">{{ __('common.register') }}</span>
                <span class="is-hidden-desktop"><i class="fas fa-plus"></i></span>
            </a>
            <form action="{{ route('client.csv.upload') }}" method="post" class="is-pulled-left" enctype="multipart/form-data">
                @csrf
                <div class="file is-primary m-l-5">
                    <label class="file-label">
                        <input class="file-input js-auto-submit" type="file" name="file" accept=".csv">
                        <span class="file-cta">
                            <span class="file-icon m-r-0">
                                <i class="fas fa-upload"></i>
                            </span>
                            <span class="file-label m-l-5 is-hidden-mobile">
                                {{ __('common.upload_csv') }}
                            </span>
                        </span>
                    </label>
                </div>
            </form>
        </div>
        <p class="is-size-7 m-b-5">
            {{ __('views.client.index.help_upload') }}
        </p>
        <p class="is-size-7 m-b-5">
            {{ __('views.client.index.help_csv_charactor') }}
        </p>
        <p class="is-size-7 m-b-20">
            <a href="{{ route('client.csv.download.sample') }}">{{ __('views.client.index.help_download_sample') }}</a>
        </p>
        @if(count($clients))
            <form id="selection-form" action="{{ route('client.selection') }}" method="post">
                @csrf
                <table class="table has-mobile-cards is-bordered is-striped is-narrow is-hoverable is-fullwidth">
                    <thead>
                        <tr>
                            <th>
                                <input type="checkbox" value="" data-checkboxall="selection[]" data-target="selection-form">
                            </th>
                            <th>{{ __('db.attributes.client.id') }}</th>
                            <th>{{ __('db.attributes.client.name') }}</th>
                            <th>{{ __('db.attributes.client.contact_name') }}</th>
                            <th>{{ __('db.attributes.client.email') }}</th>
                            <th>{{ __('db.attributes.client.user') }}</th>
                            <th class="has-text-centered">{{ __('db.attributes.client.client_type') }}</th>
                            <th>{{ __('db.attributes.client.created_at') }}</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($clients as $client)
                            <tr>
                                <td data-label="{{ __('common.selection') }}">
                                    <input type="checkbox" value="{{ $client->id }}" name="selection[]"{{ in_array($client->id, $selections) ? ' checked' : '' }}>
                                </td>
                                <td data-label="{{ __('db.attributes.client.id') }}">{{ $client->id }}</td>
                                <td data-label="{{ __('db.attributes.client.name') }}">
                                    {{ $client->name }}
                                </td>
                                <td data-label="{{ __('db.attributes.client.contact_name') }}">
                                    {{ $client->contact_name }}
                                </td>
                                <td data-label="{{ __('db.attributes.client.email') }}">
                                    {{ $client->email }}
                                </td>
                                <td data-label="{{ __('db.attributes.client.user') }}">
                                    @if($client->user)
                                        {{ $client->user->name }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="has-text-centered" data-label="{{ __('db.attributes.client.client_type') }}">
                                    <span class="tag is-client__client-type__{{ $client->client_type }}">{{ __('db.enums.client.client_type.' . $client->client_type) }}</span>
                                </td>
                                <td data-label="{{ __('db.attributes.client.created_at') }}">
                                    {{ $client->created_at->format('Y/m/d H:i:s')  }}
                                </td>
                                <td class="has-text-centered">
                                    <a href="{{ route('client.edit', [$client->id]) }}">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="{{ route('client.destroy', [$client->id]) }}"
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
                {{ $clients->links('vendor.pagination.bulma') }}
            </form>
        @endif
    </div>
</main>
@endsection
