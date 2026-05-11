<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesaje;

class PesajeController extends Controller
{
    // 🔹 LISTAR PESAJES
    public function index()
    {
        $pesajes = Pesaje::where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('pesajes.index', compact('pesajes'));
    }

    // 🔹 FORMULARIO
    public function create()
    {
        return view('pesajes.create');
    }

    // 🔹 GUARDAR
    public function store(Request $request)
    {
        // ✅ VALIDACIÓN (IMPORTANTE PARA TU NOTA)
        $request->validate([
            'material' => 'required|string',
            'peso' => 'required|numeric|min:0.1',
            'fecha' => 'required|date'
        ]);

        // ✅ GUARDAR
        Pesaje::create([
            'user_id' => auth()->id(),
            'material' => $request->material,
            'peso' => $request->peso,
            'fecha' => $request->fecha
        ]);

        return redirect('/pesajes')->with('success', 'Pesaje registrado correctamente');
    }
}