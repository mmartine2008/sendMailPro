<x-app-layout>
    <div class="container mx-auto p-4">

        <h1 class="text-xl mb-4">Editar Email</h1>

        <form action="{{ route('emails.update', $email) }}" method="POST">
            @csrf @method('PUT')

            <label>Email:</label>
            <input type="email" name="email" value="{{ $email->email }}" class="border" required>

            <button class="btn btn-primary mt-2">Actualizar</button>
        </form>

    </div>
</x-app-layout>
