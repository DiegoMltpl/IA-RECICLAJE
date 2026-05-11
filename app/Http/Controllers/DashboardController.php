<?php

namespace App\Http\Controllers;

use App\Models\Pesaje;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        // 🔹 Totales
        $totalHoy = Pesaje::where('user_id', $userId)
            ->whereDate('fecha', now()->toDateString())
            ->sum('peso');

        $totalGeneral = Pesaje::where('user_id', $userId)
            ->sum('peso');

        // 🔹 Últimos registros
        $ultimos = Pesaje::where('user_id', $userId)
            ->latest()
            ->take(5)
            ->get();

        // 🔹 PORCENTAJES POR MATERIAL
        $porMaterial = Pesaje::where('user_id', $userId)
            ->selectRaw('material, SUM(peso) as total')
            ->groupBy('material')
            ->get();

        $totalGlobal = $porMaterial->sum('total');

        $porcentajes = $porMaterial->map(function ($item) use ($totalGlobal) {
            $item->porcentaje = $totalGlobal > 0 
                ? ($item->total / $totalGlobal) * 100 
                : 0;
            return $item;
        });

        return view('dashboard', compact(
            'totalHoy',
            'totalGeneral',
            'ultimos',
            'porcentajes'
        ));
    }
}