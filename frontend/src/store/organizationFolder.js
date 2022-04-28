import {instance} from "@/store";

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
    async sendInviteToFolder({dispatch, state}, data) {
      await instance.post(process.env.VUE_APP_API_URL + 'access/folder', data).then(() => {
        dispatch('folder/sendRequestGetOrganizationFolders', null, {root: true});
      });
    },
  },
}
