<div>

    <form wire:submit.prevent="submit">



    </form>


</div>

<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>
<script>

    // Inicializace FullCalendar
    document.addEventListener('DOMContentLoaded', function() {
        initCalendar();
    });

    Livewire.hook('message.processed', (message, component) => {
        initCalendar();
    });

    // Inicializace Kalendáře
    function initCalendar() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            selectable: true,
            dateClick: function(info) {
                //https://stackoverflow.com/questions/77012223/error-only-arrays-and-traversables-can-be-unpacked-when-using-ckeditor-5-with
                Livewire.dispatch('addDate', {
                    date: info.dateStr
                });
            }

        });
        calendar.render();

    }
</script>
