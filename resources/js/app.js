require('./bootstrap');

// Load Vue
import Vue from 'vue'

// Load layout
import App from './layouts/App.vue';

// Load axios settings
import axios from './axios.js'
Vue.prototype.$http = axios

//Load Api routes
import { api } from './api.js';
Vue.prototype.$api = api;

window.Vue = require('vue').default;

window.onload = function () {
    new Vue({
        render: h => h(App)
    }).$mount('#app')
}
