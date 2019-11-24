@extends('app')

@section('content')
<div class="posts">
	@if (isset($error))
		<h2>{{$error}}</h2>
	@else
	<div class="categories">
			@if ($categorie == null)
				<a class="active" href="/">Tous les posts</a>
			@else
				<a href="/">Tous les posts</a>
			@endif
			@foreach ($categories as $category)
				@if ($category->nom == $categorie)
					<a class="active" href="/{{$category->nom}}">{{$category->nom}}</a>
				@else
					<a href="/{{$category->nom}}">{{$category->nom}}</a>
				@endif
			@endforeach
		</div>

		<div uk-grid uk-scrollspy="cls: uk-animation-fade; target: .uk-card; delay: 500; repeat: true">
		@php($range = 1)
		@foreach ($posts as $post)
			@if ($range == 1)
				<a href="/post/{{$post->post_id}}" class="uk-width-1" id="card_{{ $range++ }}">
					<div class="uk-card uk-card-default uk-grid-collapse uk-child-width-1-2@s uk-margin" uk-grid>
						<div class="img-left uk-cover-container">
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
				</a>
			@else
				<a href="/post/{{$post->post_id}}" class="uk-width-1-4@s">
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
				</a>
			@endif
		@endforeach	
		</div>

		<div class="pagination">
			{{$posts}}
		</div>
	@endif	
</div>
@endsection
			