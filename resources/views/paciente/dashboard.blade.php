<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100 flex flex-col text-sm">
                    <!-- alinear abajo el texto y el icono-->
                    <div class="flex justify-center items-center text-center
                    ">
                        <x-heroicon-o-calendar-days class="text-gray-500" style="width: 3rem;" />
                        <h2 class=" font-semibold text-xl dark:text-gray-200 align-bottom flex-1">
                            Hola {{ Auth::user()->name }}, tus siguientes citas son:
                        </h2>
                    </div>
                    <table class="table mt-3">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Fecha</th>
                                <th>Hora</th>
                                <th>Doctor</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($citas as $cita)
                            <tr>
                                <td>{{ $cita->id }}</td>
                                <td>{{ $cita->fecha }}</td>
                                <td>{{ $cita->hora }}</td>
                                <td>{{ $cita->doctor->name }}</td>
                                <td>{{ $cita->estado }}</td>

                            </tr>
                            @endforeach
                        </tbody>


                </div>
            </div>
        </div>
    </div>
</x-app-layout>