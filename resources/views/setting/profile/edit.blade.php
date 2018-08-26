@extends('layouts.app')

@section('content')
<main class="section">
    <div class="container-fulid">        
        <div class="columns">
            <div class="column is-offset-4 is-4">

                <div class="box">
                    <h1 class="has-text-centered">
                        <a href="{{ url('/dashboard') }}" class="has-text-black">
                            <span class="logo">{{ __('common.setting.profile') }}</span>
                        </a>
                    </h1>
                    <form method="POST" action="{{ route('setting.profile.update') }}" class="m-t-50">
                        @csrf
                        {{ method_field('PUT') }}
                        @include('layouts.messages')

                        <div class="m-b-20" style="padding-left: 35%">
                            <figure class="image is-128x128">
                                <img class="is-rounded" src="https://bulma.io/images/placeholders/128x128.png">
                            </figure>
                        </div>

                        <div class="field">
                            <label class="label is-small">{{ __('db.attributes.user_profile.name') }}</label>
                            <div class="control">
                                <input id="input" type="text" class="input {{ $errors->has('name') ? ' is-danger' : '' }}" name="name" placeholder="" value="{{ old('name', $profile->name) }}">
                                @if ($errors->has('name'))
                                    <p class="help is-danger">{{ $errors->first('name') }}</p>
                                @endif
                            </div>
                        </div>

                        <div class="field">
                            <label class="label is-small">{{ __('db.attributes.user_profile.sex') }}</label>
                            <div class="control">
                                <div class="select">
                                    <select name="sex">
                                        @foreach($sexes as $k => $v)
                                            <option
                                                value="{{ $v }}"
                                                @if($profile->sex === $v) selected @endif
                                            >
                                                {{ __('enum.user_profile.sex.' . strtolower($k)) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @if ($errors->has('sex'))
                                    <p class="help is-danger">{{ $errors->first('sex') }}</p>
                                @endif
                            </div>
                        </div>

                        <div class="field">
                            <label class="label is-small">{{ __('db.attributes.user_profile.birthday') }}</label>
                            <div class="control">
                                <input type="date" class="input {{ $errors->has('birthday') ? ' is-danger' : '' }}" name="birthday" placeholder="" value="{{ old('birthday', $profile->birthday) }}">
                                @if ($errors->has('birthday'))
                                    <p class="help is-danger">{{ $errors->first('birthday') }}</p>
                                @endif
                            </div>
                        </div>


                        <div class="field">
                            <label class="label is-small">{{ __('db.attributes.user_profile.tel') }}</label>
                            <div class="control">
                                <input id="input" type="text" class="input {{ $errors->has('tel') ? ' is-danger' : '' }}" name="tel" placeholder="" value="{{ old('tel', $profile->tel) }}">
                                @if ($errors->has('url'))
                                    <p class="help is-danger">{{ $errors->first('tel') }}</p>
                                @endif
                            </div>
                        </div>

                        <div class="field">
                            <label class="label is-small">{{ __('db.attributes.user_profile.url') }}</label>
                            <div class="control">
                                <input id="input" type="text" class="input {{ $errors->has('url') ? ' is-danger' : '' }}" name="url" placeholder="" value="{{ old('url', $profile->url) }}">
                                @if ($errors->has('url'))
                                    <p class="help is-danger">{{ $errors->first('url') }}</p>
                                @endif
                            </div>
                        </div>


                        <div class="field m-t-30">
                            <div class="control">
                                <button type="submit" class="button is-primary is-fullwidth">
                                    {{ __('common.edit') }}
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
