import axios from "axios";

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
    async getUserData() {
      await axios.get(process.env.VUE_APP_API_URL + 'getUser')
        .then(response => {
          console.log(response);
        }).catch(error => {
          console.log(error);
        }).then(() => {
          console.log('запрос выполнен')
        });
    },

    async sendLoginRequest({commit}, data) {
      try {
        let response = await axios.post(process.env.VUE_APP_API_URL + 'login', {
          email: data.email,
          password: data.password,
        });

        if (state.userData !== null || state.userData !== {}) {
          commit('setUserData', response.data.user);
          localStorage.setItem('authToken', response.data['access_token']);
        }
      } catch (e) {
        console.log('error');
      }
    },

    async logout({commit}) {
      await axios.get(process.env.VUE_APP_API_URL + 'logout').then(() => {
        commit('setUserData', null);
        localStorage.removeItem('authToken');
      });
    },
  },
}
