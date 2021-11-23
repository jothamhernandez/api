@extends('layouts.app')

@section('content')
<div
    class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Manage Events</h1>
</div>

<div class="mb-3 pt-3 pb-2">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
        <h2 class="h4">Create new event</h2>
    </div>
</div>

<form class="needs-validation" method="POST" action="{{ url('/events') }}">
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

    <div class="row">
        <div class="col-12 col-lg-4 mb-3">
            <label for="inputSlug">Slug</label>
            <input type="text" class="form-control{{ $errors->has('slug') ? ' is-invalid' : '' }}" id="inputSlug" name="slug" placeholder="" value="{{ old('slug') }}">
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
                    value="{{ old('date') }}">
            @if ($errors->has('date'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('date') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <hr class="mb-4">
    <button class="btn btn-primary" type="submit">Save event</button>
    <a href="{{ url('/events') }}" class="btn btn-link">Cancel</a>
</form>
@endsection
