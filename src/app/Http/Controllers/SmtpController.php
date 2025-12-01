<?php

namespace App\Http\Controllers;

use App\Models\SmtpConfig;
use Illuminate\Http\Request;

class SmtpController extends Controller
{
    public function index()
    {
        $configs = SmtpConfig::paginate(10);
        return view('smtp.index', compact('configs'));
    }

    public function create()
    {
        return view('smtp.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'host' => 'required',
            'username' => 'required',
            'password' => 'required',
            'encryption' => 'required',
            'port' => 'required|integer',
        ]);

        SmtpConfig::create($request->all());

        return redirect()
            ->route('smtp.index')
            ->with('success', 'Configuración SMTP creada correctamente.');
    }

    public function edit(SmtpConfig $smtp)
    {
        return view('smtp.edit', compact('smtp'));
    }

    public function update(Request $request, SmtpConfig $smtp)
    {
        $request->validate([
            'host' => 'required',
            'username' => 'required',
            'password' => 'required',
            'encryption' => 'required',
            'port' => 'required|integer',
        ]);

        $smtp->update($request->all());

        return redirect()
            ->route('smtp.index')
            ->with('success', 'Configuración actualizada correctamente.');
    }

    public function destroy(SmtpConfig $smtp)
    {
        $smtp->delete();

        return redirect()
            ->route('smtp.index')
            ->with('success', 'Configuración eliminada.');
    }
}
