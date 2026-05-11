<x-app-layout>

<div class="p-6 bg-gray-100 min-h-screen">

    <h1 class="text-2xl font-bold mb-6">➕ Registrar Pesaje</h1>

    <!-- MENSAJE -->
    @if(session('success'))
        <div class="bg-green-200 text-green-800 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="/pesajes" class="bg-white p-6 rounded-xl shadow space-y-4">
        @csrf

        <div>
            <label class="block text-gray-700">Material</label>
            <select name="material" class="w-full border rounded p-2">
                <option value="plastico">Plástico</option>
                <option value="vidrio">Vidrio</option>
                <option value="metal">Metal</option>
                <option value="carton">Cartón</option>
            </select>
        </div>

        <div>
            <label class="block text-gray-700">Peso (kg)</label>
            <input type="number" step="0.1" name="peso" class="w-full border rounded p-2" required>
        </div>

        <div>
            <label class="block text-gray-700">Fecha</label>
            <input type="date" name="fecha" class="w-full border rounded p-2" required>
        </div>

        <button class="bg-purple-600 text-white px-4 py-2 rounded hover:bg-purple-700">
            Guardar
        </button>

    </form>

</div>

</x-app-layout>