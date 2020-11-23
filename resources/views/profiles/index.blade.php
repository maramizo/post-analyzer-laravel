@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-md-center">
        <div class="p-5">
            <img src="{{$profile->picture}}" class="rounded-circle w-100" alt="">
        </div>
        <div class="pt-5">
            <div class="d-flex">
               <div><h1>{{ $profile->name }}</h1></div>
               @include('profiles/modal')
               <!--<personality-modal-component has-personality="{{$profile->hasPersonality()}}"></personality-modal-component>-->
            </div>
            <div class="d-flex">
                <div class="pr-5"><strong>{{ $profile->messages->filter(function ($val, $key){ return $val['quote'] == 0; })->count() }}</strong> Posts Analyzed</div>
                <div class="pr-5"><strong>{{ $profile->messages->filter(function ($val, $key){ return $val['quote'] == 1; })->count() }}</strong> Quotes</div>
                <div class="pr-5"><strong>{{ $profile->messages->reduce(function ($carry, $item){ return $carry + str_word_count($item['content']); }) }}</strong> Words</div>
            </div>
            <div class="pt-4">{{ $profile->description }}</div>
            <div><a href="{{$profile->wiki}}">{{ $profile->wiki }}</a></div>
        </div>
    </div>
    <messages-component
        quotes="{{ json_encode($quotes) }}"
        posts="{{ json_encode($posts) }}"
        profile-id="{{ $profile->id }}"
        has-personality="{{ $profile->hasPersonality() }}"
        dimensions="{{ json_encode($profile->personalities()->select('open', 'con', 'ext', 'agr', 'neu')->latest('created_at')->get()->first()) }}"></messages-component>
</div>
@endsection
