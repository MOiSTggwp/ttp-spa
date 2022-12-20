import Vue from 'vue';
import Vuex from 'vuex';
///MODULES//////////////////////////
import index from './lib';
///////////////////////////////////

Vue.use(Vuex);

export default new Vuex.Store({ modules: {...index} });
