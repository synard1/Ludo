@extends('semver::layouts.master')

@section('content')
    <h1>Hello World</h1>

    <p>Module: {!! config('semver.name') !!}</p>
@endsection
