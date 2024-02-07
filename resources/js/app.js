/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

//require('./bootstrap');

window.Vue = require('vue').default;
window.axios = require('axios');

//import Vue from 'vue'
import Buefy from 'buefy'
// import 'buefy/dist/buefy.css'

//QR Scanner
import VueQrcodeReader from "vue-qrcode-reader";
//for QR CODE Generation
import VueQrcode from '@chenfengyuan/vue-qrcode';
import { times } from 'lodash';




/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

const files = require.context('./', true, /\.vue$/i)
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

//Vue.component('example-component', require('./components/ExampleComponent.vue').default);

//Vue.component('navbar-component', require('./components/Administrator/NavbarComponent.vue').default);
//Vue.component('home-page', require('./components/HomePage.vue').default);
//Vue.component('register-components', require('./components/SignupComponent.vue').default);


//USER
//Vue.component('user-page', require('./components/Administrator/User/UserPage.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */


Vue.use(Buefy)

//Vue.use(VueQrcodeReader); //https://gruhn.github.io/vue-qrcode-reader/demos/CustomTracking.html
//Vue.component(VueQrcode.name, VueQrcode);


Vue.filter('formatTime', function(value) {
    var timeString = value;
    var H = +timeString.substr(0, 2);
    var h = (H % 12) || 12;
    var ampm = H < 12 ? " AM" : " PM";
    timeString = h + timeString.substr(2, 3) + ampm;
    return timeString;
});


Vue.filter('formatDateAndTime', function(value) {
    let myDate = new Date(value)

    let realDate =
        myDate.getFullYear() +
        "-" +
        ("0" + (myDate.getMonth() + 1)).slice(-2) +
        "-" +
        ("0" + myDate.getDate()).slice(-2);

    let realTime =
        myDate.getHours() +
        ':' +
        ('0' + myDate.getMinutes()).slice(-2) +
        ':' +
        ('0' + myDate.getSeconds()).slice(-2);


    let timeString = myDate.toLocaleTimeString();
    // return timeString;
    
    // let H = +timeString.substr(0, 2);
    // let h = (H % 12) || 12;
    // let ampm = H < 12 ? " AM" : " PM";
    // timeString = h + timeString.substr(2, 3) + ampm;

    return realDate + ' ' + timeString
});




Vue.prototype.$formatDate = function(value) {
    if (!value) return '';
    
    const date = new Date(value);
    const year = date.getFullYear();
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const day = String(date.getDate()).padStart(2, '0');
    return `${year}-${month}-${day}`;
};



Vue.prototype.$formatTime = function(value) {
    var timeString = value;
    var H = +timeString.substr(0, 2);
    var h = (H % 12) || 12;
    var ampm = H < 12 ? " AM" : " PM";
    timeString = h + timeString.substr(2, 3) + ampm;
    return timeString;
};

Vue.use(VueQrcodeReader); //https://gruhn.github.io/vue-qrcode-reader/demos/CustomTracking.html
Vue.component(VueQrcode.name, VueQrcode);



const app = new Vue({
    el: '#app',
});
