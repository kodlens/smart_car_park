@extends('layouts.app')

@section('content')
    <home-page :props-park-price=@json($parkPrice)></home-page>
@endsection
