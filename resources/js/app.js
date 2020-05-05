/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
import Vue from 'vue';
import Vuelidate from "vuelidate";
require('./bootstrap');

Vue.use(Vuelidate);

import RegisterForm from './components/authenticate/RegisterForm';
import LoginForm from "./components/authenticate/LoginForm";
import LogoutButton from "./components/authenticate/LogoutButton";
import EditProfileForm from "./components/authenticate/EditProfileForm";

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('register-form', RegisterForm);
Vue.component('login-form', LoginForm);
Vue.component('logout-button', LogoutButton);
Vue.component('edit-profile-from', EditProfileForm);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    data: {}
});

