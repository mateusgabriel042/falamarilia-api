/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import AppSettingsComponent from './components/AppSettingsComponent'

window.Vue = require('vue');

Vue.component('app-settings-component', AppSettingsComponent);

new Vue({
    el: 'div#root'
})
