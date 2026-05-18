<?php

namespace App\Http\Controllers;

use App\Models\Pesaje;

class PrediccionController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        // 📊 Datos por día
        $porDia = Pesaje::where('user_id', $userId)
            ->selectRaw('DATE(fecha) as dia, SUM(peso) as total')
            ->groupBy('dia')
            ->orderBy('dia')
            ->get();

        $fechas = $porDia->pluck('dia');
        $totales = $porDia->pluck('total');

        // 📁 CSV para Python
        $rutaCSV = storage_path('app/private/datos.csv');

        $csv = "dia,total\n";
        foreach ($porDia as $row) {
            $csv .= $row->dia . "," . $row->total . "\n";
        }

        file_put_contents($rutaCSV, $csv);

        // 🤖 Ejecutar Python
        $output = [];
        $return = 0;

exec("python3 " . base_path("modelo.py"), $output, $return);

        // 🔮 Valores por defecto
        $pred = 0;
        $outliers = 0;

        if (isset($output[0])) {
            $datos = explode(',', $output[0]);
            $pred = floatval($datos[0]);
            $outliers = isset($datos[1]) ? intval($datos[1]) : 0;
        }

        // 📅 Cálculo semana y mes
        $sem = $pred * 7;
        $mes = $pred * 30;

        return view('prediccion', compact(
            'pred',
            'sem',
            'mes',
            'outliers',
            'fechas',
            'totales'
        ));
    }
}