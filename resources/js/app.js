import './bootstrap';

import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import interactionPlugin from '@fullcalendar/interaction';


document.addEventListener('DOMContentLoaded', function() {
    initCalendar();
});

Livewire.hook('message.processed', (message, component) => {
    initCalendar();
});

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
