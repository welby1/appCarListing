import Vue from 'vue';
import Vuex from 'vuex';
import createPersistedState from "vuex-persistedstate";

import { user } from './modules/user/user.js'

Vue.use(Vuex);

export const store = new Vuex.Store({
    modules: {
        user,
    },
    plugins: [createPersistedState()]
});
