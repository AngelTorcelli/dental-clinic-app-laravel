<!-- this will be the receptionist dashboard for the clinic -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h2>Recepcionista</h2>
                    <p>Bienvenido al Dashboard de Recepcionista</p>
                    <p>Desde aquí podrás gestionar las citas de los pacientes, ver su historial médico y mucho más.</p>
                    <p>Utiliza el menú de navegación para acceder a las diferentes secciones del sistema.</p>

                </div>
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h2>Funciones</h2>
                    <ul>
                        <li>Gestionar citas</li>
                        <li>Ver historial médico de pacientes</li>
                        <li>Actualizar información de pacientes</li>
                        <li>Enviar recordatorios de citas</li>
                    </ul>
                    <p>Si tienes alguna duda, no dudes en contactar con el administrador del sistema.</p>
                    <p>¡Gracias por utilizar nuestro sistema de gestión de citas médicas!</p>

                </div>

            </div>
        </div>
    </div>
</x-app-layout>