@include('app')

<h1>hello</h1>
@if (session()->exists('username'))
	{{ session()->get('username')}}
	@if (session()->get('tutor') == true)
	est tuteur
	@else
	n'est pas tuteur
	@endif 
@endif