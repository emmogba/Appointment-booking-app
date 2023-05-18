<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $services = auth()->user()->services;
        return view('services.index', compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('services.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $validatedData = $request->validate([
        'name' => 'required|max:255',
        'description' => 'required',
        'price' => 'required',
        'location' => 'required',
    ]);

    $service = new Service;
    $service->name = $validatedData['name'];
    $service->description = $validatedData['description'];
    $service->price = $validatedData['price'];
    $service->location = $validatedData['location'];
    $service->user_id = Auth::id();
    $service->save();

    return redirect()->route('services.index')
        ->with('success','Service created successfully.');
}


    /**
     * Display the specified resource.
     */
    public function show(Service $service)
    {
        return view('services.show', compact('service'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Service $service)
    {
        return view('services.edit', compact('service'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Service $service)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
            'price' => 'required|numeric',
            'location' => 'required|max:255',
        ]);

        $service->name = $validatedData['name'];
        $service->description = $validatedData['description'];
        $service->price = $validatedData['price'];
        $service->location = $validatedData['location'];
        $service->save();

        return redirect()->route('services.index')->with('success', 'Service updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service)
    {
         $service->delete();

        return redirect()->route('services.index')->with('success', 'Service deleted successfully.');
    }
    
}