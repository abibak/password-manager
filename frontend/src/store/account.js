import {instance} from "@/store";
import store from '@/store';


export default {
  namespaced: true,

  state: () => ({

  }),

  getters: {

  },

  mutations: {

  },

  actions: {
    async changeStatusDeactivateAccount({commit}, userId) {
      await instance.get(process.env.VUE_APP_API_URL + 'user/account/deactivate/' + userId).then(response => {
        commit('setUserStatusDeactivate', response.data, {root: true});
      })
    },

    async sendRequestUpdateSettingsAccount({dispatch}, data) {
      const userId = store.state.auth.userData.id;

      let requestData = {
        login: data.login,
        email: data.email,
        'email_notification': data.emailNotification,
        'auto_logout': data.autoLogout,
      }

      await instance.put(process.env.VUE_APP_API_URL + 'user/account/' + userId, requestData).then(response => {
        console.log(response);

        if (response.status === 200) {
          dispatch('auth/getUserData', null, {root: true});
        }
      })
    },
  },
}
