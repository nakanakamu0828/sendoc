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
        @if(Auth::user()->selectedMember()->isAdmin())
            <a href="{{ url('/member/create') }}" class="button is-info is-outlined is-rounded m-b-10">{{ __('common.register') }}</a>
            <a href="#" class="button is-success is-rounded m-b-10" data-toggle="modal" data-targetid="invitation-modal">{{ __('common.invitation') }}</a>
        @endif
        @if(count($members))
            <table class="table has-mobile-cards is-bordered is-striped is-narrow is-hoverable is-fullwidth is-dark-header">
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
            {{ $members->appends(request()->input())->links('vendor.pagination.bulma') }}
        @endif
    </div>
</main>


<div id="invitation-modal" class="modal @if(session('invitation_link') OR isset($invitation_link) OR $errors->has('emails')) is-active @endif">
  <div class="modal-background"></div>
  <div class="modal-content">
    <div class="box">
        <h3 class="logo is-size-5 has-text-centered m-b-30">
            {{ __('views.member.index.invite_members_to', [ 'name' => Auth::user()->selectedOrganization()->name ]) }}
        </h3>
        @if(session('invitation_link') OR isset($invitation_link))
            <div class="field has-addons">
                <div class="control is-expanded">
                    <input id="invitation-url" type="text" class="input" name="name" placeholder="" value="{{ session('invitation_link') ? session('invitation_link') : $invitation_link }}" readonly>
                </div>
                <div class="control">
                    <a class="button is-primary js-clipboard" data-tooltip="{{ __('common.copied') }}" data-clipboard-target="#invitation-url">
                        {{ __('common.copy') }}
                    </a>
                </div>
            </div>
        @else
            <h4 class="logo is-size-6 m-b-10">
                招待リンクを作成
            </h4>
            <form method="POST" action="{{ route('member.invitation.link.store') }}">
                @csrf
                <div class="field has-addons">
                    <div class="control is-expanded">
                        <div class="select is-fullwidth">
                        <select name="expire">
                            @foreach([1, 7, 30] as $i)
                            <option value="{{ $i }}">{{ __('common.expires_in_days', [ 'day' => $i ]) }}</option>
                            @endforeach
                        </select>
                        </div>
                    </div>
                    <div class="control">
                        <button type="submit" class="button is-primary">
                            {{ __('common.create_invite_link') }}
                        </button>
                    </div>
                </div>
            </form>


            <h4 class="logo is-size-6 m-t-30 m-b-10">
                メールで招待
            </h4>
            <form method="POST" action="{{ route('member.invitation.email.store') }}">
                @csrf
                <div class="field">
                    <div class="control">
                        <textarea name="emails" class="textarea{{ $errors->has('emails') ? ' is-danger' : ''  }}">{{ old('emails') }}</textarea>
                        @if ($errors->has('emails'))
                            <p class="help is-danger">{{ $errors->first('emails') }}</p>
                        @endif
                    </div>
                </div>
                <div class="field">
                    <div class="control">
                        <button type="submit" class="button is-primary">
                            {{ __('common.invitation') }}
                        </button>
                    </div>
                </div>
            </form>
        @endif
    </div>
  </div>
  <button class="modal-close is-large" aria-label="close"></button>
</div>
@endsection
