<x-app-layout>
    <x-slot name="header">
        <nav class="flex items-center justify-between">

            <a href="{{ route('citas') }} " type="button" class="button">Ver citas</a>

            <button id="openModal" class="button">Nuevo paciente</button>
        </nav>
    </x-slot>

    <h2 class="font-semibold text-xl dark:text-gray-200 text-center mb-4 mt-4">Listado de pacientes</h2>

    {{-- Modal --}}
    <div id="modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">

        <div class="bg-white p-6 rounded-lg shadow-lg w-1/2 max-w-md relative">

            <h3 class="text-lg font-bold mb-4">Crear nuevo paciente</h3>

            <form method="POST" action="{{ route('paciente.store') }}">
                @csrf
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium">Nombre</label>
                    <input type="text" name="name" id="name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                </div>

                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium">Email</label>
                    <input type="email" name="email" id="email" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                </div>

                <div class="mb-4">
                    <label for="telefono" class="block text-sm font-medium">Teléfono</label>
                    <input type="text" name="telefono" id="telefono" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                </div>

                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium">Contraseña</label>
                    <input type="password" name="password" id="password" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                </div>

                <div class="mb-4">
                    <label for="password_confirmation" class="block text-sm font-medium">Confirmar Contraseña</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="button">Crear</button>
                    <button id="closeModal" class="button-secondary">
                        Cerrar
                    </button>
                </div>

            </form>

        </div>
    </div>

    {{-- Tabla de pacientes --}}
    <table class="table bg-red-200" style="width: 80vw; margin: 0 auto; border: 5px solid #202020;">
        <thead>
            <tr>
                <th class="px-4 py-2">ID</th>
                <th class="px-4 py-2">Nombre</th>
                <th class="px-4 py-2">Email</th>
                <th class="px-4 py-2">Teléfono</th>
                <th class="px-4 py-2">Acciones</th>
            </tr>
        </thead>
        <tbody>

            @foreach($pacientes as $paciente)

            <tr>
                <td class="px-4 py-2">{{ $paciente->id }}</td>
                <td class="px-4 py-2">{{ $paciente->name }}</td>
                <td class="px-4 py-2">{{ $paciente->email }}</td>
                <td class="px-4 py-2">{{ $paciente->telefono }}</td>
                <td class="px-4 py-2 flex gap-x-20">
                    <a href="{{ route('paciente.edit', $paciente->id) }}" class="flex items-center gap-1 text-blue-600" title="Editar paciente" "><x-heroicon-o-pencil class=" w-6 h-6 text-gray-500" />Editar</a>
                    <form action="{{ route('paciente.destroy', $paciente->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button class="btn error btn-sm flex " onclick="return confirm('¿Eliminar paciente?')"><x-heroicon-o-trash class="error w-6 h-6 text-gray-500" />Eliminar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- JS para abrir y cerrar el modal --}}
    <script>
        document.getElementById('openModal').addEventListener('click', function() {
            document.getElementById('modal').classList.remove('hidden');
        });

        document.getElementById('closeModal').addEventListener('click', function() {
            document.getElementById('modal').classList.add('hidden');
        });

        // Cerrar el modal si se hace clic fuera del contenido
        document.getElementById('modal').addEventListener('click', function(e) {
            if (e.target === this) {
                this.classList.add('hidden');
            }
        });
    </script>
</x-app-layout>