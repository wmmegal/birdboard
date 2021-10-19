require('./bootstrap');

import Vue from "vue";
import vmodal from 'vue-js-modal';

Vue.use(vmodal)

Vue.component('new-project-modal', require('./components/NewProjectModal.vue').default);

new Vue({
    el: '#app'
});
