@extends('layouts.app')

@section('content')
<div class="container">
    <form action="">
        <div class="row">
            <div class="col-8 offset-2">
                <div class="form-group row">
                    <label for="content" class="col-md-4 col-form-label">Message Content</label>
                    <input id="content" 
                    type="text" 
                    class="form-control @error('content') is-invalid @enderror" 
                    content="content" 
                    value="{{ old('content') }}" 
                    autocomplete="content" 
                    autofocus>

                    @error('content')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row">
            
        </div>
    </form>
</div>
@endsection
