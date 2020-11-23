@extends('layouts.app')
@section('content')
    <profile-creator-component csrf="{{csrf_token()}}"></profile-creator-component>
@endsection
