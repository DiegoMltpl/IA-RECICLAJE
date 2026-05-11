<x-app-layout>

<div class="p-6 bg-gray-100 min-h-screen">

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- IZQUIERDA -->
        <div class="lg:col-span-2 space-y-6">

            <!-- TARJETAS -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <div class="bg-white p-4 rounded-xl shadow">
                    <p class="text-gray-500 text-sm">Total hoy</p>
                    <h2 class="text-2xl font-bold text-green-600">{{ $totalHoy }} kg</h2>
                </div>

                <div class="bg-white p-4 rounded-xl shadow">
                    <p class="text-gray-500 text-sm">Total general</p>
                    <h2 class="text-2xl font-bold text-blue-600">{{ $totalGeneral }} kg</h2>
                </div>

            </div>

            <!-- PORCENTAJES -->
            <div class="bg-white p-6 rounded-xl shadow">
                <h3 class="text-lg font-semibold mb-4">Distribución por material</h3>

                @foreach($porcentajes as $p)
                    <div class="mb-3">
                        <div class="flex justify-between text-sm">
                            <span>{{ ucfirst($p->material) }}</span>
                            <span>{{ number_format($p->porcentaje, 1) }}%</span>
                        </div>

                       <div class="h-2 rounded-full"
     style="
        width: {{ $p->porcentaje }}%;
        background:
        @if($p->material == 'plastico') #3b82f6
        @elseif($p->material == 'carton') #f59e0b
        @elseif($p->material == 'vidrio') #10b981
        @elseif($p->material == 'metal') #6b7280
        @else #8b5cf6
        @endif;
     ">
</div>
                    </div>
                @endforeach
            </div>

        </div>

        <!-- DERECHA -->
        <div class="space-y-6">

            <div class="bg-white p-5 rounded-xl shadow">
                <h2 class="text-md font-semibold mb-2">Últimos registros</h2>

                @foreach($ultimos as $p)
                    <div class="flex justify-between border-b pb-1 text-sm">
                        <span>{{ ucfirst($p->material) }}</span>
                        <span>{{ $p->peso }} kg</span>
                    </div>
                @endforeach
            </div>

            <a href="/pesajes/create"
               class="block text-center bg-blue-600 text-white py-3 rounded-xl">
                Registrar pesaje
            </a>

        </div>

    </div>

</div>

</x-app-layout>