require('./bootstrap');

window.Vue = require('vue').default;
import router from './router'

Vue.component('notfoundcomponent', require('./views/NotFoundComponent.vue').default);

const app = new Vue({
    router: router,
    el: '#app',
});
