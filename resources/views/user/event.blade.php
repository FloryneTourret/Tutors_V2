@extends('dashboard')

@section('content')
    @if(isset($error))
        {{$error}}
    @else
        <p style="color:white">Value : <br>
            $event<br>
            $comments<br>
            $lead<br>
            $likes<br>
            $orga<br>
            $contributors<br>
            $volunteers<br>
        </p>
    @endif
@endsection