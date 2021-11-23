@extends('layouts.app')

@section('content')
<div class="border-bottom mb-3 pt-3 pb-2">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
        <h1 class="h2">{{ $event->name }}</h1>
    </div>
</div>

<form class="needs-validation" method="POST" action="{{ url('/events/'.$event->slug) }}">
    @csrf

    <div class="row">
        <div class="col-12 col-lg-4 mb-3">
            <label for="inputName">Name</label>
            <!-- adding the class is-invalid to the input, shows the invalid feedback below -->
            <input type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" id="inputName" name="name" placeholder="" value="{{ old('name', $event->name) }}">
            @if ($errors->has('name'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-lg-4 mb-3">
            <label for="inputSlug">Slug</label>
            <input type="text" class="form-control{{ $errors->has('slug') ? ' is-invalid' : '' }}" id="inputSlug" name="slug" placeholder="" value="{{ old('slug', $event->slug) }}">
            @if ($errors->has('slug'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('slug') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-lg-4 mb-3">
            <label for="inputDate">Date</label>
            <input type="text"
                    class="form-control{{ $errors->has('date') ? ' is-invalid' : '' }}"
                    id="inputDate"
                    name="date"
                    placeholder="yyyy-mm-dd"
                    value="{{ old('date', $event->date) }}">
            @if ($errors->has('date'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('date') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <hr class="mb-4">

    {{ method_field('PUT') }}
    <button class="btn btn-primary" type="submit">Save event</button>
    <a href="{{ url('/events/'.$event->slug) }}" class="btn btn-link">Cancel</a>
</form>
@endsection
