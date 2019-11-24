@extends('dashboard')

@section('content')
	<div class="uk-child-width-expand@s stats" uk-grid>
		<div>
			<div class="uk-card uk-card-small uk-card-body">
				<small class="uk-text-uppercase uk-text-muted"><span class="uk-margin-small-right" uk-icon="icon: calendar"></span>Events en cours</small>
				<p class="color-lightpink uk-text-bold value">
					{{(count($myEventsOn))}}
				</p>
			</div>
		</div>
		<div>
			<div class="uk-card uk-card-small uk-card-body">
				<small class="uk-text-uppercase uk-text-muted"><span class="uk-margin-small-right" uk-icon="icon: calendar"></span>Events</small>
				<p class="color-lightpink uk-text-bold value">
					{{(count($myEvents))}}
				</p>
			</div>
		</div>
		<div>
			<div class="uk-card uk-card-small uk-card-body">
				<small class="uk-text-uppercase uk-text-muted"><span class="uk-margin-small-right" uk-icon="icon: future"></span>Suggestions</small>
				<p class="color-lightpink uk-text-bold value">
					{{(count($mySuggestions))}}
				</p>
			</div>
		</div>
		<div>
			<div class="uk-card uk-card-small uk-card-body">
				<small class="uk-text-uppercase uk-text-muted"><span class="uk-margin-small-right" uk-icon="icon: users"></span>Sessions d'aide</small>
				<p class="color-lightpink uk-text-bold value">
					{{(count($myHelpSessions))}}
				</p>
			</div>
		</div>
	</div>

	<div class="overview" uk-grid="masonry: true">
		<div class="uk-width-2-3@s">
			<div class="uk-card uk-card-default uk-card-body">
				<small class="uk-text-uppercase uk-text-muted"><span class="uk-margin-small-right" uk-icon="icon: bell"></span>Nouveautés</small>
				<div class="content_overview">
					<ul class="uk-list uk-list-divider">
						<li class="uk-nav-header">Suggestions</li>
						@foreach ($lastSuggestions as $item)
							<li><a href="{{ route('suggestion', ['id' => $item->suggestion_id]) }}">{{$item->titre}}</a></li>
						@endforeach

						<li class="uk-nav-header">Events</li>
						@foreach ($lastEvents as $item)
							<li><a href="{{ route('event', ['id' => $item->event_id]) }}">{{$item->titre}}</a></li>
						@endforeach
					</ul>
				</div>
			</div>
		</div>
		<div class="uk-width-expand@m">
			<div class="uk-card uk-card-default uk-card-body">
				<small class="uk-text-uppercase uk-text-muted"><span class="uk-margin-small-right" uk-icon="icon: users"></span>Sessions d'aide en cours</small>
				<div class="content_overview">
					<ul class="uk-list uk-list-divider">
						@if(count($myHelpSessionsOn) > 0)
							@foreach ($myHelpSessionsOn as $item)
								<li>
									<a href="{{ route('suivi', ['id' => $item->suivi_id]) }}">
										<div class="uk-grid-small uk-flex-middle" uk-grid>
											<div class="uk-width-expand">
												<p class="uk-text-lead uk-margin-remove-bottom">{{$item->login_etudiant}}</p>
												<p class="uk-text-meta uk-margin-remove-top">{{$item->login}}</p>
											</div>
										</div>
									</a>
								</li>
							@endforeach
						@else
							<li>Aucune session d'aide en cours</li>
						@endif
					</ul>

				</div>
			</div>
		</div>
		<div class="uk-width-2-3@s">
			<div class="uk-card uk-card-default uk-card-body">
				<small class="uk-text-uppercase uk-text-muted"><span class="uk-margin-small-right" uk-icon="icon: future"></span>Mes suggestions</small>
				<div class="content_overview">
					<ul class="uk-list uk-list-divider">
						@if(count($mySuggestions) > 0)
							@foreach ($mySuggestions as $item)
								<li><a href="{{ route('suggestion', ['id' => $item->suggestion_id]) }}">{{$item->titre}}</a></li>
							@endforeach
						@else
							<li>Aucune suggestion publiée</li>
						@endif
					</ul>
				</div>
			</div>
		</div>
		<div class="uk-width-expand@m">
			<div class="uk-card uk-card-default uk-card-body">
				<small class="uk-text-uppercase uk-text-muted"><span class="uk-margin-small-right" uk-icon="icon: calendar"></span>Events en cours</small>
				<div class="content_overview">
					<ul class="uk-list uk-list-divider">
						@if(count($myEventsOn) > 0)
							@foreach ($myEventsOn as $item)
								<li><a href="{{ route('event', ['id' => $item->event_id]) }}">{{$item->titre}}</a></li>
							@endforeach
						@else
							<li>Vous ne participez à aucun event</li>
						@endif
					</ul>
				</div>
			</div>
		</div>
	</div>

@endsection