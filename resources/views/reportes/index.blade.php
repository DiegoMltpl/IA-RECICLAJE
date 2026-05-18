<x-app-layout>

<div class="max-w-7xl mx-auto px-6 py-8">

    <h2 class="text-2xl font-semibold text-gray-800 mb-6">
        Reportes
    </h2>

    <!-- TOTAL -->
    <div class="bg-white p-6 rounded-xl shadow mb-6">
        <p class="text-gray-500 text-sm">Total reciclado</p>
        <h3 class="text-3xl font-bold text-blue-600">
            {{ number_format($total, 2) }} kg
        </h3>
    </div>

    <!-- POR MATERIAL -->
    <div class="bg-white p-6 rounded-xl shadow mb-6">
        <h3 class="text-lg font-semibold text-gray-700 mb-4">
            Reciclaje por material
        </h3>

        @foreach($porMaterial as $material => $peso)
            <div class="flex justify-between border-b py-2">
                <span class="capitalize">{{ $material }}</span>
                <span class="font-semibold">{{ $peso }} kg</span>
            </div>
        @endforeach
    </div>

    <!-- BOTÓN PDF -->
    <div class="mt-6">
<a href="{{ route('reportes.pdf') }}"
   style="background: blue; color: white; padding: 12px 20px; border-radius: 8px;">
    Descargar PDF
</a>
    </div>

</div>

</x-app-layout>