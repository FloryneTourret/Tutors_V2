@extends('dashboard')

@section('content')
@if ($exist == true && $tutor)
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
                    <form>
                        @method('PUT')
                        @csrf
                        <label class="switch" for="checkbox">
                            @if($tutor->notif == 0)
                            <input type="checkbox" id="checkbox" onChange="update(this)"/>
                            @else
                            <input type="checkbox" id="checkbox" onChange="update(this)" checked />
                            @endif
                            <div class="slider round"></div>
                        </label>
                    </form>
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