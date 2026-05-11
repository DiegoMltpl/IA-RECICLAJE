<x-app-layout>

<div class="max-w-7xl mx-auto px-6 py-8">

    <!-- TÍTULO -->
    <h2 class="text-2xl font-semibold text-gray-800 mb-6">
        Predicción de Reciclaje
    </h2>

    <!-- TARJETAS -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">

        <!-- DIARIA -->
        <div class="bg-white p-6 rounded-xl shadow">
            <p class="text-gray-500 text-sm">Diaria</p>
            <h3 class="text-3xl font-bold text-blue-600">
                {{ number_format($pred, 2) }} kg
            </h3>
        </div>

        <!-- SEMANAL -->
        <div class="bg-white p-6 rounded-xl shadow">
            <p class="text-gray-500 text-sm">Semanal</p>
            <h3 class="text-3xl font-bold text-indigo-600">
                {{ number_format($sem, 2) }} kg
            </h3>
        </div>

        <!-- MENSUAL -->
        <div class="bg-white p-6 rounded-xl shadow">
            <p class="text-gray-500 text-sm">Mensual</p>
            <h3 class="text-3xl font-bold text-purple-600">
                {{ number_format($mes, 2) }} kg
            </h3>
        </div>

        <!-- OUTLIERS -->
        <div class="bg-white p-6 rounded-xl shadow">
            <p class="text-gray-500 text-sm">Datos atípicos</p>
            <h3 class="text-3xl font-bold text-gray-800">
                {{ $outliers }}
            </h3>
        </div>

    </div>

    <!-- NIVEL -->
    <div class="bg-white p-6 rounded-xl shadow mb-8">

        <h3 class="text-lg font-semibold text-gray-700 mb-3">
            Análisis del sistema
        </h3>

        @if($pred > 60)
            <p class="text-green-600 font-medium">
                Alto nivel esperado de reciclaje.
            </p>
        @elseif($pred > 30)
            <p class="text-yellow-500 font-medium">
                Nivel medio de reciclaje.
            </p>
        @else
            <p class="text-red-500 font-medium">
                Nivel bajo, se recomienda mejorar la recolección.
            </p>
        @endif

    </div>

    <!-- GRÁFICA -->
    <div class="bg-white p-6 rounded-xl shadow">

        <h3 class="text-lg font-semibold text-gray-700 mb-4">
            Tendencia histórica
        </h3>

        <canvas id="graficaPrediccion"></canvas>

    </div>

</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    new Chart(document.getElementById('graficaPrediccion'), {
        type: 'line',
        data: {
            labels: @json($fechas),
            datasets: [{
                label: 'Kg por día',
                data: @json($totales),
                borderWidth: 2,
                tension: 0.3
            }]
        },
        options: {
            responsive: true
        }
    });
</script>

</x-app-layout>