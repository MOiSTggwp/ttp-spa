import Vue from 'vue';
import Index from './components/index';
import router from './router/router';
import store from './modules/store';
import UI from './UI/lib';
import { mapActions } from 'vuex';

require('./bootstrap');

UI.forEach(component => {
    Vue.component(component.name, component);
})

new Vue({
    el: '#app',
    components: {
        Index,
    },
    created() {
        this.SET_DATA();
    },
    methods: {
      ...mapActions(["SET_DATA"])
    },
    store,
    router
})
