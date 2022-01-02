require('./bootstrap');

import Vue from 'vue';
import VueRouter from 'vue-router';

//import routes file
import { routes } from './routes';

//import user class
import User from './Helpers/User';
window.User = User

//import Notification (Noty)
import Notification from './Helpers/Notification';
window.Notification = Notification

//import sweet alert2 js
import Swal from 'sweetalert2'
window.Swal = Swal

const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
});

window.Toast = Toast;

window.Reload = new Vue();

Vue.use(VueRouter)

const router = new VueRouter({
    routes: routes,
    mode: 'history',
    base
})

const app = new Vue({
    el: '#app',
    router
});