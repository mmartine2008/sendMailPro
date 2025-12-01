<x-app-layout>
    <div class="max-w-6xl mx-auto py-8">

        <div class="flex justify-between mb-6">
            <h2 class="text-2xl font-semibold">Mensajes programados</h2>
            <a href="{{ route('mensajes.create') }}"
               class="bg-blue-600 text-white px-4 py-2 rounded">Nuevo Mensaje</a>
        </div>

        <div class="bg-white shadow rounded p-6">
            <table class="min-w-full">
                <thead>
                    <tr>
                        <th class="text-left py-2 border-b">ID</th>
                        <th class="text-left py-2 border-b">Inicio</th>
                        <th class="text-left py-2 border-b">Fin</th>
                        <th class="text-left py-2 border-b">Subject</th>
                        <th class="text-left py-2 border-b">Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($mensajes as $mensaje)
                        <tr class="border-b">
                            <td class="py-2">{{ $mensaje->id }}</td>
                            <td class="py-2">{{ $mensaje->start_date ?? '-' }}</td>
                            <td class="py-2">{{ $mensaje->end_date ?? '-' }}</td>
                            <td class="py-2">{{ $mensaje->subject }}</td>

                            <td class="py-2 flex gap-2">
                                <a href="{{ route('mensajes.edit', $mensaje) }}"
                                   class="bg-yellow-500 text-white px-3 py-1 rounded">Editar</a>

                                <form action="{{ route('mensajes.destroy', $mensaje) }}" method="POST"
                                      onsubmit="return confirm('¿Eliminar mensaje?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="bg-red-600 text-white px-3 py-1 rounded">
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
