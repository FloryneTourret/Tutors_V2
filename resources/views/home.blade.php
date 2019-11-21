@extends('app')

@section('content')
	{{-- {{ var_dump($posts) }} --}}
	@if (isset($error))
<h2>{{$error}}</h2>
	@else
		<ul>
			@foreach ($categories as $category)
				<li>{{$category->nom}}</li>
			@endforeach
		</ul>
		@foreach ($posts as $post)
			<div>
				<div><h2>{{$post->titre}}</h2></div>
				<div><p>by {{$post->login}}</p></div>
			<div><p>{{$post->resume}}</p></div>
			</div>
		@endforeach
		{{$posts}}
	@endif	
@endsection