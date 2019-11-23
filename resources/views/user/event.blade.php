@extends('dashboard')

@section('content')
    @if(isset($error))
        {{$error}}
    @else
       
        <h1 class="color-white">{{$event->titre}}</h1>
        <div class="overview" uk-grid="masonry: true">
            <div class="uk-width-3-5@s">
                <div class="uk-card uk-card-default">
                    <div class="uk-card-body">
                        <div class="uk-grid-small uk-flex-middle" uk-grid>
                            <div class="uk-width-expand">
                                <div class="uk-card-badge uk-label">{{$event->nb_tuteurs}} tuteur(s)</div>
                                <p class="uk-text-meta uk-margin-remove-top">
                                    <span class="uk-margin-small-right" uk-icon="future"></span>
                                    Du {{ date('d/m/Y', strtotime($event->date_debut)) }}
                                    au {{ date('d/m/Y', strtotime($event->date_fin)) }}
                                </p>
                            </div>
                        </div>
                        <p>{!!nl2br(e($event->description))!!}</p>
                        <hr class="uk-divider-icon">
                        <p>{!!nl2br(e($event->missions))!!}</p>
                        <div class="uk-text-right">
                            <span class="uk-margin-small-right uk-margin-medium-left" uk-icon="heart"></span>{{count($likes)}}
                            <span style="display: none">
                                @foreach($likes as $item)
                                    {{$item->login}}
                                @endforeach
                            </span>
                            <span class="uk-margin-small-right uk-margin-medium-left" uk-icon="comment"></span>{{count($comments)}}
                            <span class="uk-margin-small-right uk-margin-medium-left" uk-icon="calendar"></span>{{count($orga)}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="uk-width-expand@s">
                <div class="uk-card uk-card-default">
                    <div class="uk-card-body">
                        <div class="uk-grid-small uk-flex-middle" uk-grid>
                            <div class="uk-width-expand">
                                <p class="uk-text-meta uk-margin-remove-top uk-text-uppercase">
                                    <span class="uk-margin-small-right" uk-icon="user"></span>
                                    Lead
                                </p>
                            </div>
                        </div>
                        @if(count($lead) > 0)
                            <ul class="uk-list uk-list-divider users">
                                @foreach ($lead as $item)
                                    <li><a href="/dashboard/user/{{$item->login}}">{{$item->login}}</a></li>
                                @endforeach
                            </ul>
                        @else
                            <p>Personne en lead</p>
                        @endif
                        <hr class="uk-divider-icon">
                        <div class="uk-grid-small uk-flex-middle" uk-grid>
                            <div class="uk-width-expand">
                                <p class="uk-text-meta uk-margin-remove-top uk-text-uppercase">
                                    <span class="uk-margin-small-right" uk-icon="users"></span>
                                    Participants
                                </p>
                            </div>
                        </div>
                        @if(count($contributors) > 0)
                            <ul class="uk-list uk-list-divider users">
                                @foreach ($contributors as $item)
                                    <li><a href="/dashboard/user/{{$item->login}}">{{$item->login}}</a></li>
                                @endforeach
                            </ul>
                        @else
                            <p>Personne en lead</p>
                        @endif
                    </div>
                </div>
            </div>
            <div class="uk-width-3-5@s">
                <div id="comments">
                    @foreach($comments as $item)
                    <div class="uk-margin-bottom">
                        <article class="uk-comment uk-comment-primary">
                            <header class="uk-comment-header uk-grid-medium uk-flex-middle" uk-grid>
                                <div class="uk-width-expand">
                                    <p class="uk-comment-title uk-margin-remove"><a class="uk-link-reset" href="#">{{$item->login}}</a></p>
                                    <ul class="uk-comment-meta uk-subnav uk-subnav-divider uk-margin-remove-top">
                                        <li><a href="#">{{$item->commentaire_date}}</a></li>
                                    </ul>
                                </div>
                            </header>
                            <div class="uk-comment-body">
                                <p>{{$item->commentaire}}</p>
                            </div>
                        </article>
                    </div>
                    @endforeach
                </div>
                <div id="orga">
                    @foreach($orga as $item)
                    <div class="uk-margin-bottom">
                        <article class="uk-comment uk-comment-primary">
                            <header class="uk-comment-header uk-grid-medium uk-flex-middle" uk-grid>
                                <div class="uk-width-expand">
                                    <p class="uk-comment-title uk-margin-remove"><a class="uk-link-reset" href="/dashboard/user/{{$item->login}}">{{$item->login}}</a></p>
                                    <ul class="uk-comment-meta uk-subnav uk-subnav-divider uk-margin-remove-top">
                                        <li><a href="#">{{$item->commentaire_date}}</a></li>
                                    </ul>
                                </div>
                            </header>
                            <div class="uk-comment-body">
                                <p>{{$item->commentaire}}</p>
                            </div>
                        </article>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
@endsection