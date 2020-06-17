require('./bootstrap');


import {FontAwesomeIcon} from '@fortawesome/vue-fontawesome';
import { dom } from '@fortawesome/fontawesome-svg-core'
dom.watch();

import datables from 'datatables.net-bs4';

window.Vue = require('vue');
Vue.component('card', require('./components/Card').default);
Vue.component('form-group', require('./components/form/FormGroup').default);

const app = new Vue({
    el: '#app',
});
