import {instance} from "@/store";
import router from "@/router";

export default {
  namespaced: true,

  state: () => ({
    userData: '',
    authToken: '',
    isAuth: false,
    isActive: true,
    lastTimeActive: null,
    timeout: 600000, // 600000 ms = 10 minutes
  }),

  getters: {
    getAuthToken(state) {
      return state.authToken;
    },

    getIsAuth(state) {
      return state.isAuth;
    },
  },

  mutations: {
    setUserData(state, data) {
      state.userData = data;
    },

    setAuthToken(state, token) {
      state.authToken = token;
    },

    setIsAuth(state, value) {
      state.isAuth = value;
    },

    setLastTimeActive(state, value) {
      state.lastTimeActive = value;
    },

    setIsActive(state, value) {
      state.isActive = value;
    }
  },

  actions: {
    async getUserData({state, commit}) {
      await instance.get(process.env.VUE_APP_API_URL + 'getUser')
        .then(response => {
          commit('setUserData', response.data);

          if (state.isAuth === null || state.isAuth === false) {
            commit('setAuthToken', localStorage.getItem('authToken'));
            commit('setIsAuth', true);
          }
        }).catch(() => {
          localStorage.setItem('authToken', '');
          router.push('/login');
        });
    },

    async sendLoginRequest({state, commit}, data) {
      await instance.post(process.env.VUE_APP_API_URL + 'login', {
        email: data.email,
        password: data.password,
      }).then(response => {
        if (state.userData !== null || state.userData !== {}) {
          localStorage.setItem('authToken', response.data['access_token']);
          commit('setAuthToken', response.data['access_token']);
          commit('setUserData', response.data.user);
          commit('setIsAuth', true);
          router.push('/');
        }
      }).catch(error => {
        if (error.response?.status === 400 || error.response?.status === 401) {
          commit('setErrors', error.response.data.message, {root: true});
        }
      })
    },

    async logout({commit}) {
      await instance.get(process.env.VUE_APP_API_URL + 'logout').then(() => {
        commit('setUserData', null);
        commit('setAuthToken', '');
        commit('setIsAuth', false);
        localStorage.setItem('authToken', '');
        router.push('login');
      });
    },
  },
}
