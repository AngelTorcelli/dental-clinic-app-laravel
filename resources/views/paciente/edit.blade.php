<x-app-layout>
    <x-slot name="header">

    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 text-center">

                    Editar paciente
                </h2>
                <div id="modal" class=" flex items-center justify-center ">

                    <div class="bg-transparent p-6 rounded-lg shadow-lg w-full text-gray-300">

                        <form method="POST" action="{{ route('paciente.update', $paciente->id) }}">
                            @csrf
                            @method('PUT') <!-- IMPORTANTE para enviar el método PUT -->

                            <div class="mb-4">
                                <label for="name" class="block text-sm font-medium">Nombre</label>
                                <input type="text" name="name" id="name" value="{{ old('name', $paciente->name) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                            </div>

                            <div class="mb-4">
                                <label for="email" class="block text-sm font-medium">Email</label>
                                <input type="email" name="email" id="email" value="{{ old('email', $paciente->email) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                            </div>

                            <div class="mb-4">
                                <label for="telefono" class="block text-sm font-medium">Teléfono</label>
                                <input type="text" name="telefono" id="telefono" value="{{ old('telefono', $paciente->telefono) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                            </div>

                            <!-- Opcional: si no deseas cambiar la contraseña, puedes omitir estos campos -->
                            <div class="mb-4">
                                <label for="password" class="block text-sm font-medium">Contraseña (opcional)</label>
                                <input type="password" name="password" id="password" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            </div>

                            <div class="mb-4">
                                <label for="password_confirmation" class="block text-sm font-medium">Confirmar Contraseña</label>
                                <input type="password" name="password_confirmation" id="password_confirmation" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            </div>

                            <div class="flex justify-end">
                                <button type="submit" class="button">Actualizar</button>
                            </div>
                        </form>


                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>