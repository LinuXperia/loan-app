
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */


require('./bootstrap');

window.Vue = require('vue');

import InstantSearch from 'vue-instantsearch';
Vue.use(InstantSearch);

import VueLocalStorage from 'vue-localstorage'
Vue.use(VueLocalStorage)


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

//create new customer
Vue.component('new-customer', require('./customer/components/new/New.vue'));

//customer show and edit details components
Vue.component('personal-details', require('./customer/components/show/PersonalDetails.vue'))
Vue.component('next-of-kin-details', require('./customer/components/show/NextOfKinDetails.vue'))
Vue.component('bank-details', require('./customer/components/show/BankDetails.vue'))

Vue.component('avatar-upload', require('./customer/components/show/AvatarUpload.vue'))

//customer loan details
Vue.component('loan-details', require('./customer/components/loan/New.vue'))

//agent components
Vue.component('change-password', require('./agent/components/ChangePassword.vue'))

//loan payment
Vue.component('loan-payment', require('./customer/components/payment/LoanPayment.vue'))
Vue.component('approve-payment', require('./customer/components/payment/ApprovePayment.vue'))

//admin
Vue.component('agent-details', require('./admin/components/Agent-details.vue'))
Vue.component('approve-customer', require('./admin/components/ApproveCustomer.vue'))
Vue.component('approve-loan', require('./admin/components/ApproveLoan.vue'))


const app = new Vue({
    el: '#app'
});
