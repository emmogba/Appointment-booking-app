@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Appointments</h1>

    <table class="table">
        <thead>
            <tr>
                <th>Service</th>
                <th>Date</th>
                <th>Time</th>
                <th>Location</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($appointments as $appointment)
            <tr>
                <td>{{ $appointment->service->name }}</td>
                <td>{{ $appointment->date->format('M d, Y') }}</td>
                <td>{{ $appointment->time->format('h:i A') }}</td>
                <td>{{ $appointment->location }}</td>
                <td>
                    <a href="{{ route('appointments.edit', $appointment) }}" class="btn btn-sm btn-primary">Edit</a>
                    <form method="POST" action="{{ route('appointments.destroy', $appointment) }}"
                        style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger"
                            onclick="return confirm('Are you sure you want to delete this appointment?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ route('appointments.create') }}" class="btn btn-primary">Create Appointment</a>
</div>
@endsection