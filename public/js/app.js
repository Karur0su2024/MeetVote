import { Tooltip } from 'bootstrap';


// Inicializace Bootstrap tooltips
const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new Tooltip(tooltipTriggerEl));

import moment from 'moment';

document.addEventListener('DOMContentLoaded', function() {
    // Získání aktuálního stavu tmavého režimu z HTML tagu

    document.documentElement.setAttribute('data-bs-theme', localStorage.getItem('theme') ?? 'light');
    let iconElement = document.getElementById('darkmode-toggle-icon');
    if (localStorage.getItem('theme') === 'dark') {
        iconElement.className = 'bi bi-moon-fill';
    } else {
        iconElement.className = 'bi bi-brightness-high-fill';
    }


// Funkce pro přepnutí režimu



});
