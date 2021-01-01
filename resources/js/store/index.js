import Vuex from 'vuex';
import Vue from 'vue';
import componentStates from './componentStates';

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        componentStates
    }
});