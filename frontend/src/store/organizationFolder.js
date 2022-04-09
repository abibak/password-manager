import {instance} from "@/store/index";

export default {
  namespaced: true,

  state: () => ({
    dataOrganizationFolders: [],
    selectedOrgFolderId: null,
    selectedOrgLoginId: null,
    showInviteFolder: false,
    userAccess: null,
  }),

  getters: {
    getOrgLogins(state) {
      return state.dataOrganizationFolders.data.filter(folder => folder.id === state.selectedOrgFolderId);
    },

    getDataOrgOpenLogin(state) {
      const folder = state.dataOrganizationFolders.data ?? [];

      for (let i = 0; i < folder.length; i++) {
        if (folder[i].id === state.selectedOrgFolderId) {
          return folder[i].logins.filter(login => login.id === state.selectedOrgLoginId)[0];
        }
      }
    },
  },

  mutations: {
    setDataFolders(state, data) {
      state.dataOrganizationFolders = data;
    },

    setSelectedOrgFolderId(state, val) {
      state.selectedOrgFolderId = val;
    },

    setSelectedOrgLoginId(state, val) {
      state.selectedOrgLoginId = val;
    },

    setShowInviteFolder(state, val) {
      state.showInviteFolder = val;
    },

    setUserAccess(state, val) {
      state.userAccess = val;
    },
  },

  actions: {
    async sendRequestGetOrganizationFolders({commit}) {
      await instance.get(process.env.VUE_APP_API_URL + 'user/organization/folder', {
        headers: {'Authorization': 'Bearer ' + localStorage.getItem('authToken')}
      }).then(response => {
        console.log(response.data);
        commit('setDataFolders', response.data);
      });
    },

    async sendRequestCreateOrgFolder({dispatch}, nameFolder) {
      await instance.post(process.env.VUE_APP_API_URL + 'user/organization/folder', {
        name: nameFolder,
      }, {
        headers: {
          'Authorization': 'Bearer ' + localStorage.getItem('authToken'),
        }
      }).then(response => {
        if (response.status === 201) {
          dispatch('sendRequestGetFolders');
        }
      });
    },

    async sendRequestGetFolders({commit}) {
      await instance.get(process.env.VUE_APP_API_URL + 'user/organization/folder', {
        headers: {'Authorization': 'Bearer ' + localStorage.getItem('authToken')}
      }).then(response => {
        commit('setDataFolders', response.data);
      });
    },

    async sendInviteToFolder({state}, data) {
      data.organization_folder_id = state.selectedOrgFolderId;
      await instance.post(process.env.VUE_APP_API_URL + 'access/folder', data);
    },
  },
}
