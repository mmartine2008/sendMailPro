<x-app-layout>
    <div class="max-w-3xl mx-auto p-6">

        <h1 class="text-2xl font-semibold mb-6">Editar Configuración SMTP</h1>

        <form action="{{ route('smtp.update', $smtp) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            @include('smtp.partials.form')

            <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Guardar Cambios
            </button>
        </form>

    </div>
</x-app-layout>
