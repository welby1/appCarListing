import axios from "axios";

export const user =  {
    namespaced: true,
    state: () => ({
        status: 0,
        userData: null
    }),
    mutations: {
        USER_LOGGED_IN(state){
            state.status = 1;
        },
        USER_LOGGED_OUT(state){
            state.status = 0;
        },
        SET_USER_DATA(state, user){
            state.userData = user;
        },
        DELETE_USER_DATA(state){
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
            commit('USER_LOGGED_IN');
        },
        userLoggedOut({ commit }){
            commit('USER_LOGGED_OUT');
        },
        setUserData({ commit }){
            axios.get('/api/user').then((response)=>{
                commit('SET_USER_DATA', response.data);
            });
        },
        deleteUserData({ commit }){
            commit('DELETE_USER_DATA');
        }

    }
}