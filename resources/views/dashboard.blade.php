@extends('layouts.app')

@section('content')
<section class="hero is-dark is-desktop-border-left is-small">
    <div class="hero-body">
        <div class="container-fulid">
            <h1 class="title">
                {{ __('common.dashboard') }}
            </h1>
            <h2 class="subtitle">
            </h2>
        </div>
    </div>
</section>
<main class="section">
    <div class="container-fulid">
        @include('layouts.messages')
        <div>
            <a href="{{ route('invoice.create') }}" class="button is-primary">
                <i class="fas fa-pencil-alt"></i>&nbsp;
                {{ __('common.create_a_item', [ 'item' => __('db.models.invoice') ]) }}
            </a>
        </div>
    </div>
</main>
@endsection
