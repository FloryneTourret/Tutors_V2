@extends('dashboard')

@section('content')
<h1 class="color-white">Events à venir</h1>
<div class="overview uk-child-width-1-3@s" uk-grid="masonry: true">
    @foreach($events as $item)
    <div>
        <a href="{{route('event', $item->event_id)}}">
            <div class="uk-card uk-card-default">
                <div class="uk-card-header">
                    <div class="uk-grid-small uk-flex-middle" uk-grid>
                        <div class="uk-width-expand">
                            <h3 class="uk-card-title uk-margin-remove-bottom">{{$item->titre}}</h3>
                            
                            <p class="uk-text-meta uk-margin-remove-top">
                                @if($item->login != null)
                                    {{$item->login}} en lead.
                                @else
                                    Personne en lead.
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
                <div class="uk-card-body">
                    <p>
                        @if($item->resume == null)
                            Pas de résumé.
                        @else
                            {{$item->resume}}
                        @endif
                    </p>
                </div>
                <div class="uk-card-footer uk-text-right">
                    <span class="uk-margin-small-right uk-margin-medium-left" uk-icon="heart"></span>{{$item->like_count}}
                    <span class="uk-margin-small-right uk-margin-medium-left" uk-icon="comment"></span>{{$item->comments_count}}
                    <span class="uk-margin-small-right uk-margin-medium-left" uk-icon="calendar"></span>{{$item->orga_count}}
                </div>
            </div>
        </a>
    </div>
    @endforeach

</div>
@endsection