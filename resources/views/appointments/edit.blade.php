@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Edit Appointment</h1>
            <hr>
            <form action="{{ route('appointments.update', $appointment->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="service">Service:</label>
                    <select class="form-control" name="service_id" id="service">
                        @foreach($services as $service)
                        <option value="{{ $service->id }}"
                            {{ ($service->id == $appointment->service_id) ? 'selected' : '' }}>{{ $service->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="date">Date:</label>
                    <input type="date" class="form-control" id="date" name="date" value="{{ $appointment->date }}">
                </div>
                <div class="form-group">
                    <label for="time">Time:</label>
                    <input type="time" class="form-control" id="time" name="time" value="{{ $appointment->time }}">
                </div>
                <div class="form-group">
                    <label for="location">Location:</label>
                    <input type="text" class="form-control" id="location" name="location"
                        value="{{ $appointment->location }}">
                </div>
                <div class="form-group">
                    <label for="notes">Notes:</label>
                    <textarea class="form-control" id="notes" name="notes">{{ $appointment->notes }}</textarea>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Update Appointment</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection