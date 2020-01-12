@extends('layout.app')

@section('contact')
  <h1>Contact Page</h1>

  @if (count($names))
  <ul>

    @foreach($names as $name)

      <li>{{$name}} {{$urls}} </li>

    @endforeach

  </ul>
  @endif
@stop
