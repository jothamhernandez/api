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
        <h2 class="h4">Create new session</h2>
    </div>
</div>

<form class="needs-validation" method="POST" action="{{ url('/events/'.$event->slug.'/sessions') }}">
    @csrf

    <div class="row">
        <div class="col-12 col-lg-4 mb-3">
            <label for="selectType">Type</label>
            <select class="form-control{{ $errors->has('type') ? ' is-invalid' : '' }}" id="selectType" name="type">
                <option value="talk" {{ old('type', 'talk') === 'talk' ? 'selected' : '' }}>Talk</option>
                <option value="workshop" {{ old('type', 'talk') === 'workshop' ? 'selected' : '' }}>Workshop</option>
            </select>
            @if ($errors->has('type'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('type') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-lg-4 mb-3">
            <label for="inputTitle">Title</label>
            <!-- adding the class is-invalid to the input, shows the invalid feedback below -->
            <input type="text" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" id="inputTitle" name="title" placeholder="" value="{{ old('title') }}">
            @if ($errors->has('title'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('title') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-lg-4 mb-3">
            <label for="inputSpeaker">Speaker</label>
            <input type="text" class="form-control{{ $errors->has('speaker') ? ' is-invalid' : '' }}" id="inputSpeaker" name="speaker" placeholder="" value="{{ old('speaker') }}">
            @if ($errors->has('speaker'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('speaker') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-lg-4 mb-3">
            <label for="selectRoom">Room</label>
            <select class="form-control{{ $errors->has('room') ? ' is-invalid' : '' }}" id="selectRoom" name="room">
                @foreach ($event->rooms as $room)
                <option value="{{ $room->id }}" {{ old('room') == $room->id ? 'selected' : '' }}>{{ $room->name }} / {{ $room->channel->name }}</option>
                @endforeach
            </select>
            @if ($errors->has('room'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('room') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-lg-4 mb-3">
            <label for="inputCost">Cost</label>
            <input type="number" class="form-control{{ $errors->has('cost') ? ' is-invalid' : '' }}" id="inputCost" name="cost" placeholder="" value="{{ old('cost') }}">
            @if ($errors->has('cost'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('cost') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-lg-6 mb-3">
            <label for="inputStart">Start</label>
            <input type="text"
                    class="form-control{{ $errors->has('start') ? ' is-invalid' : '' }}"
                    id="inputStart"
                    name="start"
                    placeholder="yyyy-mm-dd HH:MM"
                    value="{{ old('start') }}">
            @if ($errors->has('start'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('start') }}</strong>
                </span>
            @endif
        </div>
        <div class="col-12 col-lg-6 mb-3">
            <label for="inputEnd">End</label>
            <input type="text"
                    class="form-control{{ $errors->has('end') ? ' is-invalid' : '' }}"
                    id="inputEnd"
                    name="end"
                    placeholder="yyyy-mm-dd HH:MM"
                    value="{{ old('end') }}">
            @if ($errors->has('end'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('end') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="row">
        <div class="col-12 mb-3">
            <label for="textareaDescription">Description</label>
            <textarea class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" id="textareaDescription" name="description" placeholder="" rows="5">{{ old('description') }}</textarea>
            @if ($errors->has('description'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('description') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <hr class="mb-4">
    <button class="btn btn-primary" type="submit">Save session</button>
    <a href="{{ url('/events/'.$event->slug) }}" class="btn btn-link">Cancel</a>
</form>
@endsection
