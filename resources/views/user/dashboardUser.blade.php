@extends('dashboard')

@section('content')
	<div class="uk-child-width-expand@s stats" uk-grid>
		<div>
			<div class="uk-card uk-card-small uk-card-body">
				<small class="uk-text-uppercase uk-text-muted"><span class="uk-margin-small-right" uk-icon="icon: calendar"></span>Events en cours</small>
				<p class="color-lightpink uk-text-bold">Lorem ipsum</p>
			</div>
		</div>
		<div>
			<div class="uk-card uk-card-small uk-card-body">
				<small class="uk-text-uppercase uk-text-muted"><span class="uk-margin-small-right" uk-icon="icon: calendar"></span>Events</small>
				<p class="color-lightpink uk-text-bold">Lorem ipsum</p>
			</div>
		</div>
		<div>
			<div class="uk-card uk-card-small uk-card-body">
				<small class="uk-text-uppercase uk-text-muted"><span class="uk-margin-small-right" uk-icon="icon: future"></span>Suggestions</small>
				<p class="color-lightpink uk-text-bold">Lorem ipsum</p>
			</div>
		</div>
		<div>
			<div class="uk-card uk-card-small uk-card-body">
				<small class="uk-text-uppercase uk-text-muted"><span class="uk-margin-small-right" uk-icon="icon: users"></span>Sessions d'aide</small>
				<p class="color-lightpink uk-text-bold">Lorem ipsum</p>
			</div>
		</div>
	</div>

	<div class="overview" uk-grid="masonry: true">
		<div class="uk-width-2-3@s">
			<div class="uk-card uk-card-default uk-card-body">
				<small class="uk-text-uppercase uk-text-muted"><span class="uk-margin-small-right" uk-icon="icon: bell"></span>Nouveautés</small>
			</div>
		</div>
		<div class="uk-width-expand@m">
			<div class="uk-card uk-card-default uk-card-body">
			<small class="uk-text-uppercase uk-text-muted"><span class="uk-margin-small-right" uk-icon="icon: users"></span>Sessions d'aide en cours</small>
			</div>
		</div>
		<div class="uk-width-2-3@s">
			<div class="uk-card uk-card-default uk-card-body">
			<small class="uk-text-uppercase uk-text-muted"><span class="uk-margin-small-right" uk-icon="icon: future"></span>Mes suggestions</small>
			</div>
		</div>
		<div class="uk-width-expand@m">
			<div class="uk-card uk-card-default uk-card-body">
			<small class="uk-text-uppercase uk-text-muted"><span class="uk-margin-small-right" uk-icon="icon: calendar"></span>Events en cours</small>
			</div>
		</div>
	</div>

@endsection