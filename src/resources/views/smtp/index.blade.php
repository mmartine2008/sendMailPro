<x-app-layout>

    <div class="max-w-5xl mx-auto p-6">

        <h1 class="text-2xl font-semibold mb-6">Configuraciones SMTP</h1>

        <a href="{{ route('smtp.create') }}"
           class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition mb-6 inline-block">
            Nueva Configuración
        </a>

        @if (session('success'))
            <div class="bg-green-100 text-green-800 p-3 mb-4 rounded">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto bg-white shadow rounded">
            <table class="min-w-full">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="px-4 py-2 text-left">ID</th>
                        <th class="px-4 py-2 text-left">Host</th>
                        <th class="px-4 py-2 text-left">Usuario</th>
                        <th class="px-4 py-2 text-left">Puerto</th>
                        <th class="px-4 py-2 text-left">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($configs as $config)
                        <tr class="border-b">
                            <td class="px-4 py-2">{{ $config->id }}</td>
                            <td class="px-4 py-2">{{ $config->host }}</td>
                            <td class="px-4 py-2">{{ $config->username }}</td>
                            <td class="px-4 py-2">{{ $config->port }}</td>
                            <td class="px-4 py-2 flex gap-3">

                                <a href="{{ route('smtp.edit', $config) }}"
                                   class="text-blue-600 hover:underline">
                                    Editar
                                </a>

                                <form action="{{ route('smtp.destroy', $config) }}"
                                      method="POST">
                                    @csrf @method('DELETE')
                                    <button class="text-red-600 hover:underline">
                                        Eliminar
                                    </button>
                                </form>

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">{{ $configs->links() }}</div>

    </div>

</x-app-layout>
