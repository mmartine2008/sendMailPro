<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Editar Cuenta
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-sm sm:rounded-lg p-6">

                <form method="POST" action="{{ route('cuentas.update', $cuenta) }}">
                    @csrf
                    @method('PUT')

                    <!-- Nombre -->
                    <div class="mb-4">
                        <label class="block font-medium">Nombre</label>
                        <input type="text" name="nombre"
                               class="w-full border rounded px-3 py-2"
                               value="{{ $cuenta->nombre }}">
                    </div>

                    <!-- Password -->
                    <div class="mb-4">
                        <label class="block font-medium">Password</label>
                        <input type="text" name="password"
                               class="w-full border rounded px-3 py-2"
                               value="{{ $cuenta->password }}">
                    </div>

                    <!-- SMTP dropdown -->
                    <div class="mb-4">
                        <label class="block font-medium">SMTP</label>
                        <select name="smtp_id" class="w-full border rounded px-3 py-2">
                            @foreach($smtps as $smtp)
                                <option value="{{ $smtp->id }}"
                                    @if($cuenta->smtp_id == $smtp->id) selected @endif>
                                    {{ $smtp->host }} ({{ $smtp->username }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex justify-end mt-6">
                        <a href="{{ route('cuentas.index') }}"
                           class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 mr-2">
                            Cancelar
                        </a>

                        <button type="submit"
                                class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                            Actualizar
                        </button>
                    </div>

                </form>

            </div>

        </div>
    </div>

</x-app-layout>
