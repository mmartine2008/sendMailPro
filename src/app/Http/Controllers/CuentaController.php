<?php

namespace App\Http\Controllers;

use App\Models\Cuenta;
use App\Models\SmtpConfig;
use Illuminate\Http\Request;

class CuentaController extends Controller
{
    public function index()
    {
        $cuentas = Cuenta::with('smtp')->get();
        return view('cuentas.index', compact('cuentas'));
    }

    public function create()
    {
        $smtps = SmtpConfig::all(); // For dropdown
        return view('cuentas.create', compact('smtps'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre'   => 'required',
            'password' => 'required',
            'smtp_id'  => 'required|exists:smtp_table,id',
            'activa' => 'nullable|boolean',
        ]);

        Cuenta::create([
            'nombre' => $request->nombre,
            'password' => $request->password,
            'smtp_id' => $request->smtp_id,
            'activa' => $request->has('activa'),
        ]);

        return redirect()->route('cuentas.index');
    }

    public function edit(Cuenta $cuenta)
    {
        $smtps = SmtpConfig::all();
        return view('cuentas.edit', compact('cuenta', 'smtps'));
    }

    public function update(Request $request, Cuenta $cuenta)
    {
        $request->validate([
            'nombre'   => 'required',
            'password' => 'required',
            'smtp_id'  => 'required|exists:smtp_table,id',
            'activa' => 'nullable|boolean',
        ]);

        $cuenta->update($request->all());

        return redirect()->route('cuentas.index');
    }

    public function destroy(Cuenta $cuenta)
    {
        $cuenta->delete();
        return redirect()->route('cuentas.index');
    }
}
