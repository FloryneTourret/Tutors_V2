<nav class="uk-navbar-container uk-margin" uk-navbar="mode: click">
    <div class="uk-navbar-left">
        <ul class="uk-navbar-nav">
            <li class="uk-active"><a href="{{route('home')}}"><span class="uk-margin-small-right" uk-icon="icon: home"></span>Accueil</a></li>
            <li><a href="#"><span class="uk-margin-small-right" uk-icon="icon: bolt"></span>Boite à suggestions</a></li>
        </ul>
    </div>
    <div class="uk-navbar-right">

            <ul class="uk-navbar-nav">
                <li>
                    <a href="#">
                        <div class="avatar" style="background-image: url( {{json_decode(session()->get('user'))->image_url}});"></div>
                        {{session()->get('username')}}
                    </a>
                    <div class="uk-navbar-dropdown">
                        <ul class="uk-nav uk-navbar-dropdown-nav">
                            @if(session()->get('tutor') == true)
                                <li><a href="{{route('dashboard')}}"><span class="uk-margin-small-right" uk-icon="icon: grid"></span>Dashboard</a></li>
                                <li><a href="#"><span class="uk-margin-small-right" uk-icon="icon: user"></span>Mon profil</a></li>
                                <li class="uk-nav-divider"></li>
                            @endif
                            <li><a href="{{route('logout')}}"><span class="uk-margin-small-right" uk-icon="icon: sign-out"></span>Déconnexion</a></li>
                        </ul>
                    </div>
                </li>
            </ul>
    
        </div>
</nav>