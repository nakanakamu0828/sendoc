@extends('layouts.app')

@section('content')
<nav class="breadcrumb is-admin has-succeeds-separator" aria-label="breadcrumbs">
    <ul>
        <li>
            <a style="padding-left: 0.5rem;" href="{{ url('/dashboard') }}">{{ __('common.dashboard') }}</a>
        </li>
        <li class="is-active">
            <a href="#" aria-current="page">{{ __('db.models.member') }}</a>
        </li>
    </ul>
</nav>
<section class="hero is-dark is-desktop-border-left is-small">
    <div class="hero-body">
        <div class="container-fulid">
            <h1 class="title">
                {{ __('db.models.member') }}
            </h1>
            <h2 class="subtitle">
            </h2>
        </div>
    </div>
</section>
<main class="section">
    <div class="container-fulid">
        @include('layouts.messages')
        <a href="{{ url('/member/create') }}" class="button is-info is-outlined is-rounded m-b-10">{{ __('common.register') }}</a>
        @if(count($members))
            <table class="table has-mobile-cards is-bordered is-striped is-narrow is-hoverable is-fullwidth">
                <thead>
                    <tr>
                        <th>{{ __('db.attributes.member.id') }}</th>
                        <th>{{ __('db.attributes.user.name') }}</th>
                        <th>{{ __('db.attributes.user.email') }}</th>
                        <th>{{ __('db.attributes.member.role') }}</th>
                        <th>{{ __('db.attributes.member.created_at') }}</th>
                        @if(Auth::user()->selectedMember()->isAdmin())
                            <th></th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach($members as $member)
                        <tr>
                            <td data-label="{{ __('db.attributes.member.id') }}">{{ $member->id }}</td>
                            <td data-label="{{ __('db.attributes.user.name') }}">
                                {{ $member->user->name }}
                            </td>
                            <td data-label="{{ __('db.attributes.user.email') }}">
                                {{ $member->user->email }}
                            </td>
                            <td data-label="{{ __('db.attributes.member.role') }}" class="has-text-centered">
                                <span class="tag is-{{ $member->role }}">{{ $member->role }}</span>
                            </td>
                            <td data-label="{{ __('db.attributes.member.created_at') }}">
                                {{ $member->user->created_at->format('Y/m/d H:i:s')  }}
                            </td>
                            @if(Auth::user()->selectedMember()->isAdmin())
                                <td class="has-text-centered">
                                    @if($member->isAdmin())
                                        -
                                    @else
                                        <a href="{{ route('member.destroy', [$member->id]) }}"
                                            class="has-text-danger"
                                            data-method="delete"
                                            data-confirm="{{ __('common.delete_are_you_sure_you_want_to') }}"
                                        >
                                            <i class="fas fa-times-circle"></i>
                                        </a>
                                    @endif
                                </td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $members->links('vendor.pagination.bulma') }}
        @endif
    </div>
</main>
@endsection
