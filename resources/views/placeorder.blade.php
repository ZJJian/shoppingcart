@extends('layout')
@section('title', 'PlaceOrder')
@section('content')

    <div class="placeorder content-wrapper">
        <h1>{{session()->get('title') ?? ''}}</h1>
        <p>{{session()->get('message') ?? ''}}</p>
    </div>

@endsection
