@extends('layouts.app')

@section('content')
<nav class="breadcrumb is-admin has-succeeds-separator" aria-label="breadcrumbs">
    <ul>
        <li>
            <a style="padding-left: 0.5rem;" href="{{ url('/dashboard') }}">{{ __('common.dashboard') }}</a>
        </li>
        <li class="is-active">
            <a href="#" aria-current="page">{{ __('db.models.source') }}</a>
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
        <form action="{{ route('source.search') }}" method="post" class="m-b-20">
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
                                <label class="label is-small">{{ __('db.attributes.source.name') }}</label>
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
                                <label class="label is-small">{{ __('db.attributes.source.email') }}</label>
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
                                <label class="label is-small">{{ __('db.attributes.source.contact_name') }}</label>
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
            <a href="{{ route('source.create') }}" class="button is-info is-outlined is-rounded m-b-10 is-pulled-left">
                <span class="is-hidden-mobile">{{ __('common.register') }}</span>
                <span class="is-hidden-desktop"><i class="fas fa-plus"></i></span>
            </a>
        </div>
        @if(count($sources))
            <table class="table has-mobile-cards is-bordered is-striped is-narrow is-hoverable is-fullwidth is-dark-header">
                <thead>
                    <tr>
                        <th>{{ __('db.attributes.source.id') }}</th>
                        <th>{{ __('db.attributes.source.name') }}</th>
                        <th>{{ __('db.attributes.source.contact_name') }}</th>
                        <th>{{ __('db.attributes.source.email') }}</th>
                        <th>{{ __('db.attributes.source.address1') }}</th>
                        <th>{{ __('db.attributes.source.created_at') }}</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sources as $source)
                        <tr>
                            <td data-label="{{ __('db.attributes.source.id') }}">{{ $source->id }}</td>
                            <td data-label="{{ __('db.attributes.source.name') }}">
                                {{ $source->name }}
                            </td>
                            <td data-label="{{ __('db.attributes.source.contact_name') }}">
                                {{ $source->contact_name }}
                            </td>
                            <td data-label="{{ __('db.attributes.source.email') }}">
                                {{ $source->email }}
                            </td>
                            <td data-label="{{ __('db.attributes.source.address1') }}">
                                {{ $source->address1 }}{!! $source->address2 ? '<br>' . $source->address2 : '' !!}{!! $source->address3 ? '<br>' . $source->address3 : '' !!}
                            </td>
                            <td data-label="{{ __('db.attributes.source.created_at') }}">
                                {{ $source->created_at->format('Y/m/d H:i:s')  }}
                            </td>
                            <td>
                                <div class="dropdown is-right">
                                    <div class="dropdown-trigger">
                                        <button class="button is-default is-small" dropdown="true">
                                            <span>{{ __('common.menu') }}</span>
                                            <span class="icon is-small">
                                                <i class="fas fa-angle-down" aria-hidden="true"></i>
                                            </span>
                                        </button>
                                    </div>
                                    <div class="dropdown-menu">
                                        <div class="dropdown-content">
                                            <a href="{{ route('source.edit', [$source->id]) }}" class="dropdown-item">
                                                <i class="fas fa-edit"></i> {{ __('common.edit') }}
                                            </a>
                                            <a href="{{ route('source.destroy', [$source->id]) }}"
                                                class="dropdown-item"
                                                data-method="delete"
                                                data-confirm="{{ __('common.delete_are_you_sure_you_want_to') }}"
                                            >
                                                <i class="has-text-danger fas fa-times-circle"></i> {{ __('common.delete') }}
                                            </a>

                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $sources->links('vendor.pagination.bulma') }}
        @endif
    </div>
</main>
@endsection
