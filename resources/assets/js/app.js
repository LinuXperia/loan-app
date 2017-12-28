
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */


require('./bootstrap');

window.Vue = require('vue');

import VueLocalStorage from 'vue-localstorage'

Vue.use(VueLocalStorage)


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('new-borrower', require('./borrower/components/new/New.vue'));

//borrower details components
Vue.component('personal-details', require('./borrower/components/show/PersonalDetails.vue'))
Vue.component('next-of-kin-details', require('./borrower/components/show/NextOfKinDetails.vue'))
Vue.component('bank-details', require('./borrower/components/show/BankDetails.vue'))

const app = new Vue({
    el: '#app'
});
