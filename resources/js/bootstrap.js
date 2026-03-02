import _ from 'lodash';
import * as Popper from '@popperjs/core';
import * as bootstrap from 'bootstrap';
import axios from 'axios';

window._ = _;
window.Popper = Popper;
window.bootstrap = bootstrap;

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Bootstrap 5 tooltip initialization.
 * Automatically initializes all tooltips on DOMContentLoaded.
 */
document.addEventListener('DOMContentLoaded', function () {
    const tooltipTriggerList = [].slice.call(
        document.querySelectorAll('[data-bs-toggle="tooltip"]')
    );
    tooltipTriggerList.forEach(function (el) {
        new bootstrap.Tooltip(el);
    });
});