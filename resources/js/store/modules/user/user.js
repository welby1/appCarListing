import axios from "axios";

export const user =  {
    namespaced: true,
    state: () => ({
        status: 0,
        userData: null
    }),
    mutations: {
        USER_LOGGED_IN(state, user){
            state.status = 1;
            state.userData = user;
        },
        USER_LOGGED_OUT(state){
            state.status = 0;
            state.userData = null;
        }
    },
    getters: {
        getUserStatus(state){
            return state.status;
        },
        getUserData(state){
            return state.userData;
        }
    },
    actions: {
        userLoggedIn({ commit }){
            axios.get('/api/user').then((response)=>{
                commit('USER_LOGGED_IN', response.data);
            });
        },
        userLoggedOut({ commit }){
            commit('USER_LOGGED_OUT');
            window.localStorage.removeItem('vuex');
        }

    }
}