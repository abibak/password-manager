import {instance} from "@/store";

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

    setPasswordInDataFolder(state, values) {
      state.dataOrganizationFolders.data[values.id].logins.push(values.login);
    },
  },

  actions: {
    async sendRequestGetOrganizationFolders({commit}) {
      await instance.get(process.env.VUE_APP_API_URL + 'organization/folder').then(response => {
        commit('setDataFolders', response.data);
      });
    },


    async sendRequestCreateOrgFolder({dispatch}, nameFolder) {
      await instance.post(process.env.VUE_APP_API_URL + 'organization/folder', {
        name: nameFolder,
      }).then(response => {
        if (response.status === 201) {
          dispatch('sendRequestGetFolders');
        }
      });
    },

    searchFolderById({state}) {
      const obj = state.dataOrganizationFolders.data;

      // поиск папки и получение идентификатора
      for (let i = 0; i < obj.length; i++) {
        if (obj[i].id === state.selectedOrgFolderId) {
          return i; // индекс по списку dataFolder
        }
      }
    },

    async sendRequestCreateOrgPassword({state, dispatch, commit}, data) {
      await instance.post(process.env.VUE_APP_API_URL + 'organization/login', {
        organization_folder_id: state.selectedOrgFolderId,
        name: data.name,
        login: data.login,
        password: data.password,
        url: data.url,
        note: data.note,
        tag: data.tags,
      }).then(response => {
        console.log(response);
        if (response.status === 201) {
          dispatch('searchFolderById').then(data => {
            return commit('setPasswordInDataFolder', {
              id: data,
              login: response.data.data[0],
            });
          });
        }
      }).catch(error => {
        console.log(error.response);
      });
    },

    async sendRequestGetFolders({commit}) {
      await instance.get(process.env.VUE_APP_API_URL + 'organization/folder').then(response => {
        commit('setDataFolders', response.data);
      });
    },

    async sendRequestDeleteOrgFolder({state, commit, dispatch}) {
      console.log('test');
      await instance.delete(process.env.VUE_APP_API_URL + 'organization/folder/' + state.selectedOrgFolderId).then(() => {
        commit('setShowSectionSelectedFolder', false, {root: true});
        dispatch('sendRequestGetFolders');
      });
    },

    async sendInviteToFolder({dispatch, state}, data) {
      data.organization_folder_id = state.selectedOrgFolderId;
      await instance.post(process.env.VUE_APP_API_URL + 'access/folder', data).then(() => {
        dispatch('sendRequestGetOrganizationFolders');
      });
    },
  },
}
