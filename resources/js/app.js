/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import Vue from 'vue'
import vuetify from './plugins/vuetify' // path to vuetify export
import App from './components/App';
import router from './router'
import store from './store'
import Api  from './Sources/Api'

window.EventBus = new Vue();
window.version = '0.5.0';

Vue.prototype.$api = Api;

new Vue({
    vuetify,
    router,
    store,
    render: h => h(App)
}).$mount('#app');
