<x-app-layout>

    <div class="max-w-4xl mx-auto p-6">

        <!-- Title -->
        <h1 class="text-2xl font-semibold text-gray-800 mb-6">Emails</h1>

        <!-- New Email Button -->
        <a href="{{ route('emails.create') }}"
           class="inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition mb-6">
            Nuevo Email
        </a>

        <!-- CSV Import Form -->
        <form action="{{ route('emails.import') }}" method="POST" enctype="multipart/form-data"
              class="flex items-center gap-4 mb-6 bg-gray-100 p-4 rounded">
            @csrf

            <input type="file" name="csv_file" required
                   class="border border-gray-300 p-2 rounded w-full">

            <button type="submit"
                    class="bg-gray-700 text-white px-4 py-2 rounded hover:bg-gray-800 transition">
                Importar CSV
            </button>
        </form>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white shadow rounded">
                <thead>
                    <tr class="bg-gray-200 text-gray-700">
                        <th class="py-2 px-4 text-left">#</th>
                        <th class="py-2 px-4 text-left">Email</th>
                        <th class="py-2 px-4 text-left">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($emails as $email)
                        <tr class="border-b">
                            <td class="py-2 px-4">{{ $email->id }}</td>
                            <td class="py-2 px-4">{{ $email->email }}</td>
                            <td class="py-2 px-4 flex items-center gap-3">

                                <a href="{{ route('emails.edit', $email) }}"
                                   class="text-blue-600 hover:underline">
                                    Editar
                                </a>

                                <form action="{{ route('emails.destroy', $email) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
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

        <!-- Pagination -->
        <div class="mt-4">
            {{ $emails->links() }}
        </div>

    </div>

</x-app-layout>
