<?php

namespace App\Http\Controllers;

use App\Models\Pesaje;
use Barryvdh\DomPDF\Facade\Pdf;

class ReporteController extends Controller
{
    // 📊 Vista de reportes
    public function index()
    {
        $pesajes = Pesaje::where('user_id', auth()->id())->get();

        $total = $pesajes->sum('peso');

        $porMaterial = $pesajes->groupBy('material')->map(function ($items) {
            return $items->sum('peso');
        });

        return view('reportes.index', compact('pesajes', 'total', 'porMaterial'));
    }

    // 📄 Generar PDF
    public function pdf()
    {
        $pesajes = Pesaje::where('user_id', auth()->id())->get();

        $total = $pesajes->sum('peso');

        $porMaterial = $pesajes->groupBy('material')->map(function ($items) {
            return $items->sum('peso');
        });

        $pdf = Pdf::loadView('reportes.pdf', compact('pesajes', 'total', 'porMaterial'));

        return $pdf->download('reporte_reciclaje.pdf');
    }
}