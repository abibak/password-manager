import axios from "axios";
import {instance} from '@/store/index';
import router from "@/router";

if (!localStorage.getItem('authToken')) {
  localStorage.setItem('authToken', '');
}

export default {
  namespaced: true,

  state: () => ({
    userData: null,
  }),

  getters: {},

  mutations: {
    setUserData(state, data) {
      state.userData = data;
    }
  },

  actions: {
    async getUserData({commit}) {
      await instance.get(process.env.VUE_APP_API_URL + 'getAuth')
        .then(response => {
          commit('setUserData', response.data);
        }).catch(error => {
          console.log(error);
        });
    },

    async sendLoginRequest({state, commit}, data) {
        await instance.post(process.env.VUE_APP_API_URL + 'login', {
          email: data.email,
          password: data.password,
        }).then(response => {
          if (state.userData !== null || state.userData !== {}) {
            commit('setUserData', response.data.user);
            localStorage.setItem('authToken', response.data['access_token'] ?? '');
            router.push('/');
          }
        }).catch(error => {
            if (error.response?.status === 401) {
              commit('setErrors', error.response.data.messages, {root: true});
            }
        });
    },

    async logout({commit}) {
      await instance.get(process.env.VUE_APP_API_URL + 'logout').then(() => {
        commit('setUserData', null);
        localStorage.removeItem('authToken');
      });
    },
  },
}
