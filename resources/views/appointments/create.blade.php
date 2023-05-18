@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Create Appointment</h1>

    <form method="POST" action="{{ route('appointments.store') }}">
        @csrf

        <div class="form-group">
            <label for="service_id">Service</label>
            <select class="form-control" id="service_id" name="service_id">
                @foreach($services as $service)
                <option value="{{ $service->id }}">{{ $service->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="date">Date</label>
            <input type="date" class="form-control" id="date" name="date" value="{{ old('date') }}" required>
        </div>

        <div class="form-group">
            <label for="time">Time</label>
            <input type="time" class="form-control" id="time" name="time" value="{{ old('time') }}" required>
        </div>

        <div class="form-group">
            <label for="location">Location</label>
            <input type="text" class="form-control" id="location" name="location" value="{{ old('location') }}"
                required>
        </div>

        <button type="submit" class="btn btn-primary">Create Appointment</button>
    </form>
</div>
@endsection