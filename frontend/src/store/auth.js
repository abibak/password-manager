import {instance} from "@/store";
import router from "@/router";

const initialState = () => ({
  userData: '',
  authToken: '',
  isAuth: false,
  isActive: true,
  lastTimeActive: null,
  timeout: 600000, // 600000 ms = 10 minutes
});

export default {
  namespaced: true,

  state: initialState(),

  getters: {
    getAuthToken(state) {
      return state.authToken;
    },

    getIsAuth(state) {
      return state.isAuth;
    },
  },

  mutations: {
    resetState(state) {
      const initial = initialState();

      Object.keys(initial).forEach(key => {
        state[key] = initial[key];
      });
    },

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
      await instance.post(process.env.VUE_APP_API_URL + 'login', data).then(response => {
        if (state.userData !== null || state.userData !== {}) {
          localStorage.setItem('authToken', response.data.access_token);
          commit('setAuthToken', response.data.access_token);
          commit('setUserData', response.data.user);
          commit('setIsAuth', true);
          router.push('/');
        }
      }).catch(error => {
        if (error.response?.status === 400 || error.response?.status === 401) {
          commit('setMessages', {
            messages: error.response.data.message,
            typeMessage: 'error'
          }, {root: true});
        }
      })
    },

    async logout({commit}) {
      await instance.get(process.env.VUE_APP_API_URL + 'logout').then(() => {
        commit('resetState');
        commit('folder/resetState', null, {root: true});  // сброс состояний store "folder"
        localStorage.setItem('authToken', '');
        router.push('login');
      });
    },
  },
}
