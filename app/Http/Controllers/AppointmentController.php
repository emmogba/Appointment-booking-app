<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    public function index()
    {
        $appointments = Appointment::where('user_id', Auth::id())->get();
        return view('appointments.index', compact('appointments'));
    }

    public function create(Service $service)
    {
        return view('appointments.create', compact('service'));
    }

    public function store(Request $request, Service $service)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'phone' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'scheduled_at' => 'required|date',
        ]);

        Appointment::create([
            'service_id' => $service->id,
            'user_id' => Auth::id(),
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'location' => $request->location,
            'scheduled_at' => $request->scheduled_at,
        ]);

        return redirect()->route('services.show', $service)->with('success', 'Appointment booked successfully.');
    }

    public function destroy(Appointment $appointment)
    {
        $this->authorize('delete', $appointment);

        $appointment->delete();

        return redirect()->route('appointments.index')->with('success', 'Appointment deleted successfully.');
    }
    public function show($id)
{
    $appointment = Appointment::findOrFail($id);

    return view('appointments.show', compact('appointment'));
}
public function edit($id)
{
    $appointment = Appointment::findOrFail($id);
    $services = Service::all();

    return view('appointments.edit', compact('appointment', 'services'));
}
public function update(Request $request, $id)
{
     
    $appointment = Appointment::findOrFail($id);

       $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'phone' => 'required|string|max:20',
        'address' => 'required|string|max:255',
        'service_id' => 'required|exists:services,id',
        'scheduled_date' => 'required|date',
        'scheduled_time' => 'required',
        'status' => 'required|in:scheduled,cancelled,completed',
    ]);

    $appointment->service_id = $request->input('service_id');
    $appointment->user_id = Auth::id();
    $appointment->location = $request->input('location');
    $appointment->date = $request->input('date');
    $appointment->time = $request->input('time');

    $appointment->save();

    return redirect()->route('appointments.index')
                     ->with('success', 'Appointment updated successfully.');
}

}