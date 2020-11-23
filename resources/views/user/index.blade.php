@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row col-8">
        User Info: {{ $user }}
    </div>
    <div class="row col-8">
        User Profiles: {{ $user->profiles }}
    </div>
</div>
@endsection
