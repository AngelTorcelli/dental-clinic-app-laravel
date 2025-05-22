<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">

                <div class="p-12 text-gray-900 dark:text-gray-100 flex flex-wrap justify-between">

                    <div class="p-12 px-2 text-gray-900 dark:text-gray-100">
                        <div id='calendar' style="width: 50vw;"></div>

                    </div>
                    <div class="py-2 px-2">
                        <div class="popup" id="popup" style="display:none; position:fixed; top:50%; left:50%; transform:translate(-50%, -50%); background-color:white; padding:30px; border-radius:10px; box-shadow:0 0 10px rgba(0,0,0,0.5); z-index:100; width:30vw;">
                            <p class="text-gray-800 w-full" id="contenido"></span></p>
                            <button id="closePopup" onclick="closePopup()" class="button">Cerrar</button>
                        </div>

                        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">

                                <div class="p-6 text-gray-900 dark:text-gray-100">
                                    <h2 class="text-xl">Crear cita</h2>
                                    <form action="{{ route('citas.store') }}" method="POST">
                                        @csrf
                                        <label for="date" class="block text-sm font-medium">Fecha</label>
                                        <input id="date" type="date" name="fecha" placeholder="Fecha" class="text-gray-800 w-full">
                                        <div class="mb-4">
                                            <label for="hora" class="block text-sm font-medium">Hora</label>
                                            <input id="hora" type="time" name="hora" placeholder="Hora" class="text-gray-800 w-full">
                                            @error('hora')
                                            <div class="text-red-600 text-sm mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <input required type="text" name="paciente_id" placeholder="ID del Paciente" class="text-gray-800">

                                        <input type="hidden" name="doctor_id" value="{{ Auth::user()->id }}" class="text-gray-800">

                                        <button type="submit" class="
                                                    button
                                                ">Crear Cita</button>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<style>
    #calendar {
        max-width: 100%;
        margin: 40px auto;
        padding: 10px;
        background: white;
        color: black;
    }
</style>
<!-- FullCalendar CSS -->
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css' rel='stylesheet' />

<!-- FullCalendar JS -->
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.17/index.global.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@fullcalendar/interaction@6.1.17/index.global.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');

        var calendar = new FullCalendar.Calendar(calendarEl, {
            editable: true, // permite mover eventos dentro del calendario
            droppable: true, // permite soltar eventos externos
            dayMaxEvents: true, // agrupa “+2 más” si hay muchos en un día

            eventDisplay: 'block',
            eventClassNames: function(arg) {
                // puedes asignar clases CSS dinámicas según estado, doctor, etc.
                return ['fc-card-event', 'estado-' + arg.event.extendedProps.estado];
            },

            initialView: 'dayGridMonth',
            locale: 'es', // Opcional: idioma español
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            buttonText: {
                today: 'Hoy',
                month: 'Mes',
                week: 'Semana',
                day: 'Día',
                list: 'Lista',
                prev: '<',
                next: '>'
            },
            events: '/citas-json',
            eventClick: function(info) {
                //alert('Cita: ' + info.event.title + '\nEstado: ' + info.event.extendedProps.estado);
                //pop-up con detalles de la cita enves de alert
                console.log(info.event.extendedProps);
                document.getElementById('popup').style.display = 'block';
                document.getElementById('contenido').innerHTML = `
                    <h2 class="text-xl text-gray-800 text-center my-20">Detalles de la cita</h2>
                    <p class="text-gray-800">Paciente: ${info.event.extendedProps.paciente}</p>
                    <p class="text-gray-800">Doctor: ${info.event.extendedProps.doctor}</p>
                    <p class="text-gray-800">Estado: ${info.event.extendedProps.estado}</p>
                    <p class="text-gray-800">Fecha: ${info.event.start.toLocaleDateString()}</p>
                    <p class="text-gray-800">Hora: ${info.event.start.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}</p>                    
                `;


            },
            dateClick: function(info) {
                const fechaSeleccionada = info.dateStr;

                // Rellenar automáticamente el campo de fecha en el formulario
                const inputFecha = document.querySelector('input[name="fecha"]');
                inputFecha.value = fechaSeleccionada;

                // Hacer scroll hasta el formulario
                document.querySelector('form[action="{{ route("citas.store") }}"]').scrollIntoView({
                    behavior: 'smooth'
                });

                // (Opcional) Enfocar el campo de hora
                document.querySelector('input[name="hora"]').focus();
            },
            eventDrop: function(info) {
                console.log(
                    JSON.stringify({
                        fecha: info.event.startStr.split('T')[0],
                        hora: info.event.start.toLocaleTimeString([], {
                            hour: '2-digit',
                            minute: '2-digit',
                            second: '2-digit',
                            hour12: false
                        })
                    }, null, 2) // Formato JSON para depuración
                )
                console.log(info.event._def.extendedProps.id);
                fetch(`/fecha/${info.event._def.extendedProps.id}`, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            fecha: info.event.startStr.split('T')[0],
                            hora: info.event.start.toLocaleTimeString([], {
                                hour: '2-digit',
                                minute: '2-digit',
                                second: '2-digit',
                                hour12: false
                            }),
                        })
                    })
                    .then(response => {
                        if (!response.ok) {
                            return response.json().then(err => {
                                throw err;
                            });
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log(data.message);
                    })
                    .catch(error => {
                        alert(error.message || 'Error al actualizar la cita');
                        info.revert(); // revierte el drag & drop si falla
                    });
            }
        });

        calendar.render();
    });



    document.getElementById('closePopup').addEventListener('click', function() {
        document.getElementById('popup').style.display = 'none';
    });

    function closePopup() {
        document.getElementById('popup').style.display = 'none';
    }
</script>