@extends('layouts.app')

@section('content')
<div class="border-bottom mb-3 pt-3 pb-2">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
        <h1 class="h2">{{ $event->name }}</h1>
    </div>
    <span class="h6">{{ $event->getFormattedDate() }}</span>
</div>

<div class="mb-3 pt-3 pb-2">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
        <h2 class="h4">Create new channel</h2>
    </div>
</div>

<form class="needs-validation" method="POST" action="{{ url('/events/'.$event->slug.'/channels') }}">
    @csrf

    <div class="row">
        <div class="col-12 col-lg-4 mb-3">
            <label for="inputName">Name</label>
            <!-- adding the class is-invalid to the input, shows the invalid feedback below -->
            <input type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" id="inputName" name="name" placeholder="" value="{{ old('name') }}">
            @if ($errors->has('name'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <hr class="mb-4">
    <button class="btn btn-primary" type="submit">Save channel</button>
    <a href="{{ url('/events/'.$event->slug) }}" class="btn btn-link">Cancel</a>
</form>
@endsection
