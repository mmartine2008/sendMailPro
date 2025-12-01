<x-app-layout>
    <div class="container mx-auto p-4">

        <h1 class="text-xl mb-4">Agregar Email</h1>

        <form action="{{ route('emails.store') }}" method="POST">
            @csrf

            <label>Email:</label>
            <input type="email" name="email" class="border" required>

            <button class="btn btn-primary mt-2">Guardar</button>
        </form>

    </div>
</x-app-layout>
