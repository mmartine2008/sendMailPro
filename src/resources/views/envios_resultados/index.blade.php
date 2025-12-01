<x-app-layout>

    <div class="max-w-7xl mx-auto py-8">

        <h2 class="text-2xl font-semibold mb-6">Resultados de Envíos</h2>

        <div class="bg-white shadow rounded p-4">

            <!-- Scroll vertical limitado -->
            <div class="overflow-y-scroll" style="max-height: 500px;">

                <table class="min-w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-100 border-b">
                            <th class="py-2 px-3">ID</th>
                            <th class="py-2 px-3">Fecha Envío</th>
                            <th class="py-2 px-3">Cuenta</th>
                            <th class="py-2 px-3">Resultado</th>
                            <th class="py-2 px-3">Programación</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($resultados as $r)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="py-2 px-3">{{ $r->id }}</td>
                                <td class="py-2 px-3">{{ $r->fecha_envio }}</td>
                                <td class="py-2 px-3">
                                    {{ $r->cuenta->nombre ?? 'Sin cuenta' }}
                                </td>
                                <td class="py-2 px-3">
                                    @if ($r->resultado === 'OK')
                                        <span class="text-green-600 font-semibold">OK</span>
                                    @else
                                        <span class="text-red-600 font-semibold">{{ $r->resultado }}</span>
                                    @endif
                                </td>
                                <td class="py-2 px-3">{{ $r->programacion_id }}</td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>
        </div>
    </div>

</x-app-layout>
