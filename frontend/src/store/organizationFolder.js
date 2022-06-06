import {instance} from "@/store";

// STORE IN QUESTION

export default {
  namespaced: true,

  state: () => ({
    showInviteFolder: false,
    userAccess: null,
  }),

  getters: {},

  mutations: {
    setShowInviteFolder(state, val) {
      state.showInviteFolder = val;
    },

    setUserAccess(state, val) {
      state.userAccess = val;
    },
  },

  actions: {
    async sendInviteToFolder({dispatch, commit}, data) {
      await instance.post(process.env.VUE_APP_API_URL + 'access/folder', data).then(() => {
        dispatch('folder/sendRequestGetOrganizationFolders', null, {root: true});
      }).catch(error => {
        commit('setMessages', {messages: error.response.data, typeMessage: 'error'}, {root: true});
      });
    },
  },
}
