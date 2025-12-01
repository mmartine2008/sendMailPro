<?php

namespace App\Http\Controllers;

use App\Models\Email;
use Illuminate\Http\Request;

class EmailController extends Controller
{
    // Listado
    public function index()
    {
        $emails = Email::orderBy('id', 'desc')->paginate(20);
        return view('emails.index', compact('emails'));
    }

    // Form nuevo
    public function create()
    {
        return view('emails.create');
    }

    // Guardar nuevo
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:emails,email'
        ]);

        Email::create($request->only('email'));

        return redirect()->route('emails.index')->with('success', 'Email agregado.');
    }

    // Editar
    public function edit(Email $email)
    {
        return view('emails.edit', compact('email'));
    }

    // Actualizar
    public function update(Request $request, Email $email)
    {
        $request->validate([
            'email' => 'required|email|unique:emails,email,' . $email->id
        ]);

        $email->update($request->only('email'));

        return redirect()->route('emails.index')->with('success', 'Email actualizado.');
    }

    // Eliminar
    public function destroy(Email $email)
    {
        $email->delete();
        return redirect()->route('emails.index')->with('success', 'Email eliminado.');
    }

    // Importar CSV
    public function import(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt'
        ]);

        $path = $request->file('csv_file')->getRealPath();

        // Read all lines (handles any newline types)
        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        foreach ($lines as $line) {

            // Remove BOM, spaces, quotes
            $email = trim($line, " \t\n\r\0\x0B\"");

            // Skip headers if present
            if (strtolower($email) === 'email') {
                continue;
            }

            // Validate email
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                continue;
            }

            if (!Email::where('email', $email)->exists()) {
                Email::create(['email' => $email]);
            }

        }

        return back()->with('success', 'Importación completada correctamente.');
    }


}
