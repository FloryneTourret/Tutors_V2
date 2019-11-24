@extends('dashboard')

@section('content')
@if ($exist == true && $tutor)
@if($user->login == session()->get('username'))
    <h1 class="color-white">Bonjour, {{ $user->login }}</h1>
@else
    <h1 class="color-white">Profil de {{ $user->login }}</h1>
@endif
<div class="overview" uk-grid="masonry: true">
    <div class="uk-width-3-5@s">
            
            <div class="content_overview stats_profile uk-child-width-1-2@s" uk-grid="masonry: true">
                <div class="eventsOn">
                    <div class="uk-card uk-card-default uk-card-body">
                        <p class="uk-text-uppercase color-pink"><strong class="uk-text-lead">{{count($eventsOn)}}</strong> Events en cours</p>
                        @if(count($eventsOn) > 0)
                            <ul class="uk-list uk-list-divider profile_stats">
                                @foreach ($eventsOn as $item)
                                    <li><a href="{{ route('event', ['id' => $item->event_id]) }}">{{$item->titre}}</a></li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>

                <div class="suggestions">
                    <div class="uk-card uk-card-default uk-card-body">
                        <p class="uk-text-uppercase color-pink"><strong class="uk-text-lead">{{count($suggestions)}}</strong> Suggestions</p>
                        @if(count($suggestions) > 0)
                            <ul class="uk-list uk-list-divider profile_stats">
                                @foreach ($suggestions as $item)
                                    <li><a href="{{ route('suggestion', ['id' => $item->suggestion_id]) }}">{{$item->titre}}</a></li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>

                <div class="events">
                    <div class="uk-card uk-card-default uk-card-body">
                        <p class="uk-text-uppercase color-pink"><strong class="uk-text-lead">{{count($events)}}</strong> Events</p>
                        @if(count($events) > 0)
                            <ul class="uk-list uk-list-divider profile_stats">
                                @foreach ($events as $item)
                                    <li><a href="{{ route('event', ['id' => $item->event_id]) }}">{{$item->titre}}</a></li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>

                <div class="helpSessions">
                    <div class="uk-card uk-card-default uk-card-body">
                        <p class="uk-text-uppercase color-pink"><strong class="uk-text-lead">{{count($helpSessions)}}</strong> Sessions d'aide</p>
                        @if(count($helpSessions) > 0)
                            <ul class="uk-list uk-list-divider profile_stats">
                                @foreach ($helpSessions as $item)
                                    <li><a href="{{ route('suivi', ['id' => $item->suivi_id]) }}">{{$item->login_etudiant}} : {{$item->sujet}}</a></li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
            </div>
        <!-- </div> -->
    </div>
    <div class="uk-width-expand@m">
        <div class="uk-card uk-card-default uk-card-body">
            <div class="content_overview">
                <div class="profile_picture" style="background-image: url( {{ $user->image_url }});"></div>
                <p class="uk-text-uppercase uk-text-bold text-center">
                    @if($tutor->developer == 1)
                        <span class="dev">Intra Team</span>
                    @endif {{ $user->login }}</p>
                <p class="text-center">{{ $user->email }}</p>
                <p class="text-center uk-text-italic">
                    @if($tutor->admin == 0)
                        <span>Tuteur</span>
                    @elseif($tutor->admin == 1)
                        <span>Tuteur mentor</span>
                    @else
                        <span>Admin</span>
                    @endif 
                </p>

                @if ($user->login == session()->get('username'))
                <div class="notifs text-center">
                    <span>Recevoir les notifications par email</span>
                    <br>
                    <label class="switch" for="checkbox">
                        @if($tutor->notif == 0)
                        <input type="checkbox" id="checkbox" onChange="update(this)"/>
                        @else
                        <input type="checkbox" id="checkbox" onChange="update(this)" checked />
                        @endif
                        <div class="slider round"></div>
                    </label>
                </div>  
                @endif
            </div>
        </div>
    </div>
</div>
@else
<h1 class="color-white">Utilisateur inconnu</h1>
@endif

<script>
function update(input){
    if (input.checked == true)
        axios.put('/dashboard/user/update/1')
    else
        axios.put('/dashboard/user/update/0')
}
</script>
@endsection