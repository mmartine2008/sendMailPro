<x-app-layout>
    <div class="max-w-7xl mx-auto py-8">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-semibold">Cuentas</h2>

            <a href="{{ route('cuentas.create') }}"
               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                Nueva Cuenta
            </a>
        </div>

        <div class="bg-white shadow rounded p-6">
            <table class="min-w-full">
                <thead>
                    <tr>
                        <th class="text-left py-2 border-b">ID</th>
                        <th class="text-left py-2 border-b">Nombre</th>
                        <th class="text-left py-2 border-b">SMTP</th>
                        <th class="text-left py-2 border-b">Activa</th>
                        <th class="text-left py-2 border-b">Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($cuentas as $cuenta)
                        <tr class="border-b">
                            <td class="py-2">{{ $cuenta->id }}</td>
                            <td class="py-2">{{ $cuenta->nombre }}</td>
                            <td class="py-2">
                            @if ($cuenta->SmtpConfig->host)
                                {{ $cuenta->SmtpConfig->host }}
                            @else
                                <span class="text-gray-500">Sin asignar</span>
                            @endif
                            </td>
                            <td class="py-2">
                                @if ($cuenta->activa)
                                    <span class="text-green-600 font-semibold">Sí</span>
                                @else
                                    <span class="text-red-600 font-semibold">No</span>
                                @endif
                            </td>
                            <td class="py-2 flex gap-2">

                                {{-- Editar --}}
                                <a href="{{ route('cuentas.edit', $cuenta) }}"
                                   class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded">
                                    Editar
                                </a>

                                {{-- Eliminar --}}
                                <form action="{{ route('cuentas.destroy', $cuenta) }}" method="POST"
                                      onsubmit="return confirm('¿Seguro que deseas eliminar esta cuenta?')">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded">
                                        Eliminar
                                    </button>
                                </form>

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
