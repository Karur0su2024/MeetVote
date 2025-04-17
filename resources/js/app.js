import './bootstrap';

// popperjs
import('@popperjs/core');

// Bootstrap
import 'bootstrap';


// https://github.com/aliqasemzadeh/livewire-bootstrap-modal
// aliqasemzadeh/livewire-bootstrap-modal
import '../../vendor/aliqasemzadeh/livewire-bootstrap-modal/resources/js/modals.js';


import '../../public/js/app.js';
import '../../public/js/modal.js';

import 'moment';

// https://srwiez.com/posts/improved-handling-of-404-errors-with-livewire
document.addEventListener('livewire:init', () => {
    Livewire.hook('request', ({ fail }) => {
        fail(({ status, preventDefault }) => {
            if (status === 404) {
                window.location.reload();
                preventDefault()
            }
        })
    })
});
