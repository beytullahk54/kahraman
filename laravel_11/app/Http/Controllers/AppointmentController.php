<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $appointments = Appointment::with('user')
            ->latest()
            ->paginate(10);
        return view('appointments.index', compact('appointments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('appointments.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'appointment_date' => 'required|date',
            'status' => 'required|in:pending,confirmed,cancelled',
            'client_name' => 'required|string|max:255',
            'client_phone' => 'required|string|max:255',
            'client_email' => 'nullable|email|max:255',
        ]);

        

        $validated['user_id'] = Auth::user()->id;

        Appointment::create($validated);

        return response()->json([
            'message' => 'Randevu başarıyla oluşturuldu'
        ], 201);
        return redirect()
            ->route('appointments.index')
            ->with('success', 'Randevu başarıyla oluşturuldu');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Appointment $appointment)
    {
        return view('appointments.edit', compact('appointment'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Appointment $appointment)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'appointment_date' => 'required|date',
            'status' => 'required|in:pending,confirmed,cancelled',
            'client_name' => 'required|string|max:255',
            'client_phone' => 'required|string|max:255',
            'client_email' => 'nullable|email|max:255',
        ]);

        $appointment->update($validated);

        return response()->json([
            'message' => 'Randevu başarıyla güncellendi'
        ], 201);
        return redirect()
            ->route('appointments.index')
            ->with('success', 'Randevu başarıyla güncellendi');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Appointment $appointment)
    {
        $appointment->delete();
        return redirect()
            ->route('appointments.index')
            ->with('success', 'Randevu başarıyla silindi');
    }
}
