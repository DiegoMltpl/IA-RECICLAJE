<x-app-layout>

<div class="p-6 bg-gray-100 min-h-screen">

    <!-- HEADER -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Historial de Pesajes</h1>
        <p class="text-gray-500">Listado de registros almacenados en el sistema</p>
    </div>

<div class="mb-4">
    <a href="/pesajes/create"
       style="background:#2563eb; color:white; padding:10px 16px; border-radius:8px; display:inline-block;">
        Nuevo registro
    </a>
</div>
    <!-- TABLA -->
    <div class="bg-white rounded-xl shadow overflow-hidden">

        <table class="w-full text-sm text-left">

            <thead class="bg-gray-200 text-gray-700">
                <tr>
                    <th class="p-3">Material</th>
                    <th class="p-3">Peso (kg)</th>
                    <th class="p-3">Fecha</th>
                </tr>
            </thead>

            <tbody>

                @forelse($pesajes as $p)
                    <tr class="border-t hover:bg-gray-50">

                        <td class="p-3 font-medium text-gray-800">
                            {{ ucfirst($p->material) }}
                        </td>

                        <td class="p-3 text-gray-600">
                            {{ $p->peso }} kg
                        </td>

                        <td class="p-3 text-gray-500">
                            {{ \Carbon\Carbon::parse($p->fecha)->format('Y-m-d H:i') }}
                        </td>

                    </tr>
                @empty

                    <tr>
                        <td colspan="3" class="p-4 text-center text-gray-500">
                            No hay registros disponibles
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

</x-app-layout>