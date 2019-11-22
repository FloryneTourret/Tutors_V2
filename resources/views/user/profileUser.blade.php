@extends('dashboard')

@section('content')
@if ($exist == true)
<h1 class="color-white">Bonjour {{ $user->login }}</h1>
<div class="overview" uk-grid="masonry: true">
    <div class="uk-width-3-5@s">
        <div class="uk-card uk-card-default uk-card-body">
            <small class="uk-text-uppercase uk-text-muted"><span class="uk-margin-small-right" uk-icon="icon: database"></span>Statistiques</small>
            <div class="content_overview">
                Statistiques user
            </div>
        </div>
    </div>
    <div class="uk-width-expand@m">
        <div class="uk-card uk-card-default uk-card-body">
            <div class="content_overview">
                <div class="profile_picture" style="background-image: url( {{ $user->image_url }});"></div>
                <p class="uk-text-uppercase uk-text-bold text-center">{{ $user->login }}</p>
                <p class="text-center">{{ $user->email }}</p>
                <p>Rôle</p>
                @if ($user->login == session()->get('username'))
                    <span>Notifications par email</span>
                @endif
            </div>
        </div>
    </div>
</div>
@else
<h1 class="color-white">Utilisateur inconnu</h1>
@endif

@endsection