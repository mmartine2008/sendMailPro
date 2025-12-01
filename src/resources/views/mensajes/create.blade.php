<x-app-layout>
    <div class="max-w-4xl mx-auto py-8">
        <h2 class="text-2xl font-semibold mb-4">Nuevo mensaje programado</h2>

        <div class="bg-white shadow rounded p-6">
            <form method="POST" action="{{ route('mensajes.store') }}">
                @csrf

                <div class="mb-4">
                    <label class="font-medium">Fecha inicio</label>
                    <input type="date" name="start_date"
                           class="w-full border rounded px-3 py-2">
                </div>

                <div class="mb-4">
                    <label class="font-medium">Fecha fin</label>
                    <input type="date" name="end_date"
                           class="w-full border rounded px-3 py-2">
                </div>

                <div class="mb-4">
                    <label class="font-medium">Subject</label>
                    <input type="text" name="subject" maxlength="200"
                           class="w-full border rounded px-3 py-2" required>
                </div>

                <div class="mb-4">
                    <label class="font-medium">Body (HTML)</label>
                    <textarea name="body" class="wysiwyg w-full h-64" required></textarea>
                </div>

                <button class="bg-blue-600 text-white px-4 py-2 rounded">
                    Guardar
                </button>

            </form>
        </div>
    </div>
</x-app-layout>
