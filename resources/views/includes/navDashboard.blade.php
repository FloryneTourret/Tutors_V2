<nav class="uk-navbar-container uk-margin" uk-navbar="mode: click">
    <div class="uk-navbar-right">

            <ul class="uk-navbar-nav">
                <li>
                    <a href="#">{{session()->get('username')}}</a>
                    <div class="uk-navbar-dropdown">
                        <ul class="uk-nav uk-navbar-dropdown-nav">
                            @if(session()->get('tutor') == true)
                                <li><a href="{{route('dashboard')}}">Dashboard</a></li>
                                <li><a href="#">Item</a></li>
                                <li class="uk-nav-divider"></li>
                            @endif
                            <li><a href="{{route('logout')}}">Déconnexion</a></li>
                        </ul>
                    </div>
                </li>
            </ul>
    
        </div>
</nav>