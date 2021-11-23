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
        <h2 class="h4">Create new ticket</h2>
    </div>
</div>

<form class="needs-validation" method="POST" action="{{ url('/events/'.$event->slug.'/tickets') }}">
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
        <div class="col-12 col-lg-4 mb-3">
            <label for="selectSpecialValidity">Special Validity</label>
            <select class="form-control{{ $errors->has('special_validity') ? ' is-invalid' : '' }}" id="selectSpecialValidity" name="special_validity">
                <option value="">None</option>
                <option value="amount" {{ old('special_validity') === 'amount' ? 'selected' : '' }}>Limited amount</option>
                <option value="date" {{ old('special_validity') === 'date' ? 'selected' : '' }}>Purchaseable till date</option>
            </select>
            @if ($errors->has('special_validity'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('special_validity') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="row special-validity-amount" style="display:none">
        <div class="col-12 col-lg-4 mb-3">
            <label for="inputAmount">Maximum amount of tickets to be sold</label>
            <input type="number" class="form-control{{ $errors->has('amount') ? ' is-invalid' : '' }}" id="inputAmount" name="amount" placeholder="" value="{{ old('amount') }}">
            @if ($errors->has('amount'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('amount') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="row special-validity-date" style="display:none">
        <div class="col-12 col-lg-4 mb-3">
            <label for="inputValidTill">Tickets can be sold until</label>
            <input type="text"
                    class="form-control{{ $errors->has('valid_until') ? ' is-invalid' : '' }}"
                    id="inputValidTill"
                    name="valid_until"
                    placeholder="yyyy-mm-dd HH:MM"
                    value="{{ old('valid_until') }}">
            @if ($errors->has('valid_until'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('valid_until') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <hr class="mb-4">
    <button class="btn btn-primary" type="submit">Save ticket</button>
    <a href="{{ url('/events/'.$event->slug) }}" class="btn btn-link">Cancel</a>
</form>
<script>
    const checkSpecialValidity = () => {
        const validity = document.querySelector('select[name="special_validity"]').value;
        document.querySelector('.special-validity-amount').style.display = validity === 'amount' ? 'block' : 'none';
        document.querySelector('.special-validity-date').style.display = validity === 'date' ? 'block' : 'none';
    };

    document.querySelector('select[name="special_validity"]').addEventListener('change', checkSpecialValidity);
    checkSpecialValidity();
</script>
@endsection
