<?php

namespace App\Http\Controllers;

use App\Models\MensajeProgramado;
use Illuminate\Http\Request;

class MensajeProgramadoController extends Controller
{
    // List all items
    public function index()
    {
        $mensajes = MensajeProgramado::all();
        return view('mensajes.index', compact('mensajes'));
    }

    // Show create form
    public function create()
    {
        return view('mensajes.create');
    }

    // Store new record
    public function store(Request $request)
    {
        $request->validate([
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'subject' => 'required|max:200',
            'body' => 'required',
        ]);

        MensajeProgramado::create($request->all());

        return redirect()->route('mensajes.index')
                         ->with('success', 'Mensaje creado correctamente.');
    }

    // Edit form
    public function edit(MensajeProgramado $mensaje)
    {
        return view('mensajes.edit', compact('mensaje'));
    }

    // Update record
    public function update(Request $request, MensajeProgramado $mensaje)
    {
        $request->validate([
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'subject' => 'required|max:200',
            'body' => 'required',
        ]);

        $mensaje->update($request->all());

        return redirect()->route('mensajes.index')
                         ->with('success', 'Mensaje actualizado.');
    }

    // Delete record
    public function destroy(MensajeProgramado $mensaje)
    {
        $mensaje->delete();

        return redirect()->route('mensajes.index')
                         ->with('success', 'Mensaje eliminado.');
    }
}
