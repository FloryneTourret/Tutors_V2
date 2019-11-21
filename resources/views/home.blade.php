@extends('app')

@section('content')
<div class="posts">
	@if (isset($error))
		<h2>{{$error}}</h2>
	@else
	<div class="categories">
			<a href="/">Tous les posts</a>
			@foreach ($categories as $category)
				<a href="/{{$category->nom}}">{{$category->nom}}</a>
			@endforeach
		</div>

		<div uk-grid uk-scrollspy="cls: uk-animation-fade; target: .uk-card; delay: 500; repeat: true">
		@php($range = 1)
		@foreach ($posts as $post)
			@if ($range == 1)
				<div class="uk-width-1" id="card_{{ $range++ }}">
					<div class="uk-card uk-card-default uk-grid-collapse uk-child-width-1-2@s uk-margin" uk-grid>
						<div class=" uk-cover-container">
							<img src="{{$post->image}}" alt="" uk-cover>
							<canvas width="600" height="400"></canvas>
						</div>
						<div>
							<div class="uk-card-body">
								<p class="uk-card-title">{{$post->titre}}</p>
								<small>{{$post->login}}</small>
								<p>{{$post->resume}}</p>
							</div>
						</div>
					</div>
				</div>
			@else
				<div class="uk-width-1-4@s">
					<div>
						<div class="uk-card uk-card-default">
							<div class="uk-card-media-top">
								<div class="img_post" style="background-image: url({{$post->image}})"></div>
							</div>
							<div class="uk-card-body">
								<p class="uk-card-title">{{$post->titre}}</p>
								<small>{{$post->login}}</small>
							</div>
						</div>
					</div>
				</div>
			@endif
		@endforeach	
		</div>

		<div class="pagination">
			{{$posts}}
		</div>
	@endif	
</div>
@endsection
			